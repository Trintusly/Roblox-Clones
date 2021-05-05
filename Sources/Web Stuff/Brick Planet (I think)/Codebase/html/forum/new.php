<?php
$page = 'forum';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	$getTopic = $db->prepare("SELECT ForumTopic.ID, ForumTopic.CategoryID, ForumTopic.Name, ForumTopic.AdminPost, ForumCategory.Name AS CategoryName FROM ForumTopic JOIN ForumCategory ON ForumTopic.CategoryID = ForumCategory.ID WHERE ForumTopic.ID = ?");
	$getTopic->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getTopic->execute();
	
	if ($getTopic->rowCount() == 0) {
		
		returnUnexpectedError();
		die;
		
	}
	
	$gT = $getTopic->fetch(PDO::FETCH_OBJ);
	
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
	
		if ($gT->AdminPost > $myU->Admin) {
			header("Location: /forum/");
			die;
		}
		
		if (!empty($_SESSION['DraftTitle']) && !empty($_SESSION['DraftPost'])) {
			
			$title = $_SESSION['DraftTitle'];
			$post = $_SESSION['DraftPost'];
			
			unset($_SESSION['DraftTitle']);
			unset($_SESSION['DraftPost']);
			
		}
		
		if (!empty($_POST['title']) && !empty($_POST['post']) && !empty($_POST['csrf_token']) && $myU->AccountVerified > 0 && $myU->TimeRegister+0 < time()) {
			
			if ($myU->Admin < 6) {
				$title = htmlentities(strip_tags($_POST['title']));
				$post = htmlentities(strip_tags($_POST['post']));
			} else {
				$title = $_POST['title'];
				$post = $_POST['post'];
			}
			$title = preg_replace('/( )+/', ' ', $title);
			$post = preg_replace('/( )+/', ' ', $post);
			
			if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {
				
				$error = 'Invalid CSRF token, please try again.';
				
			} else if ($myU->UserFlood > time() && $myU->Admin == 0) {
				
				$error = 'You are posting too fast, please wait <b>'.($myU->UserFlood - time()).'</b> more seconds before posting again.';
				
			}
			
			else if (strlen($title) < 3 || strlen($title) > 50 && $myU->Admin < 6) {
				
				$error = 'Your post title is either too long, or too short. Make sure it has anywhere between 3 and 50 characters.';
				
			}
			
			else if (strlen($post) < 3 || strlen($post) > 7500 && $myU->Admin < 6) {
				
				$error = 'Your post is either too long, or too short. Make sure it has anywhere between 3 and 7,500 characters.';
				
			}
			
			else if (!preg_match('/^[a-z0-9 .\-!,\':;<>?()\[\]+=\/#$&]+$/i', $title)) {
				
				$error = 'Your title must include alphanumeric characters only.';
				
			}
			
			else if (isProfanity($title) == 1 || isProfanity($post) == 1) {
				
				$error = 'One or more words in your post has triggered our profanity filter. Please update and try again.';
				
			} else {
				
				$post = linkify($post);
				
				$updateFlood = $db->prepare("UPDATE User SET UserFlood = ".(time() + 35)." WHERE ID = ".$myU->ID."");
				$updateFlood->execute();
				
				$db->beginTransaction();
				
				$insert = $db->prepare("INSERT INTO ForumThread (TopicID, UserID, Title, Post, TimePost, TimeUpdated) VALUES(".$gT->ID.", ".$myU->ID.", ?, ?, ".time().", ".time().")");
				$insert->bindValue(1, $title, PDO::PARAM_STR);
				$insert->bindValue(2, $post, PDO::PARAM_STR);
				$insert->execute();
				
				$ThreadID = $db->lastInsertId();
				
				$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
				$InsertUserActionLog->bindValue(1, 'Created a forum thread (Thread ID: '.$ThreadID.')', PDO::PARAM_STR);
				$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
				$InsertUserActionLog->execute();
				
				$count = $db->prepare("SELECT COUNT(*) FROM ForumThread WHERE TopicID = ".$gT->ID." AND UserID = ".$myU->ID." AND Title = ? AND Post = ? AND TimePost = ".time()." AND TimeUpdated = ".time()."");
				$count->bindValue(1, $title, PDO::PARAM_STR);
				$count->bindValue(2, $post, PDO::PARAM_STR);
				$count->execute();
				
				if ($count->fetchColumn() == 1) {
					$db->commit();
				} else {
					$db->rollBack();
					header("Location: ".$serverName."/forum/");
					die;
				}
				
				$exp = str_word_count($post);
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
				
				if (!empty($_SESSION['DraftID'])) {
					
					$delete = $db->prepare("DELETE FROM ForumThreadDraft WHERE ID = ? AND UserID = ".$myU->ID."");
					$delete->bindValue(1, $_SESSION['DraftID'], PDO::PARAM_INT);
					$delete->execute();
					
				}
				
				$cache->delete($myU->ID);
				
				header("Location: ".$serverName."/forum/thread/".$ThreadID."/");
				die;
				
			}
			
		}
		
		echo '
		<script>
		document.title = "New Forum Post - Brick Create";
		</script>
		<div class="grid-x grid-margin-x forum-top-links">
			<div class="auto cell">
				<a href="'.$serverName.'/forum/">Forum</a>
				&nbsp;&raquo;&nbsp;
				<a href="'.$serverName.'/forum/topic/'.$gT->ID.'/">'.$gT->Name.'</a>
				&nbsp;&raquo;&nbsp;New Post
			</div>
		</div>
		';
		
		if (isset($error)) {
			
			echo '
			<div class="error-message">'.$error.'</div>
			';
			
		}
		
		echo '
		<script>
			function saveDraft(type) {
				document.getElementById("draft-status").innerHTML = "Saving draft...";
				
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						if (type == "auto" && this.responseText != "Draft updated." && this.responseText != "Draft saved.") {
							setTimeout(saveDraft("auto"), 30000);
						}
						else {
							document.getElementById("draft-status").innerHTML = this.responseText;
						}
					}
				};
				
				xhttp.open("POST", "'.$serverName.'/forum/save-draft.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send("title=" + document.getElementById("title").value + "&post=" + document.getElementById("post").value + "&topicid='.$gT->ID.'");
			}
			
			setTimeout(saveDraft("auto"), 60000);
		</script>
		<div class="container-header md-padding">
			<strong>New Thread</strong>
		</div>
		<div class="container border-wh md-padding">
			<form action="" method="POST">
				<div class="grid-x grid-margin-x">
					<div class="auto cell">
						<input type="text" name="title" id="title" class="normal-input" '; if ($myU->AccountVerified == 0) { echo 'disabled placeholder="Please verify your account to create a thread."'; } else if ($myU->TimeRegister+0 > time()) { echo 'disabled placeholder="Please wait one (1) day after registering before posting on the forum."'; } else { echo 'placeholder="Enter a title"'; if (!empty($title)) { echo ' value="'.$title.'"'; } } echo '>
						<div class="push-15"></div>
						<textarea name="post" id="post" class="normal-input" '; if ($myU->AccountVerified == 0) { echo 'disabled placeholder="Please verify your account to create a thread."'; } else if ($myU->TimeRegister+0 > time()) { echo 'disabled placeholder="Please wait one (1) day after registering before posting on the forum."'; } else { echo 'placeholder="Enter a post"'; } echo ' style="height:150px;">'; if (!empty($post) && $myU->AccountVerified == 1) { echo $post; } echo '</textarea>
						<div class="push-15"></div>
					</div>
				</div>
				<div class="grid-x grid-margin-x align-middle">
					<div class="auto cell">
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						<input type="submit" value="Post" class="button button-green"'; if ($myU->AccountVerified == 0 || $myU->TimeRegister+0 > time()) { echo ' disabled'; } echo '>
					</div>
					<div class="shrink cell text-right">
						<div class="clearfix draft-status">
							<span id="draft-status" class="left"></span>
							<input type="button" onclick="saveDraft()" value="Save As Draft" class="button button-blue right">
						</div>
					</div>
				</div>
			</form>
		</div>
		';
		
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
