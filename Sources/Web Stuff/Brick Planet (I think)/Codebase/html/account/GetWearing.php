<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	requireLogin();
	
	$getWearing = $db->prepare("SELECT UserEquipped.InventoryID, Item.ID, Item.Name, Item.ItemType, Item.PreviewImage, Item.IsCollectible FROM UserEquipped JOIN UserInventory ON UserEquipped.InventoryID = UserInventory.ID JOIN Item ON UserInventory.ItemID = Item.ID WHERE UserEquipped.UserID = ".$myU->ID."");
	$getWearing->execute();
	
	echo '<div class="grid-x grid-margin-x clearfix">';
	
	while ($gW = $getWearing->fetch(PDO::FETCH_OBJ)) {
		
		echo '
		<div class="large-3 cell">
			<div class="edit-character-card text-center">
				<img src="'.$cdnName.''.$gW->PreviewImage.'" class="card-image">
				<a href="'.$serverName.'/store/view/'.$gW->ID.'/'.str_replace(' ', '-', $gW->Name).'/" target="_blank">'.$gW->Name.'</a>
				<a class="remove" onclick="removeItem(\''.$gW->InventoryID.'\')">Remove</a>
			</div>
		</div>
		';
		
	}
	
	echo '</div>';