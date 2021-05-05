<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-Type: application/json');

	if (!$AUTH) {
		
		echo json_encode(array('status' => 'error', 'msg' => 'You must login before accessing this content.'));
		
	} else {
		
		$Action = (!empty($_POST['action'])) ? $_POST['action'] : NULL;
		$Username = (!empty($_POST['username'])) ? $_POST['username'] : NULL;
		$chatGroupId = (!empty($_POST['chatGroupId'])) ? (int)$_POST['chatGroupId'] : NULL;
		$Page = (!empty($_POST['p']) && is_numeric($_POST['p']) && floor((int)$_POST['p']) == (int)$_POST['p']) ? (int)$_POST['p'] : 1;
		if (!$Action || !$chatGroupId || $_SERVER['REQUEST_METHOD'] != 'POST') die;
		
		if ($Action == 'get-members') {
			
			$GetUserChatGroupMember = $db->prepare("SELECT COUNT(*) FROM UserChatGroupMember WHERE ChatGroupID = ? AND UserID = ".$myU->ID." AND Role > 0");
			$GetUserChatGroupMember->bindValue(1, $chatGroupId, PDO::PARAM_INT);
			$GetUserChatGroupMember->execute();
			
			if ($GetUserChatGroupMember->rowCount() == 0 || $GetUserChatGroupMember->fetchColumn() != 1) {
				
				echo json_encode(array('status' => 'error', 'msg' => 'You do not have permission to view this content.'));
				die;
				
			}
			
			$Results = array();
			
			if (!$Username) {
				$CountUserChatGroupMembers = $db->prepare("SELECT COUNT(*) FROM UserChatGroupMember JOIN User ON UserChatGroupMember.UserID = User.ID WHERE UserChatGroupMember.ChatGroupID = ?");
				$CountUserChatGroupMembers->bindValue(1, $chatGroupId, PDO::PARAM_INT);
				$CountUserChatGroupMembers->execute();
				$CountUserChatGroupMembers = $CountUserChatGroupMembers->fetchColumn();
			} else {
				$GetUserChatGroupMembers = $db->prepare("SELECT User.Username, User.AvatarURL, UserChatGroupMember.Role FROM UserChatGroupMember JOIN User ON UserChatGroupMember.UserID = User.ID WHERE UserChatGroupMember.ChatGroupID = ? AND MATCH(User.Username) AGAINST(?) ORDER BY User.Username ASC");
				$GetUserChatGroupMembers->bindValue(1, $chatGroupId, PDO::PARAM_INT);
				$GetUserChatGroupMembers->bindValue(2, $Username, PDO::PARAM_STR);
				$GetUserChatGroupMembers->execute();
				$CountUserChatGroupMembers = $db->prepare("SELECT COUNT(*) FROM UserChatGroupMember JOIN User ON UserChatGroupMember.UserID = User.ID WHERE UserChatGroupMember.ChatGroupID = ? AND MATCH(User.Username) AGAINST(?)");
				$CountUserChatGroupMembers->bindValue(1, $chatGroupId, PDO::PARAM_INT);
				$CountUserChatGroupMembers->bindValue(2, $Username, PDO::PARAM_STR);
				$CountUserChatGroupMembers->execute();
				$CountUserChatGroupMembers = $CountUserChatGroupMembers->fetchColumn();
			}
			
			$Limit = 10;
			$Pages = ceil($CountUserChatGroupMembers / $Limit);
			$Offset = ($Page - 1)  * $Limit;
			if ($Offset < 0) { $Offset = 0; }
			
			if (!$Username) {
				$GetUserChatGroupMembers = $db->prepare("SELECT User.Username, User.AvatarURL, UserChatGroupMember.Role FROM UserChatGroupMember JOIN User ON UserChatGroupMember.UserID = User.ID WHERE UserChatGroupMember.ChatGroupID = ? ORDER BY User.Username ASC LIMIT ? OFFSET ?");
				$GetUserChatGroupMembers->bindValue(1, $chatGroupId, PDO::PARAM_INT);
				$GetUserChatGroupMembers->bindValue(2, $Limit, PDO::PARAM_INT);
				$GetUserChatGroupMembers->bindValue(3, $Offset, PDO::PARAM_INT);
				$GetUserChatGroupMembers->execute();
			} else {
				$GetUserChatGroupMembers = $db->prepare("SELECT User.Username, User.AvatarURL, UserChatGroupMember.Role FROM UserChatGroupMember JOIN User ON UserChatGroupMember.UserID = User.ID WHERE UserChatGroupMember.ChatGroupID = ? AND MATCH(User.Username) AGAINST(?) ORDER BY User.Username ASC LIMIT ? OFFSET ?");
				$GetUserChatGroupMembers->bindValue(1, $chatGroupId, PDO::PARAM_INT);
				$GetUserChatGroupMembers->bindValue(2, $Username, PDO::PARAM_STR);
				$GetUserChatGroupMembers->bindValue(3, $Limit, PDO::PARAM_INT);
				$GetUserChatGroupMembers->bindValue(4, $Offset, PDO::PARAM_INT);
				$GetUserChatGroupMembers->execute();
			}
			
			while ($gU = $GetUserChatGroupMembers->fetch(PDO::FETCH_OBJ)) {
				
				array_push($Results, array('username' => $gU->Username, 'avatar' => $gU->AvatarURL, 'role' => (int)$gU->Role));
				
			}
			
			echo json_encode(array('status' => 'ok', 'data' => $Results, 'pages' => $Pages));
			
		} else if ($Action == 'kick-member' && $Username) {
			
			$GetUserChatGroupMember = $db->prepare("SELECT Role FROM UserChatGroupMember WHERE ChatGroupID = ? AND UserID = ".$myU->ID." AND Role > 0");
			$GetUserChatGroupMember->bindValue(1, $chatGroupId, PDO::PARAM_INT);
			$GetUserChatGroupMember->execute();
			$CountGet = $GetUserChatGroupMember->rowCount();
			
			if ($CountGet == 0) {
				
				echo json_encode(array('status' => 'error', 'msg' => 'Sorry, something went wrong.'));
				
			} else {
				
				$FetchRole = $GetUserChatGroupMember->fetchColumn();
				
				$DeleteUserChatGroupMember = $db->prepare("DELETE UserChatGroupMember FROM UserChatGroupMember JOIN User ON UserChatGroupMember.UserID = User.ID WHERE ChatGroupID = ? AND User.Username = ? AND UserChatGroupMember.Role < " . $FetchRole);
				$DeleteUserChatGroupMember->bindValue(1, $chatGroupId, PDO::PARAM_INT);
				$DeleteUserChatGroupMember->bindValue(2, $Username, PDO::PARAM_STR);
				$DeleteUserChatGroupMember->execute();
				$CountDelete = $DeleteUserChatGroupMember->rowCount();
				
				if ($CountDelete == 0) {
					
					echo json_encode(array('status' => 'error', 'msg' => 'Sorry, something went wrong.'));
					
				} else {
					
					echo json_encode(array('status' => 'ok'));
					
				}
				
			}
			
		}
		
	}