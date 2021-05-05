<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");
	
	if ($AUTH) {
	
		$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", 'Logged out', ".time().", ?)");
		$InsertUserActionLog->bindValue(1, $UserIP, PDO::PARAM_STR);
		$InsertUserActionLog->execute();
		
		$cache->delete($myU->ID);
		unset($_SESSION['UserID']);
	
	}
	
	header("Location: " . $serverName);
	die;