<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");

	$Username = $_GET['Username'];
	
	header('Content-Type: application/json');
	
	$getUser = $db->prepare("SELECT Username, CONCAT(ROUND(UC1.R*255), ' ', ROUND(UC1.G*255), ' ', ROUND(UC1.B*255)) AS Head, CONCAT(ROUND(UC2.R*255), ' ', ROUND(UC2.G*255), ' ', ROUND(UC2.B*255)) AS LeftArm, CONCAT(ROUND(UC3.R*255), ' ', ROUND(UC3.G*255), ' ', ROUND(UC3.B*255)) AS Torso, CONCAT(ROUND(UC4.R*255), ' ', ROUND(UC4.G*255), ' ', ROUND(UC4.B*255)) AS RightArm, CONCAT(ROUND(UC5.R*255), ' ', ROUND(UC5.G*255), ' ', ROUND(UC5.B*255)) AS LeftLeg, CONCAT(ROUND(UC6.R*255), ' ', ROUND(UC6.G*255), ' ', ROUND(UC6.B*255)) AS RightLeg, I1.BackendFile AS Shirt, I2.BackendFile AS Pants, GROUP_CONCAT(I3.ID SEPARATOR ',') AS Hats, I4.BackendFile AS Face, I4.BackendFileBlink AS FaceBlink, I5.ID AS Accessory, (SELECT Name FROM UserGroup WHERE UserGroup.ID = User.FavoriteGroup) AS FavoriteGroup FROM User LEFT JOIN UserColor UC1 ON User.HexHead = UC1.ID LEFT JOIN UserColor UC2 ON User.HexLeftArm = UC2.ID LEFT JOIN UserColor UC3 ON User.HexTorso = UC3.ID LEFT JOIN UserColor UC4 ON User.HexRightArm = UC4.ID LEFT JOIN UserColor UC5 ON User.HexLeftLeg = UC5.ID LEFT JOIN UserColor UC6 ON User.HexRightLeg = UC6.ID LEFT JOIN UserEquipped UE1 ON User.ID = UE1.UserID AND UE1.ItemType = 5 LEFT JOIN UserInventory UI1 ON UE1.InventoryID = UI1.ID LEFT JOIN Item I1 ON UI1.ItemID = I1.ID LEFT JOIN UserEquipped UE2 ON User.ID = UE2.UserID AND UE2.ItemType = 6 LEFT JOIN UserInventory UI2 ON UE2.InventoryID = UI2.ID LEFT JOIN Item I2 ON UI2.ItemID = I2.ID LEFT JOIN UserEquipped UE3 ON User.ID = UE3.UserID AND UE3.ItemType = 1 LEFT JOIN UserInventory UI3 ON UE3.InventoryID = UI3.ID LEFT JOIN Item I3 ON UI3.ItemID = I3.ID LEFT JOIN UserEquipped UE4 ON User.ID = UE4.UserID AND UE4.ItemType = 2 LEFT JOIN UserInventory UI4 ON UE4.InventoryID = UI4.ID LEFT JOIN Item I4 ON UI4.ItemID = I4.ID LEFT JOIN UserEquipped UE5 ON User.ID = UE5.UserID AND UE5.ItemType = 3 LEFT JOIN UserInventory UI5 ON UE5.InventoryID = UI5.ID LEFT JOIN Item I5 ON UI5.ItemID = I5.ID WHERE User.Username = ? GROUP BY User.Username");
	$getUser->bindValue(1, $Username, PDO::PARAM_STR);
	$getUser->execute();
	
	if ($getUser->rowCount() == 0) {
		
		echo json_encode(array('error' => 'Invalid Username'));
		
	} else {
		
		$gU = $getUser->fetch(PDO::FETCH_OBJ);
		
		$gU->Face = (!empty($gU->Face)) ? $gU->Face : 'htemplates/Face.png';
		$Shirt = (empty($gU->Shirt)) ? NULL : 'https://cdn.brickcreate.com/' . $gU->Shirt;
		$Pants = (empty($gU->Pants)) ? NULL : 'https://cdn.brickcreate.com/' . $gU->Pants;
		$FaceBlink = (!empty($gU->FaceBlink)) ? 'https://cdn.brickcreate.com/' . $gU->FaceBlink : null;
		$FaceBlink = ($gU->Face == 'htemplates/Face.png') ? 'https://cdn.brickcreate.com/htemplates/FaceBlink.png' : $FaceBlink;
		
		$Contents = array(
		'Username' => $gU->Username,
		'BodyColors' => array('Head' => $gU->Head, 'LeftArm' => $gU->LeftArm, 'Torso' => $gU->Torso, 'RightArm' => $gU->RightArm, 'LeftLeg' => $gU->LeftLeg, 'RightLeg' => $gU->RightLeg),
		'Face' => array('https://cdn.brickcreate.com/' . $gU->Face, $FaceBlink),
		'Shirt' => $Shirt,
		'Pants' => $Pants,
		'Hats' => explode(',', $gU->Hats),
		'Accessory' => $gI->Accessory,
		'FavoriteGroup' => $gU->FavoriteGroup
		);
		
		echo json_encode($Contents);
		
	}