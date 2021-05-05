<?php
$page = 'forum';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	echo '<script>document.title = "Forum - Brick Create";</script>';
		
	echo '
	<div class="grid-x grid-margin-x">
		<div class="'; if ($AUTH) { echo 'large-9'; } else { echo 'auto'; } echo ' cell">
			<div class="container-header strong forum-header">
				<div class="grid-x grid-margin-x align-middle">
					<div class="large-7 medium-8 small-8 cell">
						Brick Create
					</div>
					<div class="large-1 medium-2 small-2 cell text-center">
						Posts
					</div>
					<div class="large-1 medium-2 small-2 cell text-center">
						Replies
					</div>
					<div class="large-3 cell text-right show-for-large">
						Last Post
					</div>
				</div>
			</div>
			<div class="container border-wh">
			';
			$ForumTopics = $cache->get('Forum_Topics');
			
			if (!$ForumTopics) {
				ResetForumHomeCache();
				$ForumTopics = $cache->get('Forum_Topics');
			}
			
			foreach ($ForumTopics as $key => $gT) {
				
				if ($key > 0) {
					echo '<div class="topic-divider"></div>';
				}
				
				echo '
				<div class="grid-x grid-margin-x align-middle forum-topic">
					<div class="large-7 medium-8 small-8 cell">
						<div class="topic-title"><a href="'.$serverName.'/forum/topic/'.$gT->ID.'/">'.$gT->Name.'</a></div>
						<div class="topic-description">'.$gT->Description.'</div>
					</div>
					<div class="large-1 medium-2 small-2 cell text-center">
						'.number_format($gT->Posts).'
					</div>
					<div class="large-1 medium-2 small-2 cell text-center">
						'.number_format($gT->Replies).'
					</div>
					<div class="large-3 cell text-right show-for-large">
						';
						
						if ($gT->LastPostThreadID != 1 && !empty($gT->LastPostInfo)) {
							
							$PostInfo = explode('SEX', $gT->LastPostInfo);
							$ThreadName = LimitTextByCharacters(html_entity_decode($PostInfo[0]), 23);
							$ThreadPoster = $PostInfo[1];
							$ThreadAdminLevel = $PostInfo[2];
							$ThreadTime = $PostInfo[3];
							
							echo '
							<a href="'.$serverName.'/forum/thread/'.$gT->LastPostThreadID.'/'; if ($gT->LastPostReplyID != 1) { echo '#'.$gT->LastPostReplyID.''; } echo '" style="font-size:13px;">'.$ThreadName.'</a>
							<div style="font-size:13px;padding-top:2px;">by '; if ($ThreadAdminLevel > 0) { echo '<a href="'.$serverName.'/users/'.$ThreadPoster.'/" style="color:#ec2b1d;font-weight:600;">'.LimitTextByCharacters($ThreadPoster, 12).'</a>'; } else { echo '<a href="'.$serverName.'/users/'.$ThreadPoster.'/">'.LimitTextByCharacters($ThreadPoster, 12).'</a>'; } echo ', '.get_short_timeago($ThreadTime).'</div>
							';
							
						}
						
						else {
							
							echo 'N/A';
							
						}
						
						echo '
					</div>
				</div>
				';
				
			}
			
			echo '
			</div>
		</div>
		';
		
		if ($AUTH) {
			$base = 1000;
			$power = pow(1.50, $myU->ForumLevel);
			$LevelMaxExp = round($base*$power);
		
			echo '
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
			';
		} else {
			
			echo '</div>';
			
		}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");