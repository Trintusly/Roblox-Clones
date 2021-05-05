<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();

	$getThread = $db->prepare("SELECT ForumThread.ID, ForumThread.Title, ForumThread.Locked, ForumTopic.ID AS TopicID, ForumTopic.CategoryID, ForumTopic.Name AS TopicName, ForumTopic.AdminPost AS TopicAdminPost, ForumCategory.Name AS CategoryName FROM ForumThread JOIN ForumTopic ON ForumThread.TopicID = ForumTopic.ID JOIN ForumCategory ON ForumTopic.CategoryID = ForumCategory.ID WHERE ForumThread.ID = ?");
	$getThread->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getThread->execute();
	
	if ($getThread->rowCount() == 0) {
		
		header("Location: /forum/");
		die;
		
	}
	
	$gT = $getThread->fetch(PDO::FETCH_OBJ);
	
	if ($gT->Locked == 1 && $myU->Admin < 1) {
		
		header("Location: ".$serverName."/forum/thread/".$gT->ID."/");
		die;
		
	}
	
	$base = 1000;
	$power = pow(1.50, $myU->ForumLevel);
	$LevelMaxExp = round($base*$power);
	
	$getForumBans = $db->prepare("SELECT * FROM ForumBan WHERE UserID = ".$myU->ID." ORDER BY ID ASC LIMIT 1");
	$getForumBans->execute();
	
	if ($getForumBans->rowCount() > 0) {
		
		echo '
		<div class="container-header md-padding">
			<strong>This account has been forum banned.</strong>
		</div>
		<div class="container border-wh md-padding">
		';
		
		while ($gFB = $getForumBans->fetch(PDO::FETCH_OBJ)) {
			
			echo '
			Your account has been forum banned. You will be unable to create or reply to posts on our <a href="/forum/">Community Forums</a>. You can, however, view posts and participate in post likes.
			<div style="margin-top:10px;padding:10px;background-color:#000000;"><b>Expires:</b> Never</div>
			<div style="margin-top:10px;padding:10px;background-color:#000000;"><b>Reason:</b> '.$gFB->Reason.'</div>
			<div style="margin: 15px;font-size:13px;width:100%;text-align:center;">
				Failure to abide by our <a href="/about/terms-of-service/">terms of service</a> will result in account suspension up to and including account closure. Please remember to abide by our <a href="/about/terms-of-service/">terms of service</a> at all times.
			</div>
			';
			
		}
		
		echo '
		</div>
		';
		
		require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
		die;
		
	} else {
		
		if (isset($_POST['reply']) && isset($_POST['csrf_token']) && $myU->AccountVerified > 0 && $myU->TimeRegister+86400 < time()) {
			
			$_POST['reply'] = htmlentities($_POST['reply']);
			
			if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {
				
				$error = 'Invalid CSRF token, please try again.';
				
			} else if ($myU->UserFlood > time() && $myU->Admin == 0) {
				
				$error = 'You are posting too fast, please wait <b>'.($myU->UserFlood - time()).'</b> more seconds before posting again.';
				
			}
			
			else if (strlen($_POST['reply']) < 3 || strlen($_POST['reply']) > 7500) {
				
				$error = 'Your post is either too long, or too short. Make sure it has anywhere between 3 and 7,500 characters.';
				
			}
			
			else if (isProfanity($_POST['reply']) == 1) {
				
				$error = 'One or more words in your post has triggered our profanity filter. Please update and try again.';
				
			}
			
			else {
				
				$updateFlood = $db->prepare("UPDATE User SET UserFlood = ".(time() + 35)." WHERE ID = ".$myU->ID."");
				$updateFlood->execute();
				
				$QuoteType = 0;
				$QuoteID = 0;
				
				if (!empty($_POST['Checkbox'])) {
					
					if ($_GET['Type'] == 'Thread' && $gT->ID == $_GET['SourceID']) {
						
						$QuoteType = 1;
						$QuoteID = $_GET['SourceID'];
						
					}
					
					else if ($_GET['Type'] == 'Reply') {
						
						$check = $db->prepare("SELECT COUNT(*) FROM ForumReply WHERE ID = ? AND ThreadID = ?");
						$check->bindValue(1, $_GET['SourceID'], PDO::PARAM_INT);
						$check->bindValue(2, $gT->ID, PDO::PARAM_INT);
						$check->execute();
						
						if ($check->fetchColumn() > 0) {
							
							$QuoteType = 2;
							$QuoteID = $_GET['SourceID'];
							
						}
						
					}
					
				}
				
				$db->beginTransaction();
				
				$insert = $db->prepare("INSERT INTO ForumReply (ThreadID, UserID, Post, TimePost, QuoteType, QuoteID) VALUES(".$gT->ID.", ".$myU->ID.", ?, ".time().", ".$QuoteType.", ".$QuoteID.")");
				$insert->bindValue(1, safeContent(linkify($_POST['reply'])), PDO::PARAM_STR);
				$insert->execute();
				
				$ReplyID = $db->lastInsertId();
				
				$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
				$InsertUserActionLog->bindValue(1, 'Created a forum reply (Thread ID: '.$gT->ID.') (Reply ID: '.$ReplyID.')', PDO::PARAM_STR);
				$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
				$InsertUserActionLog->execute();
				
				$count = $db->prepare("SELECT COUNT(*) FROM ForumReply WHERE ThreadID = ".$gT->ID." AND UserID = ".$myU->ID." AND Post = ? AND TimePost = ".time()." AND QuoteType = ".$QuoteType." AND QuoteID = ".$QuoteID."");
				$count->bindValue(1, safeContent(linkify($_POST['reply'])), PDO::PARAM_STR);
				$count->execute();
				
				if ($count->fetchColumn() > 1) {
					$db->rollBack();
					header("Location: ".$serverName."/forum/");
					die;
				}
				else {
					$db->commit();
					exec("php /var/www/html/root/crons/sendBookmarkNotifications.php ".$gT->ID." ".$ReplyID." ".$myU->ID." > /dev/null 2>&1 &");
				}
				
				$exp = str_word_count($_POST['reply']);
				if ($exp > 10) { $exp = 10; }
				$NewExp = $myU->ForumEXP + $exp;
				
				$base = 1000;
				$power = pow(1.50, $myU->ForumLevel);
				$LevelMaxExp = $base*$power;
				
				if ($NewExp >= $LevelMaxExp) {
					
					$RemainingExp = $NewExp - $LevelMaxExp;
					
					$update = $db->prepare("UPDATE User SET ForumEXP = ".$RemainingExp.", ForumLevel = ForumLevel + 1 WHERE ID = ".$myU->ID."");
					$update->execute();
					
				}
				
				else {
					
					$update = $db->prepare("UPDATE User SET ForumEXP = ".$NewExp." WHERE ID = ".$myU->ID."");
					$update->execute();
					
				}
				
				$cache->delete($myU->ID);
				
				header("Location: ".$serverName."/forum/thread/".$gT->ID."/#".$ReplyID."");
				die;
				
			}
			
		}
		
		echo '
		<script>document.title = "Reply to '.$gT->Title.' - Brick Create";</script>
		<div class="grid-x grid-margin-x">
			<div class="large-9 cell">
				<div class="grid-x grid-margin-x forum-top-links align-middle">
					<div class="auto cell no-margin">
						<a href="'.$serverName.'/forum/">Forum</a>
						&nbsp;&raquo;&nbsp;
						<a href="'.$serverName.'/forum/topic/'.$gT->TopicID.'/">'.$gT->TopicName.'</a>
						&nbsp;&raquo;&nbsp;
						Reply to <strong>'.$gT->Title.'</strong>
					</div>
					<div class="shrink cell no-margin">
						<a href="'.$serverName.'/forum/thread/'.$gT->ID.'/" class="button button-grey" style="padding: 8px 15px;font-size:13px;line-height:1.25;">Return to Thread</a>
					</div>
				</div>
				<div class="push-5"></div>
				';
				
				if (isset($error)) {
					
					echo '
					<div class="error-message">'.$error.'</div>
					';
					
				}
				
				echo '
				<div class="container-header md-padding">
					Reply to <strong>'.$gT->Title.'</strong>
				</div>
				<div class="container border-wh md-padding">
					<form action="" method="POST">
						<textarea name="reply" class="normal-input" '; if ($myU->AccountVerified == 0) { echo 'disabled placeholder="Please verify your account to reply to a thread."'; } else if ($myU->TimeRegister+86400 > time()) { echo 'disabled placeholder="Please wait one (1) day after registering before posting on the forum."'; } else { echo 'placeholder="Type your reply here."'; } echo ' style="height:150px;">'; if (!empty($_POST['reply'])) { echo htmlentities($_POST['reply']); } echo '</textarea>
						<div class="selection-optional"><input type="checkbox" value="1" name="Checkbox" id="Checkbox"><label for="Checkbox"><span>Quote post</span></label></div>
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						<input type="submit" value="Reply" class="button button-green"'; if ($myU->AccountVerified == 0 || $myU->TimeRegister+86400 > time()) { echo ' disabled'; } echo '>
					</form>
				</div>
			</div>
			<div class="large-3 cell">
				';
				
				if ($gT->TopicAdminPost <= $myU->Admin) {
				
				echo '
				<a href="'.$serverName.'/forum/new/'.$gT->TopicID.'/" class="button button-green" style="width:100%;box-sizing:border-box;text-align:center;"><i class="material-icons">add</i><span>Create Thread</span></a>
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
		
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");