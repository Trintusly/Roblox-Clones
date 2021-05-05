<?php 
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);

require("../rest.php");
require("../shop/shop.php");

if (!$shop->logged_in()) { die(json_encode(["status" => "error", "error" => "Not logged in"])); }
echo json_encode($shop->tradeInfo($_SESSION['id']));