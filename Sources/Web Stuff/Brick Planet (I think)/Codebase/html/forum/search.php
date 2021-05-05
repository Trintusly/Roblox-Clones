<?php
$page = 'forum';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	if (isset($_SESSION['LastTopicName']) && isset($_SESSION['LastTopicID'])) {
	
		echo '
		<div class="grid-x grid-margin-x forum-top-links">
			<div class="auto cell">
				<div class="forum-navigation">
					<a href="'.$serverName.'/forum/topic/'.$_SESSION['LastTopicID'].'/">&laquo; Return to '.$_SESSION['LastTopicName'].'</a>
				</div>
			</div>
		</div>
		';
	
	}
	
	else {
		
		echo '
		<div class="grid-x grid-margin-x">
			<div class="auto cell">
				<div class="forum-navigation">
					<a href="'.$serverName.'/forum/">&laquo; Return to Forum Home</a>
				</div>
			</div>
		</div>
		';
		
	}
	
	$base = 1000;
	$power = pow(1.50, $myU->ForumLevel);
	$LevelMaxExp = $base*$power;
	
	if (!empty($_SESSION['LastTopicID']) && !isset($_GET['tid'])) {
		
		$TopicID = $_SESSION['LastTopicID'];
		
	}
	
	else if (!empty($_GET['tid'])) {
		
		$TopicID = htmlentities(strip_tags((int)$_GET['tid']));
		
	}
	
	else if (empty($_GET['tid']) || $_GET['tid'] == 0) {
		
		$TopicID = -1;
		
	}
	
	$Search = htmlentities(strip_tags($_GET['search']));
	
	echo '
	<script>document.title = "Search Forum - Brick Create";</script>
	<div class="grid-x grid-margin-x">
		<div class="large-9 cell">
			<div class="container-header md-padding">
				<strong>Search Forum</strong>
			</div>
			<div class="container border-wh md-padding">
				<form action="" method="GET">
					<table width="100%" cellspacing="0" cellpadding="0" class="search-table">
						<tr>
							<td width="30%">
								<b>Topic:</b>
							</td>
							<td>
								<select name="tid" id="tid" class="normal-input">
									<option value="0">Please select...</option>
									';
									
									$getTopics = $db->prepare("SELECT ID, Name FROM ForumTopic");
									$getTopics->execute();
									
									while ($gT = $getTopics->fetch(PDO::FETCH_OBJ)) {
										
										echo '
										<option value="'.$gT->ID.'"'; if ($TopicID == $gT->ID) { echo ' selected'; } echo '>'.$gT->Name.'</option>
										';
										
									}
									
									echo '
								</select>
							</td>
						</tr>
						<tr>
							<td width="30%">
								<b>Search Query:</b>
							</td>
							<td>
								<input type="text" name="search" id="search" class="normal-input"'; if (!empty($Search)) { echo ' value="'.$Search.'"'; } echo ' placeholder="Search...">
							</td>
						</tr>
					</table>
					<input type="submit" class="button button-green" value="Search">
				</form>
			</div>
			';
			
			if (!empty($TopicID) && !empty($Search)) {
				
				if ($TopicID == 0 || $TopicID == -1) {
					
					$SearchError = 'A topic is required to search the forum.';
					
				}
				
				else if (strlen($Search) < 3) {
					
					$SearchError = 'A search query must be at least 3 characters.';
					
				}
				
				echo '
				<div class="push-25"></div>
				<div class="push-10"></div>
				';
				
				if (!empty($SearchError)) {
					
					echo '
					<div class="container-header md-padding">
						Results
					</div>
					<div class="container border-wh md-padding">
						'.$SearchError.'
					</div>
					';
					
				}
				
				else {
					
					$countThreads = $db->prepare("
					SELECT COUNT(*) FROM ((SELECT ForumThread.ID FROM ForumThread JOIN User ON ForumThread.UserID = User.ID WHERE ForumThread.TopicID = ? AND MATCH(ForumThread.Title) AGAINST(?))
					UNION
					(SELECT ForumThread.ID FROM ForumThread JOIN User ON ForumThread.UserID = User.ID WHERE ForumThread.TopicID = ? AND MATCH(ForumThread.Post) AGAINST(?))
					UNION
					(SELECT ForumThread.ID FROM ForumThread JOIN User ON ForumThread.UserID = User.ID JOIN ForumReply ON ForumThread.ID = ForumReply.ThreadID WHERE ForumThread.TopicID = ? AND MATCH(ForumReply.Post) AGAINST(?))) x
					");
					$countThreads->bindValue(1, $TopicID, PDO::PARAM_INT);
					$countThreads->bindValue(2, $Search, PDO::PARAM_STR);
					$countThreads->bindValue(3, $TopicID, PDO::PARAM_INT);
					$countThreads->bindValue(4, $Search, PDO::PARAM_STR);
					$countThreads->bindValue(5, $TopicID, PDO::PARAM_INT);
					$countThreads->bindValue(6, $Search, PDO::PARAM_STR);
					$countThreads->execute();
					$ThreadCount = $countThreads->fetchColumn();
					
					if ($ThreadCount == 0) {
						
						echo '
						<div class="container-header md-padding">
							Results
						</div>
						<div class="container border-wh md-padding text-center">
							<i class="material-icons" style="font-size:50px;">sentiment_neutral</i>
							<div style="font-size:18px;">No results found. Bummer. Try refining your search.</div>
						</div>
						';
						
					} else {
						
						$limit = 15;
						
						$pages = ceil($ThreadCount / $limit);
							
						$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
							'options' => array(
								'default'   => 1,
								'min_range' => 1,
							),
						)));
							
						$offset = ($page - 1)  * $limit;
						if ($offset < 0) { $offset = 0; }

						$getThreads = $db->prepare("
						(SELECT User.ID, User.Username, User.AvatarURL, ForumThread.ID, ForumThread.Title, ForumThread.Post, ForumThread.TimePost, ForumThread.TimeUpdated, ForumThread.Pinned, ForumThread.Views, ForumThread.Replies, ForumThread.LastPostReplyID, (SELECT User.Username FROM ForumReply JOIN User ON ForumReply.UserID = User.ID WHERE ForumReply.ID = ForumThread.LastPostReplyID) AS LastPostReplyPoster FROM ForumThread JOIN User ON ForumThread.UserID = User.ID WHERE ForumThread.TopicID = ? AND MATCH(ForumThread.Title) AGAINST(?))
						UNION
						(SELECT User.ID, User.Username, User.AvatarURL, ForumThread.ID, ForumThread.Title, ForumThread.Post, ForumThread.TimePost, ForumThread.TimeUpdated, ForumThread.Pinned, ForumThread.Views, ForumThread.Replies, ForumThread.LastPostReplyID, (SELECT User.Username FROM ForumReply JOIN User ON ForumReply.UserID = User.ID WHERE ForumReply.ID = ForumThread.LastPostReplyID) AS LastPostReplyPoster FROM ForumThread JOIN User ON ForumThread.UserID = User.ID WHERE ForumThread.TopicID = ? AND MATCH(ForumThread.Post) AGAINST(?))
						UNION
						(SELECT User.ID, User.Username, User.AvatarURL, ForumThread.ID, ForumThread.Title, ForumThread.Post, ForumThread.TimePost, ForumThread.TimeUpdated, ForumThread.Pinned, ForumThread.Views, ForumThread.Replies, ForumThread.LastPostReplyID, (SELECT User.Username FROM ForumReply JOIN User ON ForumReply.UserID = User.ID WHERE ForumReply.ID = ForumThread.LastPostReplyID) AS LastPostReplyPoster FROM ForumThread JOIN User ON ForumThread.UserID = User.ID JOIN ForumReply ON ForumThread.ID = ForumReply.ThreadID WHERE ForumThread.TopicID = ? AND MATCH(ForumReply.Post) AGAINST(?))
						ORDER BY Pinned DESC, TimeUpdated DESC LIMIT ? OFFSET ?
						");
						$getThreads->bindValue(1, $TopicID, PDO::PARAM_INT);
						$getThreads->bindValue(2, $Search, PDO::PARAM_STR);
						$getThreads->bindValue(3, $TopicID, PDO::PARAM_INT);
						$getThreads->bindValue(4, $Search, PDO::PARAM_STR);
						$getThreads->bindValue(5, $TopicID, PDO::PARAM_INT);
						$getThreads->bindValue(6, $Search, PDO::PARAM_STR);
						$getThreads->bindValue(7, $limit, PDO::PARAM_INT);
						$getThreads->bindValue(8, $offset, PDO::PARAM_INT);
						$getThreads->execute();
							
						echo '
						<div class="container-header strong forum-header">
							<div class="grid-x grid-margin-x align-middle">
								<div class="large-7 cell">
									Results
								</div>
								<div class="large-1 cell text-center">
									Replies
								</div>
								<div class="large-1 cell text-center">
									Views
								</div>
								<div class="large-3 cell text-right">
									Last Post
								</div>
							</div>
						</div>
						<div class="container border-wh">
						';
						
						while ($getT = $getThreads->fetch(PDO::FETCH_OBJ)) {
							
							if (empty($getT->LastPostReplyPoster)) {
								
								$ThreadPoster = $getT->Username;
								
							}
							
							else {
								
								$ThreadPoster = $getT->LastPostReplyPoster;
								
							}
							
							echo '
							<div class="grid-x grid-margin-x align-middle forum-topic-container">
								<div class="large-7 cell">
									<div class="grid-x grid-margin-x align-middle">
										<div class="shrink cell no-margin">
											<div style="border-radius:50%;width:48px;height:48px;background:url('.$cdnName . $getT->AvatarURL.'-thumb.png);border:1px solid #41424D;background-size:cover;overflow:hidden;"></div>
										</div>
										<div class="auto cell topic-post-info">
											<div class="thread-content-title"><a href="'.$serverName.'/forum/thread/'.$getT->ID.'/">'.$getT->Title.'</a></div>
											<div class="grid-x grid-margin-x align-middle">
												<div class="shrink cell no-margin">
												';
												
												if ($getT->Pinned == 1) {
													
													echo '<span class="thread-pinned"><i class="material-icons" style="font-size:11px;">gavel</i> Pinned</span>';
													
												} else if ($getT->Locked == 1) {
													
													echo '<span class="thread-locked"><i class="material-icons" style="font-size:11px;">lock</i> Locked</span>';
													
												}
												
												echo '
												</div>
												<div class="auto cell no-margin">
													<div class="thread-content-post"><span style="vertical-align:middle;">Posted by <a href="'.$serverName.'/users/'.$getT->Username.'/">'.$getT->Username.'</a>&nbsp;-&nbsp;'.get_timeago($getT->TimePost).'</span></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="large-1 cell text-center">
									'.number_format($getT->Replies).'
								</div>
								<div class="large-1 cell text-center">
									'.number_format($getT->Views).'
								</div>
								<div class="large-3 cell text-right">
									<a href="'.$serverName.'/forum/thread/'.$getT->ID.'/'; if ($getT->LastPostReplyID != 0) { echo '#'.$getT->LastPostReplyID.''; } echo '" class="last-post-link">'.LimitTextByCharacters(html_entity_decode($getT->Title), 23).'</a>
									<div class="last-post-link">by <a href="'.$serverName.'/users/'.$ThreadPoster.'/">'.$ThreadPoster.'</a> - '.get_timeago($getT->TimeUpdated).'</div>
								</div>
							</div>
							';
							
						}

						echo '</div>';
						
						if ($pages > 1) {
							
							echo '
							<div class="push-25"></div>
							<ul class="pagination" role="navigation" aria-label="Pagination">
								<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/forum/search/?tid='.$TopicID.'&search='.$Search.'&page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
								';

								for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
									
									if ($i <= $pages) {
									
										echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/forum/search/?tid='.$TopicID.'&search='.$Search.'&page='.($i).'">'.$i.'</a></li>';

									}
									
								}

								echo '
								<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/forum/search/?tid='.$TopicID.'&search='.$Search.'&page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
							</ul>
							';
						
						}
					
					}
					
				}
				
			}

			$base = 1000;
			$power = pow(1.50, $myU->ForumLevel);
			$LevelMaxExp = round($base*$power);
		
			echo '
			</div>
			<div class="large-3 cell">
				<form action="'.$serverName.'/forum/search/" method="GET">
					<input type="text" name="search" class="forum-input" placeholder="Search...">
				</form>
				<div class="push-15"></div>
				<div class="container border-r forum-topic-links">
					<a href="'.$serverName.'/forum/bookmarks/" class="clearfix">
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell no-margin">
								<i class="material-icons" style="color:#F6B352;">bookmark</i>
								<span class="next-to-icon">Bookmarks</span>
							</div>
							<div class="shrink cell right no-margin">
								<span class="right">'.shortNum($myU->NumForumBookmarks).'</span>
							</div>
						</div>
					</a>
					<a href="'.$serverName.'/forum/my-posts/" class="clearfix">
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell no-margin">
								<i class="material-icons" style="color:#30A9DE;">message</i>
								<span class="next-to-icon">My Posts</span>
							</div>
							<div class="shrink cell right no-margin">
								<span class="right">'.shortNum($myU->NumForumPosts).'</span>
							</div>
						</div>
					</a>
					<a href="'.$serverName.'/forum/drafts/" class="clearfix">
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell no-margin">
								<i class="material-icons" style="color:#9055A2;">drafts</i>
								<span class="next-to-icon">Drafts</span>
							</div>
							<div class="shrink cell right no-margin">
								<span class="right">'.shortNum($myU->NumForumDrafts).'</span>
							</div>
						</div>
					</a>
				</div>
				<div class="push-25"></div>
				<h6><strong>Forum Level</strong></h6>
				<div class="container border-r md-padding text-center">
					<div class="forum-level">'.$myU->ForumLevel.'</div>
					<div class="forum-exp">'.$myU->ForumEXP.'/'.$LevelMaxExp.' EXP to level up</div>
				</div>
			</div>
			</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");