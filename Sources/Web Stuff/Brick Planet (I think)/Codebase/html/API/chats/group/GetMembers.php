<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-Type: application/json');

	if (!$AUTH) {
		
		echo json_encode(array('status' => 'error', 'msg' => 'You must login before accessing this content.'));
		
	} else {
		
		$chatGroupId = (!empty($_GET['chatGroupId'])) ? (int)$_GET['chatGroupId'] : NULL;
		$Page = (!empty($_GET['p']) && is_numeric($_GET['p']) && floor((int)$_GET['p']) == (int)$_GET['p']) ? (int)$_GET['p'] : 1;
		
		$GetUserChatGroupMember = $db->prepare("SELECT COUNT(*) FROM UserChatGroupMember WHERE ChatGroupID = ? AND UserID = ".$myU->ID."");
		$GetUserChatGroupMember->bindValue(1, $chatGroupId, PDO::PARAM_INT);
		$GetUserChatGroupMember->execute();
		
		if ($GetUserChatGroupMember->rowCount() == 0 || $GetUserChatGroupMember->fetchColumn() != 1) {
			
			echo json_encode(array('status' => 'error', 'msg' => 'You do not have permission to view this content.'));
			die;
			
		}
		
		$Results = array();
		
		$CountUserChatGroupMember = $db->prepare("SELECT COUNT(*) FROM UserChatGroupMember JOIN User ON UserChatGroupMember.UserID = User.ID WHERE UserChatGroupMember.ChatGroupID = ?");
		$CountUserChatGroupMember->bindValue(1, $chatGroupId, PDO::PARAM_INT);
		$CountUserChatGroupMember->execute();
		$CountUserChatGroupMember = $CountUserChatGroupMember->fetchColumn();
		
		$Limit = 10;
		$Pages = ceil($CountUserChatGroupMember / $Limit);
		$Offset = ($Page - 1)  * $Limit;
		if ($Offset < 0) { $Offset = 0; }
		
		$GetUserChatGroupMember = $db->prepare("SELECT User.Username, User.AvatarURL, UserChatGroupMember.Role FROM UserChatGroupMember JOIN User ON UserChatGroupMember.UserID = User.ID WHERE UserChatGroupMember.ChatGroupID = ? ORDER BY User.Username ASC LIMIT ? OFFSET ?");
		$GetUserChatGroupMember->bindValue(1, $chatGroupId, PDO::PARAM_INT);
		$GetUserChatGroupMember->bindValue(2, $Limit, PDO::PARAM_INT);
		$GetUserChatGroupMember->bindValue(3, $Offset, PDO::PARAM_INT);
		$GetUserChatGroupMember->execute();
		
		while ($gU = $GetUserChatGroupMember->fetch(PDO::FETCH_OBJ)) {
			
			array_push($Results, array('username' => $gU->Username, 'avatar' => $gU->AvatarURL, 'role' => (int)$gU->Role));
			
		}
		
		echo json_encode(array('status' => 'ok', 'totalCount' => $CountUserChatGroupMember, 'data' => $Results, 'pages' => $Pages));
		
	}