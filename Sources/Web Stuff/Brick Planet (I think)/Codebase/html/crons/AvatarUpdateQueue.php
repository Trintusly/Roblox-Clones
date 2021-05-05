<?php
	require_once('/var/www/html/root/private/db.php');
	
	function updateAvatar($UserID) {
		
		global $db;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://66.70.181.68:3000/?seriousKey=dAktdYZ2SBABYCmK&userId=' . $UserID);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$callback = curl_exec($ch);
		curl_close($ch);
		
	}
	
	$Update = $db->prepare("UPDATE AvatarUpdateQueue SET Locked = 1 LIMIT 20");
	$Update->execute();
	
	$Query = $db->prepare("SELECT UserID FROM AvatarUpdateQueue LIMIT 20");
	$Query->execute();
	
	while ($Q = $Query->fetch(PDO::FETCH_OBJ)) {
		
		updateAvatar($Q->UserID);
		
		$Delete = $db->prepare("DELETE FROM AvatarUpdateQueue WHERE UserID = ".$Q->UserID."");
		$Delete->execute();
		
	}