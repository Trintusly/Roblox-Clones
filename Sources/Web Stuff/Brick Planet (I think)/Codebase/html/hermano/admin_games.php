<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	/*$GetUsers = $db->prepare("SELECT ID, Username FROM User WHERE Admin > 0 AND User.ID NOT IN(1,2639)");
	$GetUsers->execute();
	
	while ($gU = $GetUsers->fetch(PDO::FETCH_OBJ)) {

		$InsertUserGame = $db->prepare("INSERT INTO game.UserGame (UserID, Name, TimeCreated, TimeLastUpdated) VALUES(".$gU->ID.", '".$gU->Username."\'s Untitled Game', UNIX_TIMESTAMP(), UNIX_TIMESTAMP())");
		$InsertUserGame->execute();
	
	}*/