<?php
$page = 'forum';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	if (isset($_SESSION['LastTopicName']) && isset($_SESSION['LastTopicID'])) {
	
		echo '
		<div class="grid-x grid-margin-x forum-top-links">
			<div class="auto cell">
				<a href="'.$serverName.'/forum/topic/'.$_SESSION['LastTopicID'].'/">&laquo; Return to '.$_SESSION['LastTopicName'].'</a>
			</div>
		</div>
		';
	
	} else {
		
		echo '
		<div class="grid-x grid-margin-x forum-top-links">
			<div class="auto cell">
				<a href="'.$serverName.'/forum/">&laquo; Return to Forum Home</a>
			</div>
		</div>
		';
		
	}
	
	echo '
	<script>document.title = "Bookmarks - Brick Create";</script>
	<div class="grid-x grid-margin-x">
		<div class="large-9 cell">
			<div class="container-header md-padding">
				<div class="grid-x grid-margin-x">
					<div class="large-7 cell">
						<strong>Bookmarks</strong>
					</div>
					<div class="large-1 cell text-center">
						<strong>Replies</strong>
					</div>
					<div class="large-1 cell text-center">
						<strong>Views</strong>
					</div>
					<div class="large-3 cell text-right">
						<strong>Last Post</strong>
					</div>
				</div>
			</div>
			
			';
			
			$getThreads = $db->prepare("SELECT User.Username, User.AvatarURL, ForumThread.ID, ForumThread.Title, ForumThread.Post, ForumThread.TimePost, ForumThread.TimeUpdated, ForumThread.Pinned, ForumThread.Views, ForumThread.Replies, ForumThread.LastPostReplyID, (SELECT User.Username FROM ForumReply JOIN User ON ForumReply.UserID = User.ID WHERE ForumReply.ID = ForumThread.LastPostReplyID) AS LastPostReplyPoster FROM ForumThread JOIN User ON ForumThread.UserID = User.ID WHERE ForumThread.ID IN(SELECT ThreadID FROM ForumThreadBookmark WHERE UserID = ".$myU->ID.") ORDER BY ForumThread.Pinned DESC, ForumThread.TimeUpdated DESC");
			$getThreads->execute();
			
			if ($getThreads->rowCount() == 0) {
				
				echo '
				<div class="container border-wh md-padding">
					<div class="text-center">
						<i class="material-icons" style="font-size:50px;">bookmark_outline</i>
						<div style="font-size:18px;">There aren\'t any bookmarks here yet.</div>
					</div>
				</div>
				';
				
			} else {
				
				echo '<div class="container border-wh">';
				
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
			<div class="push-25"></div>
		</div>
	</div>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");