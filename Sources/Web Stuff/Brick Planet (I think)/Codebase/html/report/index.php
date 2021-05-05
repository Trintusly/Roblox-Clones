<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	requireLogin();

	if (empty($_SESSION['Report_ReferenceType']) && empty($_SESSION['Report_ReferenceID'])) {
		header("Location: /");
		die;
	}
	
	function clearReportSession() {
		unset($_SESSION['Report_ReferenceType']);
		unset($_SESSION['Report_ReferenceID']);
		header("Location: /");
		die;
	}
	
	if ($_SESSION['Report_ReferenceType'] == 1) {
		
		$query = $db->prepare("SELECT ForumThread.Title, ForumThread.Post, User.Username FROM ForumThread JOIN User ON ForumThread.UserID = User.ID WHERE ForumThread.ID = ?");
		$query->bindValue(1, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			clearReportSession();
			
		} else {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			$title = 'Report a thread by '.$q->Username.'';
			$content = '<b>Title:</b><div>'.$q->Title.'</div><div class="push-10"></div><b>Post:</b><div>'.$q->Post.'</div>';
			$user = $q->Username;
			
		}
		
	} else if ($_SESSION['Report_ReferenceType'] == 2) {
		
		$query = $db->prepare("SELECT ForumReply.ThreadID, ForumReply.Post, User.Username FROM ForumReply JOIN User ON ForumReply.UserID = User.ID WHERE ForumReply.ID = ?");
		$query->bindValue(1, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			clearReportSession();
			
		} else {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			$title = 'Report a forum reply by '.$q->Username.'';
			$content = '<b>Post:</b><div>'.$q->Post.'</div>';
			$user = $q->Username;
			
		}
		
	} else if ($_SESSION['Report_ReferenceType'] == 3) {
		
		$query = $db->prepare("SELECT User.Username, User.AvatarURL, User.About, User.PersonalStatus FROM User WHERE User.ID = ?");
		$query->bindValue(1, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			clearReportSession();
			
		} else {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			$title = 'Report user '.$q->Username.'';
			$content = '<b>Username:</b><div>'.$q->Username.'</div><div class="push-10"></div><b>Avatar:</b><div><img src="'.$cdnName . $q->AvatarURL.'-forum.png"></div>';
			$user = $q->Username;
			
		}
		
	} else if ($_SESSION['Report_ReferenceType'] == 4) {
		
		$query = $db->prepare("SELECT UserWall.Post, User.Username, Receiver.Username AS ReceiverUsername FROM UserWall JOIN User ON UserWall.PosterID = User.ID JOIN User AS Receiver ON UserWall.UserID = Receiver.ID WHERE UserWall.ID = ?");
		$query->bindValue(1, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			clearReportSession();
			
		} else {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			$title = 'Report a user wall post by '.$q->Username.'';
			$content = '<b>Wall Post:</b><div style="word-break:break-word;">'.$q->Post.'</div>';
			$user = $q->Username;
			
		}
		
	} else if ($_SESSION['Report_ReferenceType'] == 5) {
		
		$query = $db->prepare("SELECT UserMessage.ID, UserMessage.Title, UserMessage.Message, User.Username FROM UserMessage JOIN User ON UserMessage.SenderID = User.ID WHERE UserMessage.ID = ? AND UserMessage.ReceiverID = ".$myU->ID."");
		$query->bindValue(1, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			clearReportSession();
			
		} else {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			$title = 'Report a private message from <strong>'.$q->Username.'</strong>';
			$content = '<b>Title:</b><div style="word-break:break-word;">'.$q->Title.'</div><div class="push-10"></div><b>Message:</b><div style="word-break:break-word;">'.$q->Message.'</div>';
			$user = $q->Username;
			
		}
		
	} else if ($_SESSION['Report_ReferenceType'] == 6) {
		
		$query = $db->prepare("SELECT UserGroup.ID, UserGroup.Name, UserGroup.Description, UserGroup.OwnerType, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, User.Username FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID WHERE UserGroup.ID = ? AND UserGroup.OwnerID = (CASE UserGroup.OwnerType WHEN 1 THEN (SELECT User.ID FROM UserGroup AS UG JOIN User ON UG.OwnerID = User.ID WHERE UG.ID = UserGroup.OwnerID) ELSE UserGroup.OwnerID END)");
		$query->bindValue(1, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			clearReportSession();
			
		} else {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			$title = 'Report a group <strong>'.$q->Name.'</strong> owned by <strong>'.$q->Username.'</strong>';
			$content = '<b>Group Name:</b><div style="word-break:break-word;">'.$q->Name.'</div><div class="push-10"></div><b>Group Description:</b><div style="word-break:break-word;">'.$q->Description.'</div><div class="push-10"></div><b>Group Logo:</b><div><img src="'.$cdnName . $q->LogoImage.'" width="100"></div>';
			$user = $q->Username;
			
		}
		
	} else if ($_SESSION['Report_ReferenceType'] == 7) {
		
		$query = $db->prepare("SELECT UserGroup.ID, UserGroup.Name, UserGroupWall.Message, (SELECT COUNT(*) FROM UserGroupMember WHERE UserGroupMember.GroupID = UserGroupWall.GroupID AND UserGroupMember.UserID = ".$myU->ID.") AS IsMember, User.Username FROM UserGroupWall JOIN User ON UserGroupWall.UserID = User.ID JOIN UserGroup ON UserGroupWall.GroupID = UserGroup.ID WHERE UserGroupWall.ID = ?");
		$query->bindValue(1, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			clearReportSession();
			
		}
		
		else {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			
			if ($q->IsMember == 0) {
				
				clearReportSession();
				
			} else {
				
				$title = 'Report a group wall post by <strong>'.$q->Username.'</strong>';
				$content = '<b>Group Wall Post:</b><div style="word-break:break-word;">'.$q->Message.'</div>';
				$user = $q->Username;
				
			}
			
		}
		
	} else if ($_SESSION['Report_ReferenceType'] == 8) {
		
		$query = $db->prepare("SELECT Item.ID, Item.Name, Item.Description, Item.PreviewImage, User.Username FROM Item JOIN User ON Item.CreatorID = User.ID WHERE Item.ID = ?");
		$query->bindValue(1, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			clearReportSession();
			
		} else {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			$title = 'Report an item by <strong>'.$q->Username.'</strong>';
			$content = '<b>Item Name:</b><div style="word-break:break-word;">'.$q->Name.'</div><div class="push-10"></div><b>Item Description:</b><div style="word-break:break-word;">'.$q->Description.'</div><div class="push-10"></div><b>Item Preview:</b><div><img src="'.$cdnName . $q->PreviewImage.'" width="100"></div>';
			$user = $q->Username;
			
		}
		
	} else if ($_SESSION['Report_ReferenceType'] == 9) {
		
		$query = $db->prepare("SELECT Item.ID, Item.Name, Item.Description, Item.PreviewImage, UserGroup.Name AS GroupName FROM Item JOIN UserGroup ON Item.CreatorID = UserGroup.ID WHERE Item.ID = ?");
		$query->bindValue(1, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			clearReportSession();
			
		} else {
			
			$q = $query->fetch(PDO::FETCH_OBJ);
			$title = 'Report an item by the group <strong>'.$q->GroupName.'</strong>';
			$content = '<b>Item Name:</b><div style="word-break:break-word;">'.$q->Name.'</div><div class="push-10"></div><b>Item Description:</b><div style="word-break:break-word;">'.$q->Description.'</div><div class="push-10"></div><b>Item Preview:</b><div><img src="'.$cdnName . $q->PreviewImage.'" width="100"></div>';
			$user = $q->Username;
			
		}
		
	}
	
	$RedirectURL = ''.$serverName.'';
	
	switch ($_SESSION['Report_ReferenceType']) {
		case 1:
			$RedirectURL = ''.$serverName.'/forum/thread/'.$_SESSION['Report_ReferenceID'].'/';
			break;
		case 2:
			$RedirectURL = ''.$serverName.'/forum/thread/'.$q->ThreadID.'/#'.$_SESSION['Report_ReferenceID'].'';
			break;
		case 3:
			$RedirectURL = ''.$serverName.'/users/'.$q->Username.'/';
			break;
		case 4:
			$RedirectURL = ''.$serverName.'/users/'.$q->ReceiverUsername.'/';
			break;
		case 5:
			$RedirectURL = ''.$serverName.'/account/message/'.$q->ID.'/';
			break;
		case 6:
			$RedirectURL = ''.$serverName.'/groups/'.$q->ID.'/'.str_replace(' ', '-', $q->Name).'/';
			break;
		case 7:
			$RedirectURL = ''.$serverName.'/groups/'.$q->ID.'/'.str_replace(' ', '-', $q->Name).'/';
			break;
		case 8:
			$RedirectURL = ''.$serverName.'/store/view/'.$q->ID.'/';
			break;
		case 9:
			$RedirectURL = ''.$serverName.'/store/view/'.$q->ID.'/';
			break;
	}
	
	if (isset($_POST['s'])) {
		
		$allowedChoiceArray = array(1, 2, 3, 4, 5, 6, 7);
		
		if (empty($_POST['choice']) || !is_numeric($_POST['choice']) || !in_array($_POST['choice'], $allowedChoiceArray)) {
			
			$error = 'Please choose how this person is breaking the Brick Create rules.';
			
		} else {
			
			$Comment = htmlentities(strip_tags(substr($_POST['comment'], 0, 128)));
			
			$count = $db->prepare("SELECT COUNT(*) FROM admin_panel.UserReport WHERE (ReferenceType = ? AND ReferenceID = ?) OR (UserID = ".$myU->ID." AND TimeReport > ".(time()+120).")");
			$count->bindValue(1, $_SESSION['Report_ReferenceType'], PDO::PARAM_INT);
			$count->bindValue(2, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
			$count->execute();
			
			if ($count->fetchColumn() == 0) {
				
				$insert = $db->prepare("INSERT INTO admin_panel.UserReport (UserID, ReportType, ReferenceType, ReferenceID, Comment, TimeReport) VALUES(".$myU->ID.", ?, ?, ?, ?, ".time().")");
				$insert->bindValue(1, $_POST['choice'], PDO::PARAM_INT);
				$insert->bindValue(2, $_SESSION['Report_ReferenceType'], PDO::PARAM_INT);
				$insert->bindValue(3, $_SESSION['Report_ReferenceID'], PDO::PARAM_INT);
				$insert->bindValue(4, $Comment, PDO::PARAM_STR);
				$insert->execute();
				
			}
			
			$success = 'Thank you for reporting this content! Our moderators will look into this report and determine the best course of action. Redirecting...';
			
		}
		
	}
	
	echo '
	<!DOCTYPE html>
	<html>
		<head>
			<title>Report - Brick Create</title>
			<link rel="stylesheet" href="'.$serverName.'/assets/css/foundation.css">
			<link rel="stylesheet" href="'.$serverName.'/assets/css/'.$CSSFile.'">
		</head>
		<body>
			<div style="height:50px;"></div>
			<div class="grid-x grid-margin-x">
				<div class="large-8 cell large-offset-2">
					';
					
					if (isset($error)) {
						
						echo '
						<div class="error-message">
							'.$error.'
						</div>
						';
					
					} else if (isset($success)) {
						
						echo '
						<div class="success-message">
							'.$success.'
						</div>
						<meta http-equiv="refresh" content="1;url='.$RedirectURL.'" />
						';
						
					}
					
					echo '
					<div class="container border-r md-padding">
						<h4>'.$title.'</h4>
						<div class="push-15"></div>
						<div class="report-content">'.$content.'</div>
						<div class="push-15"></div>
						<form action="" method="POST" class="report-form">
							<p class="report-subtitle"><strong>How is this content breaking the Brick Create rules?</strong></p>
							<div><input type="radio" name="choice" value="1" id="choice_01"><label for="choice_01">This content contains <strong>bad word(s)</strong></label></div>
							<div><input type="radio" name="choice" value="2" id="choice_02"><label for="choice_02">This content is <strong>inappropriate</strong></label></div>
							<div><input type="radio" name="choice" value="3" id="choice_03"><label for="choice_03">This content is <strong>harassing</strong> me or somebody else</label></div>
							<div><input type="radio" name="choice" value="5" id="choice_05"><label for="choice_05">This content includes <strong>personal information</strong></label></div>
							<div><input type="radio" name="choice" value="4" id="choice_04"><label for="choice_04">This content is <strong>spam</strong></label></div>
							<div><input type="radio" name="choice" value="6" id="choice_06"><label for="choice_06">Other</label></div>
							<div class="push-15"></div>
							<p class="report-subtitle"><strong>Leave a comment (optional)</strong></p>
							<textarea name="comment" class="normal-input" placeholder="This person is breaking the rules by..." style="height:75px;"></textarea>
							<p class="report-warning">Please note intentional abuse of the report system may result in moderation action.</p>
							<input type="submit" name="s" class="button button-blue" value="Send Report">
						</form>
					</div>
				</div>
			</div>
		</body>
	</html>
	';