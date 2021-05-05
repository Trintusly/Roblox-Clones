<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/shop/shop.php");
$orig = 2581;
$to = 2643;
$epic = $bop->query("SELECT * FROM inventory WHERE item_id = ? AND own = 1", [$orig], true);
foreach ($epic as $e) {
	var_dump($e);
	$shop->addItem($to, $e['user_id'], "0", 3);
}*/
?>
