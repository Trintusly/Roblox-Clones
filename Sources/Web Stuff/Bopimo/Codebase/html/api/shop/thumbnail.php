<?php 
require("shop.php");

if (isset($argv[2])) {
	
	$id = $argv[1];
	$category = $argv[2];
	
	$shopRender->renderItem($id, $category);
	$path = "/var/www/storage/thumbnails/" . $id ;
	if (file_exists($path . ".png")) {
		unlink($path . ".png");
	}
	if (file_exists($path . ".py")) {
		unlink($path . ".py");
	}
	var_dump($shopRender->export("/var/www/storage/thumbnails/" . $id, 512, "", ""));
}