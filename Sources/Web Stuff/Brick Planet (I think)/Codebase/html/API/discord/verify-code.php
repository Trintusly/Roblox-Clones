<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");

	header("HTTP/1.1 500 Internal Server Error");

	$Key = (!empty($_POST['Key'])) ? $_POST['Key'] : NULL;
	$DiscordId = (!empty($_POST['DiscordId']) && is_numeric($_POST['DiscordId']) && floor($_POST['DiscordId']) == (int)$_POST['DiscordId']) ? (int)$_POST['DiscordId'] : NULL;
	
	if (!empty($Key) && !empty($DiscordId)) {
		
		$GetUserDiscordVerify = $db->prepare("SELECT User.ID, User.Username, User.VIP FROM UserDiscordVerify JOIN User ON UserDiscordVerify.UserID = User.ID WHERE UserDiscordVerify.`Key` = ? AND UserDiscordVerify.TimeInitiated+900 > ".time()."");
		$GetUserDiscordVerify->bindValue(1, $Key, PDO::PARAM_STR);
		$GetUserDiscordVerify->execute();
		
		if ($GetUserDiscordVerify->rowCount() > 0) {
			
			$gV = $GetUserDiscordVerify->fetch(PDO::FETCH_OBJ);
			
			$db->beginTransaction();
			
			$DeleteUserDiscordVerify = $db->prepare("DELETE FROM UserDiscordVerify WHERE UserDiscordVerify.`Key` = ?");
			$DeleteUserDiscordVerify->bindValue(1, $Key, PDO::PARAM_STR);
			$DeleteUserDiscordVerify->execute();
			
			$UpdateUser = $db->prepare("UPDATE User SET DiscordId = ? WHERE ID = ".$gV->ID);
			$UpdateUser->bindValue(1, $DiscordId, PDO::PARAM_STR);
			$UpdateUser->execute();
			
			if ($DeleteUserDiscordVerify->rowCount() > 0 && $UpdateUser->rowCount() > 0) {
				
				echo json_encode(array('username' => $gV->Username, 'vip' => $gV->VIP));
				header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK', true, 200);
				$db->commit();
				
			} else {
				$db->rollBack();
			}
			
		}
		
	}