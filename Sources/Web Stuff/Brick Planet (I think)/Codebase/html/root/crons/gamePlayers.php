<?php
require_once('/var/www/html/root/private/db.php');

	$UpdateUsers = $db->prepare("UPDATE User SET User.InGame = 0, User.InGameId = NULL WHERE User.InGame = 1 AND User.InGameTime+60 < UNIX_TIMESTAMP()");
	$UpdateUsers->execute();

	$UpdateUserGame = $db->prepare("UPDATE game.UserGame SET NumInGame = (SELECT COUNT(*) FROM User WHERE User.InGameId = UserGame.ID) WHERE NumInGame > 0");
	$UpdateUserGame->execute();