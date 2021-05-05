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
	
	if (!empty($_POST['draft_id']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
		
		$deleteDraft = $db->prepare("DELETE FROM ForumThreadDraft WHERE ID = ? AND UserID = ".$myU->ID."");
		$deleteDraft->bindValue(1, $_POST['draft_id'], PDO::PARAM_INT);
		$deleteDraft->execute();
		
		header("Location: ".$serverName."/forum/drafts/");
		die;
		
	}
	
	echo '
	<script>document.title = "My Drafts - Brick Create";</script>
	<div class="grid-x grid-margin-x">
		<div class="large-9 cell">
			<div class="container-header md-padding">
				<div class="grid-x grid-margin-x">
					<div class="large-6 cell">
						<strong>My Drafts</strong>
					</div>
					<div class="large-3 cell">
						<strong>Time Saved</strong>
					</div>
					<div class="large-3 cell text-right">
						<strong>Action</strong>
					</div>
				</div>
			</div>
			';
			
			$getDrafts = $db->prepare("SELECT ForumThreadDraft.ID, ForumThreadDraft.Title, ForumThreadDraft.Post, ForumThreadDraft.TimePost FROM ForumThreadDraft WHERE UserID = ".$myU->ID." ORDER BY ForumThreadDraft.TimePost DESC");
			$getDrafts->execute();
			
			if ($getDrafts->rowCount() == 0) {
				
				echo '
				<div class="container border-wh md-padding">
					<div class="text-center">
						<i class="material-icons" style="font-size:50px;">drafts</i>
						<div style="font-size:18px;">There aren\'t any drafts here yet.</div>
					</div>
				</div>
				';
				
			}
			
			else {
			
				echo '<div class="container border-wh">';
			
				while ($gD = $getDrafts->fetch(PDO::FETCH_OBJ)) {
					
					echo '
					<a href="'.$serverName.'/forum/draft/'.$gD->ID.'/" class="forum-draft-a">
					<div class="grid-x grid-margin-x align-middle forum-topic-container">
						<div class="large-6 cell">
							<div class="forum-draft-title">'.$gD->Title.'</div>
							<div class="forum-draft-text">'; if (strlen($gD->Post) > 128) { echo $gD->Post.'...'; } else { echo $gD->Post; } echo '</div>
						</div>
						<div class="large-3 cell">
							<div class="forum-draft-time">'.date('m/d/Y g:iA', $gD->TimePost).' CST</div>
						</div>
						<div class="large-3 cell text-right clearfix">
							<form action="" method="POST">
								<input type="submit" class="button button-grey right" value="Delete" style="display:inline-block;">
								<input type="hidden" name="draft_id" value="'.$gD->ID.'">
								<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
							</form>
						</div>
					</div>
					</a>
					';
					
				}
				
				echo '</div>';
			
			}
			
			echo '
			</div>
			';
		
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

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");