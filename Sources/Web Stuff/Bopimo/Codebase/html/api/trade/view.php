<?php 

error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
require("../rest.php");
require("../shop/shop.php");



if (!$shop->logged_in()) { die(json_encode(["status" => "error", "error" => "Not logged in"])); }

if (isset($_GET['id'])) {
	if (is_numeric ($_GET['id'])) {
		try {
			$trade = (array) $shop->getTradeProtected($_GET['id'], $_SESSION["id"]);
			$rest->success($trade);
		} catch (Exception $e) {
			$rest->error($e->getMessage());
		}
		die();
	}
}
$rest->error("Invalid id");

