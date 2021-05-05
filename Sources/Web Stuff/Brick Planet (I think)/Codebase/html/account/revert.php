<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	if ($_GET['type'] == 'password') {
		
		$getData = $db->prepare("SELECT UserPasswordChanges.UserID, UserPasswordChanges.PreviousPassword, Users.Username, Users.Email FROM UserPasswordChanges JOIN Users ON Users.ID = UserPasswordChanges.UserID WHERE UserPasswordChanges.RevertCode = ? AND UserPasswordChanges.Expire > ".time()."");
		$getData->bindValue(1, $_GET['key'], PDO::PARAM_STR);
		$getData->execute();
		
		if ($getData->rowCount() > 0) {
			
			$gD = $getData->fetch(PDO::FETCH_OBJ);
			
			$updateUser = $db->prepare("UPDATE Users SET Password = '".$gD->PreviousPassword."' WHERE ID = ".$gD->UserID."");
			$updateUser->execute();
			
			$disableRevert = $db->prepare("UPDATE UserPasswordChanges SET Reverted = 1 WHERE UserID = ".$gD->UserID."");
			$disableRevert->execute();
			
			$email = $db->prepare("INSERT INTO EmailQueue (UserID, Type, Time, IP, Email) VALUES(?, ?, ?, ?, ?)");
			$email->bindValue(1, $gD->UserID, PDO::PARAM_INT);
			$email->bindValue(2, 3, PDO::PARAM_INT);
			$email->bindValue(3, time(), PDO::PARAM_INT);
			$email->bindValue(4, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
			$email->bindValue(5, $gD->Email, PDO::PARAM_STR);
			$email->execute();
			
			$cache->delete($gD->Username);
			
		}
		
	}
	
	else if ($_GET['type'] == 'email') {
		
		$getData = $db->prepare("SELECT UserEmailChanges.UserID, UserEmailChanges.PreviousEmail, Users.Username, Users.Email FROM UserEmailChanges JOIN Users ON Users.ID = UserEmailChanges.UserID WHERE UserEmailChanges.RevertCode = ? AND UserEmailChanges.Expire > ".time()."");
		$getData->bindValue(1, $_GET['key'], PDO::PARAM_STR);
		$getData->execute();
		
		if ($getData->rowCount() > 0) {
			
			$gD = $getData->fetch(PDO::FETCH_OBJ);
			
			$updateUser = $db->prepare("UPDATE Users SET Email = '".$gD->PreviousEmail."' WHERE ID = ".$gD->UserID."");
			$updateUser->execute();
			
			$disableRevert = $db->prepare("UPDATE UserEmailChanges SET Reverted = 1 WHERE UserID = ".$gD->UserID."");
			$disableRevert->execute();
			
			$email = $db->prepare("INSERT INTO EmailQueue (UserID, Type, Time, IP, Email) VALUES(?, ?, ?, ?, ?)");
			$email->bindValue(1, $gD->UserID, PDO::PARAM_INT);
			$email->bindValue(2, 5, PDO::PARAM_INT);
			$email->bindValue(3, time(), PDO::PARAM_INT);
			$email->bindValue(4, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
			$email->bindValue(5, $gD->PreviousEmail, PDO::PARAM_STR);
			$email->execute();
			
			$cache->delete($gD->Username);
			
		}
		
	}
	
	header("Location: ".$serverName."/login/");
	die;