<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("../rest.php");

require("shop.php");
if ($shop->isAllowed($_SESSION["id"])) {
	if (isset($_GET["id"])) {
		try {
		if (isset($_POST['add'])) {
			$shop->addToBundle($_GET["id"], $_POST['add']);
			$rest->success();
			die();
		}
		if (isset($_POST['remove'])) {
			var_dump($shop->removeFromBundle($_GET["id"], $_POST['remove']));
			$rest->success();
			die();
		}
		} catch (Exception $e) {
			$rest->error($e->getMessage());
		}
		$epic = $shop->getBundleItems($_GET["id"]);
		foreach ($epic as $i => &$item) {
			$item['name'] = htmlentities($shop->itemName($item['item_id']));
		}
		$rest->success(["data" => $epic]);
	} else {
		$rest->error("Missing Parameter 'id'");
	}
}