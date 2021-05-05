<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");

	header('Content-Type: application/json');
	const SECURE_TOKEN = '9876961efd21288e8eda0a4d9939de0f83j1';
	$secureToken = (!empty($_SERVER['HTTP_AUTHORIZATION'])) ? trim($_SERVER['HTTP_AUTHORIZATION']) : null;
	if (!$secureToken || $secureToken && $secureToken != SECURE_TOKEN) die;
	$GameId = (!empty($_GET['GameId'])) ? $_GET['GameId'] : null;
	if (!$GameId) die;
	if ($_SERVER['REQUEST_METHOD'] != 'POST') die;
	$PostData = file_get_contents('php://input');
	$JSON = json_decode($PostData);
	if (!$JSON) die();
	$UserIdList = implode(',', $JSON);
	
	// Update in-game
	$UpdateUser = $db->prepare("UPDATE User SET TimeLastSeen = UNIX_TIMESTAMP(), InGameTime = UNIX_TIMESTAMP() WHERE User.ID IN(".$UserIdList.") AND User.InGame = 1 AND User.InGameId = ?");
	$UpdateUser->bindValue(1, $GameId, PDO::PARAM_INT);
	$UpdateUser->execute();
	
	// Update in game counter
	$UpdateUserGame = $db->prepare("UPDATE game.UserGame SET NumInGame = (SELECT COUNT(*) FROM User WHERE User.InGameId = UserGame.ID) WHERE UserGame.ID = ?");
	$UpdateUserGame->bindValue(1, $GameId, PDO::PARAM_INT);
	$UpdateUserGame->execute();
	
	echo json_encode(array('status' => 'ok'));