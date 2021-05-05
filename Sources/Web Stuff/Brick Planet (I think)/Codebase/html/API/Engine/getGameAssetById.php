<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");

	$UserId = (int)$_GET['Id'];
	
	header('Content-Type: application/json');
	
	$getItem = $db->prepare("SELECT ItemType, Name, BackendFile, TextureOne, TextureTwo, TextureThree FROM Item WHERE ID = ? AND ItemType IN(1,2,3)");
	$getItem->bindValue(1, $UserId, PDO::PARAM_INT);
	$getItem->execute();
	
	if ($getItem->rowCount() == 0) {
		
		echo json_encode(array('error' => 'Invalid Item Id'));
		
	} else {
		
		$gI = $getItem->fetch(PDO::FETCH_OBJ);
		$Textures = array_filter(array($gI->TextureOne, $gI->TextureTwo, $gI->TextureThree));
		array_walk($Textures, function(&$Texture) { $Texture = 'https://cdn.brickcreate.com/sdfj90324j/' . $Texture; });
		
		switch ($gI->ItemType) {
			case 1:
				$Type = 'Hat';
				break;
			case 3:
				$Type = 'Accessory';
				break;
		}
		
		$Contents = array(
			'Type' => $Type,
			'Name' => $gI->Name,
			'Obj' => 'https://cdn.brickcreate.com/sdfj90324j/' . $gI->BackendFile.'.obj',
			'Mat' => 'https://cdn.brickcreate.com/sdfj90324j/' . $gI->BackendFile.'.mtl',
			'Textures' => $Textures
		);
		
		echo json_encode($Contents);
		
	}