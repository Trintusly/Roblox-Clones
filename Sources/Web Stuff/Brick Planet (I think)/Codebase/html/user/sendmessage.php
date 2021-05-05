<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	$checkUser = $db->prepare("SELECT User.ID, User.Username, User.PrivateMessageSettings FROM User WHERE User.Username = ? AND User.ID != ".$myU->ID."");
	$checkUser->bindValue(1, $_GET['username'], PDO::PARAM_STR);
	$checkUser->execute();
	
	$numUser = $checkUser->rowCount();
	
	if ($numUser == 0) {
	
		header("Location: ".$serverName."/search/");
		die;
	
	}
	
	else {
	
		$cU = $checkUser->fetch(PDO::FETCH_OBJ);
		
		if ($cU->Username == "Brick Create") {
			header("Location: /error/?errorcode=404");
			die;
		}
		
		$checkBlocked = $db->prepare("SELECT COUNT(*) FROM UserBlocked WHERE UserBlocked.RequesterID = ".$cU->ID." AND UserBlocked.BlockedID = ".$myU->ID."");
		$checkBlocked->execute();
		
		if ($checkBlocked->fetchColumn() > 0) {
			
			header("Location: ".$serverName."/search/");
			die;
			
		}
		
		if ($cU->PrivateMessageSettings == 1) {
		
			$checkActiveFriends = $db->prepare("SELECT COUNT(*) FROM Friend WHERE Friend.SenderID = ".$myU->ID." AND Friend.ReceiverID = ".$cU->ID." AND Friend.Accepted = 1");
			$checkActiveFriends->execute();
			
			if ($checkActiveFriends->fetchColumn() == 0) {
				
				header("Location: ".$serverName."/users/".$cU->Username."/");
				die;
				
			}
		
		}
		
		else if ($cU->PrivateMessageSettings == 2) {
			
			header("Location: ".$serverName."/users/".$cU->Username."/");
			die;
			
		}
		
		if (isset($_POST['title']) && isset($_POST['message']) && isset($_POST['csrf_token']) && $myU->AccountVerified > 0 && 1 == 2) {
			
			$getLastMessage = $db->prepare("SELECT COUNT(UserMessage.ID) FROM UserMessage WHERE SenderID = ".$myU->ID." AND Title = ? AND Message = ? AND TimeSent < ".(time()+600)."");
			$getLastMessage->bindValue(1, $_POST['title'], PDO::PARAM_STR);
			$getLastMessage->bindValue(2, $_POST['message'], PDO::PARAM_STR);
			$getLastMessage->execute();
			
			if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {
				
				$error_message = 'Invalid CSRF token, please refresh and try again.';
				
			} else if ($myU->UserFlood > time() || $getLastMessage->fetchColumn() > 0) {
			
				$error_message = 'Please wait before sending a message again.';
			
			} else if ($myU->TimeRegister+21600 > time()) {
				
				$error_message = 'Your account must be at least 6 hours old before sending messages.';
				
			} else if (empty($_POST['title']) || empty($_POST['message'])) {
			
				$error_message = 'All fields are required below.';
			
			} else if (strlen($_POST['title']) < 3 || strlen($_POST['title']) > 50) {
			
				$error_message = 'Title must be between 3-50 characters.';
				
			} else if (isProfanity($_POST['title']) == 1) {
				
				$error_message = 'One or more words in your message title has triggered our profanity filter. Please correct and try again.';
			
			} else if (strlen($_POST['message']) < 3 || strlen($_POST['message']) > 1000) {
			
				$error_message = 'Message must be at least 3 characters.';
				
			} else if (isProfanity($_POST['message']) == 1) {
				
				$error_message = 'One or more words in your message has triggered our profanity filter. Please correct and try again.';
			
			} else {
			
				$sendMessage = $db->prepare("INSERT INTO UserMessage (SenderID, ReceiverID, Title, Message, TimeSent) VALUES(".$myU->ID.", ".$cU->ID.", ?, ?, ?)");
				$sendMessage->bindValue(1, htmlentities(strip_tags($_POST['title'])), PDO::PARAM_STR);
				$sendMessage->bindValue(2, htmlentities(strip_tags($_POST['message'])), PDO::PARAM_STR);
				$sendMessage->bindValue(3, time(), PDO::PARAM_INT);
				$sendMessage->execute();
				
				$updateFlood = $db->prepare("UPDATE User SET User.UserFlood = ".(time()+30)." WHERE User.ID = ".$myU->ID."");
				$updateFlood->execute();
				
				$_SESSION['ProfileMessageSent'] = '1';
				
				header("Location: ".$serverName."/users/".$cU->Username."/");
				die;
			
			}
		
		}
		
		echo '
		<script>
			document.title = "Send Message - Brick Create";
		</script>
		';
		
		if (isset($error_message)) {
			
			echo '
			<div class="card-panel red" style="color:white;">
				'.$error_message.'
			</div>
			';
			
		}
		
		echo '
		<div class="error-message">Private messages are currently disabled. Please try again later.</div>
		<div class="container-header md-padding">
			<strong>Sending Message to: </strong>'.$cU->Username.'
		</div>
		<div class="container border-wh md-padding">
			<form method="post">
				<input type="text" name="title" id="title" class="normal-input" '; if ($myU->AccountVerified == 0) { echo 'disabled placeholder="Please verify your account to send a message."'; } else { echo 'placeholder="Title"'; } echo ' disabled>
				<div class="push-15"></div>
				<textarea id="message" name="message" class="normal-input" style="height:125px !important;" '; if ($myU->AccountVerified == 0) { echo 'disabled placeholder="Please verify your account to send a message."'; } else { echo 'placeholder="Message"'; } echo ' disabled></textarea>
				<div class="push-15"></div>
				<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
				<input type="submit" value="Send Message" class="button button-green" disabled>
			</form>
		</div>
		';
		
	}
	
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");