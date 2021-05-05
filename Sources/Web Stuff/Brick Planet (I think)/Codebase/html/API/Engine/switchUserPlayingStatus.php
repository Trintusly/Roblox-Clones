<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");
require_once($_SERVER['DOCUMENT_ROOT']."/../private/memcached.php");

	header('Content-Type: application/json');
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	$secureToken = (!empty($_SERVER['HTTP_AUTHORIZATION'])) ? trim($_SERVER['HTTP_AUTHORIZATION']) : null;
	$TokenData = $cache->get('GameAuthToken_' . $secureToken);
	$Switch = (!empty($_GET['switch']) && in_array($_GET['switch'], array('join', 'leave'))) ? $_GET['switch'] : null;
	if (!$secureToken || !$TokenData || !$Switch) die;
	if ($_SERVER['REQUEST_METHOD'] != 'GET') die;
	
	header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK', true, 200);
	
	if ($Switch == 'join') {
		$UpdateUser = $db->prepare("UPDATE User SET InGame = 1, InGameId = ".$TokenData['gameId'].", InGameTime = UNIX_TIMESTAMP(), TimeLastSeen = UNIX_TIMESTAMP() WHERE ID = ".$TokenData['userId']."");
		$UpdateUser->execute();
		$UpdateUserGame = $db->prepare("UPDATE game.UserGame SET NumInGame = (SELECT COUNT(*) FROM User WHERE User.InGameId = UserGame.ID) WHERE ID = ".$TokenData['gameId']."");
		$UpdateUserGame->execute();
	} else if ($Switch == 'leave') {
		$UpdateUser = $db->prepare("UPDATE User SET InGame = 0, InGameId = NULL, TimeLastSeen = UNIX_TIMESTAMP() WHERE ID = ".$TokenData['userId']."");
		$UpdateUser->execute();
		$UpdateUserGame = $db->prepare("UPDATE game.UserGame SET NumInGame = (SELECT COUNT(*) FROM User WHERE User.InGameId = UserGame.ID) WHERE ID = ".$TokenData['gameId']."");
		$UpdateUserGame->execute();
	}
	
	if ($UpdateUser->rowCount() > 0) {
		$cache->delete($TokenData['username']);
		$cache->delete($TokenData['username'].'_Profile');
		echo json_encode(array('status' => 'ok'));
	} else {
		echo json_encode(array('status' => 'error'));
	}