<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");

	header('Content-Type: application/json');
	
	$GetGameRelease = $db->prepare("SELECT Type, Version, File FROM game.GameRelease WHERE Type IN(0,1,2,3) AND CurrentVersion = 1 ORDER BY Type ASC LIMIT 4");
	$GetGameRelease->execute();
	$ClientArray = array();
	$WorkshopArray = array();
	$LauncherArray = array();
	$UpdaterArray = array();
	
	while ($gR = $GetGameRelease->fetch(PDO::FETCH_OBJ)) {
		
		if ($gR->Type == 0) {
			$ClientArray = array('file' => 'https://cdn.brickcreate.com/game-releases/client/'.$gR->Version.'/'.$gR->File, 'version' => $gR->Version);
		} else if ($gR->Type == 1) {
			$WorkshopArray = array('file' => 'https://cdn.brickcreate.com/game-releases/workshop/'.$gR->Version.'/'.$gR->File, 'version' => $gR->Version);
		} else if ($gR->Type == 2) {
			$LauncherArray = array('file' => 'https://cdn.brickcreate.com/game-releases/launcher/'.$gR->Version.'/'.$gR->File, 'version' => $gR->Version);
		} else if ($gR->Type == 3) {
			$UpdaterArray = array('file' => 'https://cdn.brickcreate.com/game-releases/updater/'.$gR->Version.'/'.$gR->File, 'version' => $gR->Version);
		}
		
	}
	
	echo json_encode(array('client' => $ClientArray, 'workshop' => $WorkshopArray, 'launcher' => $LauncherArray, 'updater' => $UpdaterArray));