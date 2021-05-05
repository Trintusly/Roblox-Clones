<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-Type: application/json');

	if (!$AUTH) {
		
		echo json_encode(array('status' => 'error', 'msg' => 'You must login before accessing this content.'));
		
	} else {
		
		$Action = (!empty($_POST['action'])) ? $_POST['action'] : NULL;
		$Username = (!empty($_POST['username'])) ? $_POST['username'] : NULL;
		$Name = (!empty($_POST['name'])) ? $_POST['name'] : NULL;
		$chatGroupId = (!empty($_POST['chatGroupId'])) ? (int)$_POST['chatGroupId'] : NULL;
		if (!$Action || !$chatGroupId || $_SERVER['REQUEST_METHOD'] != 'POST') die;
		
		$GetUserChatGroup = $db->prepare("SELECT ID, TimeUpdate FROM UserChatGroup WHERE ID = ? AND OwnerID = ".$myU->ID);
		$GetUserChatGroup->bindValue(1, $chatGroupId, PDO::PARAM_INT);
		$GetUserChatGroup->execute();
		if ($GetUserChatGroup->rowCount() == 0) die;
		$gC = $GetUserChatGroup->fetch(PDO::FETCH_OBJ);
		
		if ($gC->TimeUpdate+60 > time()) {
			
			echo json_encode(array('status' => 'error', 'msg' => 'Please wait <strong>'.$gC->TimeUpdate+60 - time().'</strong> more seconds before editing your group chat.'));
			die;
			
		}
		
		if ($Action == 'refresh-invite-code') {
			
			$NewCode = generateRandomString(10);
			
			$UpdateUserChatGroup = $db->prepare("UPDATE UserChatGroup SET InviteCode = ? WHERE ID = ? AND OwnerID = " . $myU->ID);
			$UpdateUserChatGroup->bindValue(1, $NewCode, PDO::PARAM_STR);
			$UpdateUserChatGroup->bindValue(2, $chatGroupId, PDO::PARAM_INT);
			$UpdateUserChatGroup->execute();
			$CountUpdate = $UpdateUserChatGroup->rowCount();
			
			if ($CountUpdate == 0) {
				
				echo json_encode(array('status' => 'error', 'msg' => 'Sorry, something went wrong. Please try again.'));
				
			} else {
				
				echo json_encode(array('status' => 'ok', 'code' => $NewCode));
				
			}
			
		} else if ($Action == 'edit-name' && $Name) {
			
			$Name = htmlentities(strip_tags(substr($Name, 0, 40)));
			
			if (!ctype_alnum($Name)) {
				
				echo json_encode(array('status' => 'error', 'msg' => 'We\'re sorry, your name can only contain alphanumeric characters.'));
				die;
			
			} else if (isProfanity($Name) == 1) {
				
				echo json_encode(array('status' => 'error', 'msg' => 'Sorry, something went wrong. Please try again.'));
				die;
				
			}
			
			$UpdateChatGroup = $db->prepare("UPDATE UserChatGroup SET Name = ? WHERE ID = ? AND OwnerID = " . $myU->ID);
			$UpdateChatGroup->bindValue(1, $Name, PDO::PARAM_STR);
			$UpdateChatGroup->bindValue(2, $chatGroupId, PDO::PARAM_INT);
			$UpdateChatGroup->execute();
			$CountUpdate = $UpdateChatGroup->rowCount();
			
			if ($CountUpdate == 0) {
				
				echo json_encode(array('status' => 'error', 'msg' => 'Sorry, something went wrong. Please try again.'));
				
			} else {
				
				echo json_encode(array('status' => 'ok', 'msg' => $Name));
				
			}
			
		}
		
	}