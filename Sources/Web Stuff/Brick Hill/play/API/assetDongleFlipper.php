<?php 

include("../../SiT_3/config.php");
include("../../SiT_3/PHP/helper.php");

if (isset($_GET['iloveluke']) && isset($_GET['id'])) {
	$key = 'lukeisreallycoolandIFlukeWasnotCoolthenThiswouldNOTWORKbecauselukeiscool';
	if ($_GET['iloveluke'] != $key) {
		die("Error");
	} else {
		$id = $conn->real_escape_string($_GET['id']);
		$findItemSQL = "SELECT * FROM `shop_items` WHERE `id` = '$id'";
		$findItemQuery = $conn->query($findItemSQL);
		if ($findItemQuery->num_rows == 0) {
			die("Invalid item!");
		}
		$itemRow = $findItemQuery->fetch_assoc();
		
		$itemType = strtolower($itemRow['type']);
		
		if ($itemType == "hat" || $itemType == "tool") {
			echo shopItemHash($id);
			die();
		}
		
		if ($itemType != "pants") {
			$itemType = $itemType."s";
		}
		
		$itemImageLocation = "http://www.brick-hill.com/shop_storage/assests/$itemType/" . shopItemHash($id) .'.png';
		header('Content-type: image/png');
		$im = imageCreateFromPng($itemImageLocation);
		imagealphablending( $im, false );
		imagesavealpha( $im, true );
		imageflip($im, IMG_FLIP_VERTICAL);
		//imageflip($im, IMG_FLIP_HORIZONTAL);
		imagepng($im);
		imagedestroy($im);
	}
} else {
	die("Error");
}

?>