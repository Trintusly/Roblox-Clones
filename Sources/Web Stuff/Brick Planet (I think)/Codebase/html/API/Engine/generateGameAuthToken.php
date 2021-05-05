<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-Type: application/json');
	const SECURE_TOKEN = '9876961efd21288e8eda0a4d9939de0f83j1';
	$secureToken = (!empty($_SERVER['HTTP_AUTHORIZATION'])) ? trim($_SERVER['HTTP_AUTHORIZATION']) : null;

	if (!$AUTH && !$secureToken) {
		
		echo json_encode(array('status' => 'error', 'msg' => 'You must login before accessing this content.'));
		
	} else {
		
		$GameId = (!empty($_GET['gameId']) && is_numeric($_GET['gameId']) && floor($_GET['gameId']) == $_GET['gameId']) ? (int)$_GET['gameId'] : NULL;
		$RoomId = (!empty($_GET['roomId']) && is_numeric($_GET['roomId']) && floor($_GET['roomId']) == $_GET['roomId']) ? (int)$_GET['roomId'] : NULL;
		if (!$GameId) {
			echo json_encode(array('status' => 'error', 'msg' => 'Invalid argument(s).'));
			die;
		} else if ($secureToken && $secureToken != SECURE_TOKEN) {
			echo json_encode(array('status' => 'error', 'msg' => 'Invalid credentials.'));
			die;
		} else if ($myU->InGame == 2) {
			echo json_encode(array('status' => 'error', 'msg' => 'You are already in game.'));
			die;
		}
	
		if (!$secureToken) {
			$GetGame = $db->prepare("SELECT EXISTS(SELECT 1 FROM game.UserGame WHERE ID = ?)");
		} else {
			$GetGame = $db->prepare("SELECT User.ID, User.Username, User.Admin, UserGame.Name, UserGame.PlayerLimit FROM game.UserGame JOIN new.User ON User.ID = UserGame.UserID WHERE UserGame.ID = ? AND User.AccountRestricted = 0");
		}
		$GetGame->bindValue(1, $GameId, PDO::PARAM_INT);
		$GetGame->execute();
		$GameExists = (!$secureToken) ? $GetGame->fetchColumn() : $GetGame->rowCount();
		
		if ($GameExists == 0) {
			echo json_encode(array('status' => 'error', 'msg' => 'Invalid game Id.'));
			die;
		}
		
		if (!$secureToken) {
			$UserId = (int)$myU->ID;
			$Username = $myU->Username;
			$Admin = (int)$myU->Admin;
		} else if ($secureToken) {
			$gG = $GetGame->fetch(PDO::FETCH_OBJ);
			$UserId = (int)$gG->ID;
			$Username = $gG->Username;
			$Admin = (int)$gG->Admin;
		}
		
		$Token = bin2hex(random_bytes(18));
		if ($RoomId > 0) {
			$DataArray = array('token' => $Token, 'userId' => $UserId, 'username' => $Username, 'adminLevel' => $Admin, 'gameId' => (int)$GameId, 'roomId' => (int)$RoomId);
		} else {
			$DataArray = array('token' => $Token, 'userId' => $UserId, 'username' => $Username, 'adminLevel' => $Admin, 'gameId' => (int)$GameId);
		}
		
		$cache->set('GameAuthToken_' . $Token, $DataArray, 86400);
		
		if (!$secureToken) {
			echo json_encode(array('status' => 'ok', 'token' => $Token));
		} else {
			echo json_encode(array('status' => 'ok', 'token' => $Token, 'name' => $gG->Name, 'playerLimit' => (int)$gG->PlayerLimit));
		}
		
	}