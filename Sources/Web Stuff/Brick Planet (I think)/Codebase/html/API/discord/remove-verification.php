<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");

	header("HTTP/1.1 500 Internal Server Error");

	$DiscordId = (!empty($_POST['DiscordId']) && is_numeric($_POST['DiscordId']) && floor($_POST['DiscordId']) == (int)$_POST['DiscordId']) ? (int)$_POST['DiscordId'] : NULL;
	
	if (!empty($DiscordId)) {
		
		$UpdateUser = $db->prepare("UPDATE User SET DiscordId = 0 WHERE DiscordId = ?");
		$UpdateUser->bindValue(1, $DiscordId, PDO::PARAM_STR);
		$UpdateUser->execute();
		
		header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK', true, 200);
		
	}