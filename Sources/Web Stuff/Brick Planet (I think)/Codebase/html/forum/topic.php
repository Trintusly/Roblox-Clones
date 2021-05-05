<?php
$page = 'forum';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	if (!$cache->get('ForumTopic_'.$_GET['id'])) {
	
		$getTopic = $db->prepare("SELECT ForumTopic.CategoryID, ForumCategory.Name AS CategoryName, ForumTopic.ID, ForumTopic.Name, ForumTopic.Description, ForumTopic.Posts, ForumTopic.AdminPost FROM ForumTopic JOIN ForumCategory ON ForumTopic.CategoryID = ForumCategory.ID WHERE ForumTopic.ID = ?");
		$getTopic->bindValue(1, $_GET['id'], PDO::PARAM_INT);
		$getTopic->execute();
		
		if ($getTopic->rowCount() == 0) {
			
			header("Location: /forum/");
			die;
			
		}
		
		$gT = $getTopic->fetch(PDO::FETCH_OBJ);
		$cache->set('ForumTopic_'.$_GET['id'], $gT, 120);
		
	}
	
	else {
		
		$gT = $cache->get('ForumTopic_'.$_GET['id']);
		
	}
	
	echo '<script>document.title = "'.$gT->Name.' - Brick Create";</script>';
	
	if ($AUTH) {
		
		$_SESSION['LastTopicName'] = $gT->Name;
		$_SESSION['LastTopicID'] = $gT->ID;
		
	}
	
	if (!$AUTH) {
		$myU->Admin = 0;
	}
	
	echo '
	<div class="grid-x grid-margin-x forum-top-links">
		<div class="auto cell">
			<a href="'.$serverName.'/forum/">Forum</a>
			&nbsp;&raquo;&nbsp;
			'.$gT->Name.'
		</div>
	</div>
		<div class="grid-x grid-margin-x">
			<div class="'; if ($AUTH) { echo 'large-9'; } else { echo 'auto'; } echo ' cell">
				<div class="container-header strong forum-header">
					<div class="grid-x grid-margin-x align-middle">
						<div class="large-7 medium-8 small-8 cell">
							'.$gT->Name.'
						</div>
						<div class="large-1 medium-2 small-2 cell text-center">
							Replies
						</div>
						<div class="large-1 medium-2 small-2 cell text-center">
							Views
						</div>
						<div class="large-3 cell text-right show-for-large">
							Last Post
						</div>
					</div>
				</div>
				<div class="container border-wh">
				';
				
				$limit = 15;
				
				$pages = ceil($gT->Posts / $limit);
					
				$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
					'options' => array(
						'default'   => 1,
						'min_range' => 1,
					),
				)));
					
				$offset = ($page - 1)  * $limit;
				if ($offset < 0) { $offset = 0; }
				
				$getThreads = $db->prepare("SELECT User.ID, User.Username, User.AvatarURL, User.Admin, ForumThread.ID, ForumThread.Title, ForumThread.Post, ForumThread.Locked, ForumThread.TimePost, ForumThread.TimeUpdated, ForumThread.Pinned, ForumThread.Views, ForumThread.Replies, ForumThread.LastPostReplyID, (SELECT GROUP_CONCAT(User.Username, ',', User.Admin) FROM ForumReply JOIN User ON ForumReply.UserID = User.ID WHERE ForumReply.ID = ForumThread.LastPostReplyID) AS LastPostReplyPoster FROM ForumThread FORCE INDEX(ForumThread_UserID_FK_idx,ForumThread_TopicID_FK_idx) JOIN User ON ForumThread.UserID = User.ID WHERE ForumThread.TopicID = ".$gT->ID." ORDER BY ForumThread.Pinned DESC, ForumThread.TimeUpdated DESC LIMIT ".$limit." OFFSET ".$offset."");
				$getThreads->execute();
				
				$i = 0;
				
				while ($getT = $getThreads->fetch(PDO::FETCH_OBJ)) {
					
					$i++;
					
					if (empty($getT->LastPostReplyPoster)) {
						
						$ThreadPosterUsername = $getT->Username;
						$ThreadPosterAdmin = $getT->Admin;
						
					}
					
					else {
						
						$LastPost = explode(',', $getT->LastPostReplyPoster);
						$ThreadPosterUsername = $LastPost[0];
						$ThreadPosterAdmin = $LastPost[1];
						
					}
					
					if ($i > 1) {
						echo '<div class="topic-divider"></div>';
					}
					
					echo '
					<div class="grid-x grid-margin-x align-middle forum-topic-container">
						<div class="large-7 medium-8 small-8 cell">
							<div class="grid-x grid-margin-x align-middle">
								<div class="shrink cell no-margin show-for-medium">
									<div style="border-radius:50%;width:48px;height:48px;background-image:url(https://cdn.brickcreate.com/975289c5-1c08-463c-bdf5-0b49d35c933b.png);background-color:#1D1F24;background-size:cover;overflow:hidden;"></div>
								</div>
								<div class="auto cell topic-post-info">
									<div class="thread-content-title"><a href="'.$serverName.'/forum/thread/'.$getT->ID.'/">'.$getT->Title.'</a>
									';
									
									$countPageUp = 0;
									
									if ($getT->Replies > 15) {
										
										echo '<font class="forum-topic-thread-pagination">Page&nbsp;&nbsp;';
										
										if ($gT->RepliesCount >= 330) {
										
											echo '<a href="'.$serverName.'/forum/topic/'.$gT->ID.'/">1</a>';
										
											for ($count = 0; $count <= $getT->Replies; $count+=5) {
												
												if ($count % 75 == 0) {
													
													$countPageUp += 5;
													
													if ($countPageUp > 1) {
														echo ', ';
													}
													
													echo '<a href="'.$serverName.'/forum/thread/'.$getT->ID.'/'.$countPageUp.'/">'.$countPageUp.'</a>';
													
												}
												
											}
										
										} else {
											
											for ($count = 0; $count <= $getT->Replies; $count++) {
												
												if ($count % 15 == 0) {
													
													$countPageUp++;
													
													if ($countPageUp > 1) {
														echo ', ';
													}
													
													echo '<a href="'.$serverName.'/forum/thread/'.$getT->ID.'/'.$countPageUp.'/">'.$countPageUp.'</a>';
													
												}
												
											}
											
										}
										
										echo '</font>';
										
									}
									
									echo '
									</div>
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
										<div class="large-auto medium-auto small-12 cell no-margin">
											<div class="thread-content-post"><span class="show-for-medium">Posted by</span> <span>'; if ($getT->Admin > 0) { echo '<a href="'.$serverName.'/users/'.$getT->Username.'/" style="color:#ec2b1d;"><strong>'.$getT->Username.'</strong></a>'; } else { echo '<a href="'.$serverName.'/users/'.$getT->Username.'/">'.$getT->Username.'</a>'; } echo '&nbsp;-&nbsp;'.get_timeago($getT->TimePost).'</span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="large-1 medium-2 small-2 cell text-center">
							'.number_format($getT->Replies).'
						</div>
						<div class="large-1 medium-2 small-2 cell text-center">
							'.number_format($getT->Views).'
						</div>
						<div class="large-3 cell text-right show-for-large" style="word-break:break-word;">
							<a href="'.$serverName.'/forum/thread/'.$getT->ID.'/'; if ($getT->LastPostReplyID != 0) { echo '#'.$getT->LastPostReplyID.''; } echo '" class="last-post-link">'.LimitTextByCharacters(html_entity_decode($getT->Title), 23).'</a>
							<div class="last-post-link">by '; if ($ThreadPosterAdmin > 0) { echo '<a href="'.$serverName.'/users/'.$ThreadPosterUsername.'/" style="color:#ec2b1d;"><strong>'.$ThreadPosterUsername.'</strong></a>'; } else { echo '<a href="'.$serverName.'/users/'.$ThreadPosterUsername.'/">'.$ThreadPosterUsername.'</a>'; } echo ' - '.get_timeago($getT->TimeUpdated).'</div>
						</div>
					</div>
					';
					
				}
			
			echo '
			</div>
			';
			
		if ($pages > 1) {
			
			echo '
			<div class="push-25"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/forum/topic/'.$gT->ID.'/'.($page-1).'/">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
				';

				for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
					
					if ($i <= $pages) {
					
						echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/forum/topic/'.$gT->ID.'/'.($i).'/">'.$i.'</a></li>';

					}
					
				}

				echo '
				<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/forum/topic/'.$gT->ID.'/'.($page+1).'/">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
			</ul>
			';
		
		}
		
		if ($AUTH) {
			$base = 1000;
			$power = pow(1.50, $myU->ForumLevel);
			$LevelMaxExp = round($base*$power);
		
			echo '
			</div>
			<div class="large-3 cell">
				';
				
				if ($gT->AdminPost <= $myU->Admin) {
				
				echo '
				<a href="'.$serverName.'/forum/new/'.$gT->ID.'/" class="button button-green" style="width:100%;box-sizing:border-box;text-align:center;"><i class="material-icons">add</i><span>Create Thread</span></a>
				<div style="height:14px;"></div>
				';
				
				}
				
				echo '
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
			';
		} else {
			echo '</div></div>';
		}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");