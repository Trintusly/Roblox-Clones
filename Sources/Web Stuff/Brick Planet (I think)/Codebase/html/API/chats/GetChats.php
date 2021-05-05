<?php
header('Content-Type: application/json');
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");
	
	requireLogin();
	
	$Type = (!empty($_GET['type']) && ($_GET['type'] == 'user' || $_GET['type'] == 'group' || $_GET['type'] == 'notification')) ? $_GET['type'] : NULL;
	$Page = (!empty($_GET['p']) && is_numeric($_GET['p']) && floor((int)$_GET['p']) == (int)$_GET['p']) ? (int)$_GET['p'] : 1;
	
	$Limit = 25;
	$Offset = ($Page - 1) * $Limit;
	if ($Offset < 0) { $Offset = 0; }
	
	if ($Type == 'user') {
		
		$Username = (!empty($_GET['id'])) ? $_GET['id'] : NULL;
		
		$CountChats = $db->prepare("SELECT COUNT(*) FROM UserChat JOIN User AS S ON UserChat.SenderID = S.ID JOIN User AS R ON UserChat.ReceiverID = R.ID WHERE (R.ID = ".$myU->ID." AND S.Username = ?) OR (R.Username = ? AND S.ID = ".$myU->ID.")");
		$CountChats->bindValue(1, $Username, PDO::PARAM_STR);
		$CountChats->bindValue(2, $Username, PDO::PARAM_STR);
		$CountChats->execute();
		$CountChats = $CountChats->fetchColumn();
		
		$Pages = ceil($CountChats / $Limit);
		
		$GetChats = $db->prepare("SELECT S.ID AS SID, S.Username AS SUsername, S.AvatarURL AS SAvatarURL, R.ID AS RID, R.Username AS RUsername, R.AvatarURL AS RAvatarURL, UserChat.Message, UserChat.TimeChat FROM UserChat JOIN User AS S ON UserChat.SenderID = S.ID JOIN User AS R ON UserChat.ReceiverID = R.ID WHERE (R.ID = ".$myU->ID." AND S.Username = ?) OR (R.Username = ? AND S.ID = ".$myU->ID.") ORDER BY UserChat.TimeChat DESC LIMIT ? OFFSET ?");
		$GetChats->bindValue(1, $Username, PDO::PARAM_STR);
		$GetChats->bindValue(2, $Username, PDO::PARAM_STR);
		$GetChats->bindValue(3, $Limit, PDO::PARAM_INT);
		$GetChats->bindValue(4, $Offset, PDO::PARAM_INT);
		$GetChats->execute();
		
	} else if ($Type == 'group') {
		
		$GroupId = (!empty($_GET['id'])) ? (int)$_GET['id'] : NULL;
		
		$CountChats = $db->prepare("SELECT COUNT(*) FROM UserChatGroupMessage JOIN User ON UserChatGroupMessage.UserID = User.ID WHERE UserChatGroupMessage.ChatGroupID = ?");
		$CountChats->bindValue(1, $GroupId, PDO::PARAM_INT);
		$CountChats->execute();
		$CountChats = $CountChats->fetchColumn();
		
		$Pages = ceil($CountChats / $Limit);
		
		$GetChats = $db->prepare("SELECT User.ID, User.Username, User.AvatarURL, UserChatGroupMessage.Message, UserChatGroupMessage.TimeChat FROM UserChatGroupMessage JOIN User ON UserChatGroupMessage.UserID = User.ID WHERE UserChatGroupMessage.ChatGroupID = ? ORDER BY UserChatGroupMessage.TimeChat DESC LIMIT ? OFFSET ?");
		$GetChats->bindValue(1, $GroupId, PDO::PARAM_INT);
		$GetChats->bindValue(2, $Limit, PDO::PARAM_INT);
		$GetChats->bindValue(3, $Offset, PDO::PARAM_INT);
		$GetChats->execute();
		
	} else if ($Type == 'notification') {
		
		$Username = (!empty($_GET['id'])) ? $_GET['id'] : NULL;
		
		$CountChats = $db->prepare("SELECT COUNT(*) FROM UserNotificationMessage JOIN User ON UserNotificationMessage.UserID = User.ID WHERE User.Username = ?");
		$CountChats->bindValue(1, $Username, PDO::PARAM_STR);
		$CountChats->execute();
		$CountChats = $CountChats->fetchColumn();
		
		$Pages = ceil($CountChats / $Limit);
		
		$GetChats = $db->prepare("SELECT User.ID, User.Username, User.AvatarURL, UserNotificationMessage.Title, UserNotificationMessage.Message, UserNotificationMessage.TimeMessage FROM UserNotificationMessage JOIN User ON UserNotificationMessage.UserID = User.ID WHERE User.Username = ? ORDER BY UserNotificationMessage.TimeMessage DESC LIMIT ? OFFSET ?");
		$GetChats->bindValue(1, $Username, PDO::PARAM_STR);
		$GetChats->bindValue(2, $Limit, PDO::PARAM_INT);
		$GetChats->bindValue(3, $Offset, PDO::PARAM_INT);
		$GetChats->execute();
		
	}
	
	if ($CountChats == 0) {
	
		echo json_encode(array('status' => 'error', 'msg' => 'No chats found.'));
	
	} else {
	
		$Results = array();
		
		while ($gC = $GetChats->fetch(PDO::FETCH_OBJ)) {
			
			$Username = null;
			$AvatarURL = null;
			$OrientationType = null;
			
			if ($Type == 'user') {
				$Username = $gC->SUsername;
				$AvatarURL = $gC->SAvatarURL;
				if ($gC->SID == $myU->ID) {
					$OrientationType = 'self';
				} else {
					$OrientationType = 'other';
				}
			} else if ($Type == 'group') {
				$Username = $gC->Username;
				$AvatarURL = $gC->AvatarURL;
				if ($gC->ID == $myU->ID) {
					$OrientationType = 'self';
				} else {
					$OrientationType = 'other';
				}
			}
			
			if ($Type != 'notification') {
				$Row = array('username' => $Username, 'image' => $AvatarURL, 'message' => $gC->Message, 'timeChat' => iso8601($gC->TimeChat), 'orientation' => $OrientationType);
			} else {
				$Row = array('username' => $gC->Username, 'image'=> $gC->AvatarURL, 'title' => $gC->Title, 'message' => '<strong>'.$gC->Title.'</strong><div class="push-5"></div>' . nl2br($gC->Message), 'timeChat' => iso8601($gC->TimeMessage), 'orientation' => 'other');
			}
			array_push($Results, $Row);
			
		}
		
		echo json_encode(array('status' => 'ok', 'results' => $Results));
	
	}