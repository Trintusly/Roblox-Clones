<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	$checkMessage = $db->prepare("SELECT UserMessage.*, User.ID AS UserID, User.Username, User.AvatarURL, User.ThumbnailURL, User.PrivateMessageSettings FROM UserMessage JOIN User ON User.ID = UserMessage.SenderID WHERE UserMessage.ID = ?");
	$checkMessage->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$checkMessage->execute();
	
	if ($checkMessage->rowCount() == 0) {
	
		header("Location: ".$serverName."/account/inbox/");
		die;
	
	}
	
	else {
	
		$cM = $checkMessage->fetch(PDO::FETCH_OBJ);
		
		if ($cM->ReceiverID != $myU->ID && $cM->SenderID != $myU->ID) {
			
			header("Location: ".$serverName."/account/inbox/");
			die;
			
		}
		
		if ($cM->ReceiverID == $myU->ID) {
			
			$Receiver = 1;
			
		}
		
		else if ($cM->SenderID == $myU->ID) {
			
			$getReceiver = $db->prepare("SELECT User.ID AS UserID, User.Username, User.AvatarURL, User.ThumbnailURL, User.PrivateMessageSettings FROM User WHERE ID = ".$cM->ReceiverID."");
			$getReceiver->execute();
			$gR = $getReceiver->fetch(PDO::FETCH_OBJ);
			
			$cM->UserID = $gR->UserID;
			$cM->Username = $gR->Username;
			$cM->AvatarURL = $gR->AvatarURL;
			$cM->AvatarURL = $gR->AvatarURL;
			$cM->ThumbnailURL = $gR->ThumbnailURL;
			$cM->PrivateMessageSettings = $gR->PrivateMessageSettings;
			
			$Receiver = 0;
			
		}
		
		if (isset($_POST['reply']) && isset($_POST['csrf_token']) && $cM->PrivateMessageSettings != 2 && $Receiver == 1 && $cM->Username != "Brick Create" && 1 == 2) {
			
			echo '<script>$(document).ready(function(){document.getElementById("replyModule").style.display = "block";});</script>';
			
			if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {
				
				$error_message = 'Invalid CSRF token, please refresh and try again.';
				
			} else if ($myU->UserFlood > time()) {
			
				$error_message = 'Please wait before sending a message again.';
			
			} else if (strlen($_POST['reply']) < 3 || strlen($_POST['reply']) > 1000) {
			
				$error_message = 'Reply must be at least 3 characters.';
			
			} else if (isProfanity($_POST['reply']) == 1) {
				
				$error_message = 'One or more words in your message has triggered our profanity filter. Please correct and try again.';
			
			} else {
				
				$CurrentReply = htmlentities(strip_tags($_POST['reply']));
				
				$Reply = ''.$CurrentReply.'
				
				--------------------------------------
				Sent by '.$cM->Username.' at '.date('m-d-Y g:iA', $cM->TimeSent).' CST
				'.$cM->Message.'
				';
				
				$sendReply = $db->prepare("INSERT INTO UserMessage (SenderID, ReceiverID, Title, Message, TimeSent) VALUES(?, ?, ?, ?, ?)");
				$sendReply->bindValue(1, $myU->ID, PDO::PARAM_INT);
				$sendReply->bindValue(2, $cM->UserID, PDO::PARAM_INT);
				$sendReply->bindValue(3, 'RE: '.$cM->Title.'', PDO::PARAM_STR);
				$sendReply->bindValue(4, $Reply, PDO::PARAM_STR);
				$sendReply->bindValue(5, time(), PDO::PARAM_INT);
				$sendReply->execute();
				
				$ThirtySeconds = time() + 30;
				
				$updateFlood = $db->prepare("UPDATE User SET UserFlood = ".$ThirtySeconds." WHERE ID = ".$myU->ID."");
				$updateFlood->execute();
				
				$success_message = 'Your message has been sent successfully.';
			
			}
		
		}
		
		if ($cM->IsRead == 0) {
		
			$updateReceipt = $db->prepare("UPDATE UserMessage SET TimeRead = ".time().", IsRead = 1 WHERE ID = ?");
			$updateReceipt->bindValue(1, $cM->ID, PDO::PARAM_INT);
			$updateReceipt->execute();
			
			$cache->delete($myU->ID);
			
			header("Location: ".$serverName."/account/message/".$cM->ID."/");
			die;
		
		}
		
		if (isset($_POST['report_message'])) {
			
			$_SESSION['Report_ReferenceType'] = 5;
			$_SESSION['Report_ReferenceID'] = $cM->ID;
			
			header("Location: ".$serverName."/report/");
			die;
			
		}
		
		echo '
		<script>
			document.title = "'.$cM->Title.' - Brick Create";
		</script>
		<div class="grid-x grid-margin-x message-top-links">
			<div class="auto cell">
				<a href="'.$serverName.'/">Dashboard</a> &raquo; <a href="'.$serverName.'/account/inbox/">Inbox</a> &raquo; '.$cM->Title.'
			</div>
		</div>
		<div class="error-message">Private messages are currently disabled. Please try again later.</div>
		<div class="container md-padding border-r">
			<div class="grid-x grid-margin">
				<div class="large-2 cell text-center">
					';
					
					if ($cM->Username == "Brick Create") {
						echo '
						<a href="'.$serverName.'/users/'.$cM->Username.'/"><div class="message-avatar-official" style="background:url(\''.$cdnName . 'web/BCIconPadding.png\');background-size:cover;"></div></a>
						';
					} else {
						echo '
						<a href="'.$serverName.'/users/'.$cM->Username.'/"><div class="message-avatar" style="background:url(\''.$cdnName . $cM->AvatarURL.'-thumb.png\');background-size:cover;"></div></a>
						';
					}
					
					echo '
					<a href="'.$serverName.'/users/'.$cM->Username.'/">'.$cM->Username.'</a>
				</div>
				<div class="large-10 cell">
					<div class="grid-x grid-align-x align-middle">
						<div class="auto cell">
							<div class="message-title">'.$cM->Title.'</div>
						</div>
						<div class="shrink cell right">
							';
							
							if ($cM->PrivateMessageSettings != 2 && $Receiver == 1 && $cM->Username != "Brick Create") {
							
								echo '
								<a href="#" class="button button-blue" style="display:inline-block;" onclick="showReply()" disabled>Reply</a>
								';
							
							}
							
							if ($cM->Username != "Brick Create") {
								
								echo '
								<form action="" method="POST" style="display:inline;">
									<button name="report_message" class="report-abuse report-abuse-inline"></button>
								</form>
								';
								
							}
							
							echo '
						</div>
					</div>
					<div class="message-time">'; if ($Receiver == 1) { echo 'Received'; } else { echo 'Sent'; } echo ' '.get_timeago($cM->TimeSent).'</div>
					<div class="message-divider"></div>
					<div class="message-body">
						'.nl2br(safeContent($cM->Message)).'
					</div>
				</div>
			</div>
		</div>
		';
		
		if ($cM->PrivateMessageSettings != 2 && $Receiver == 1) {
		
			echo '
			<div id="replyModule" style="display:none;">
				<div class="push-25"></div>
				<div class="container border-r md-padding">
					<h5>Write a reply</h5>
					<div class="push-15"></div>
					<a name="reply"></a>
					';
					
					if (isset($error_message)) {
						
						echo '
						<div class="error-message">
							'.$error_message.'
						</div>
						';
						
					}
					
					else if (isset($success_message)) {
						
						echo '
						<div class="success-message">
							'.$success_message.'
						</div>
						';
						
					}
					
					echo '
					<form action="" method="post">
						<textarea name="reply" class="normal-input message-reply" placeholder="Enter your message here." disabled></textarea>
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						<input type="submit" value="Send Reply" class="button button-blue" disabled>
					</form>
				</div>
			</div>
			<script>
				function showReply() {
					document.getElementById("replyModule").style.display = "block";
				}
			</script>
			';
		
		}
	
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");