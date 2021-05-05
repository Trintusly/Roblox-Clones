<?php 
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);

require("../rest.php");
require("shop.php");

if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		
		if (!$shop->logged_in()) { die(json_encode(["status" => "error", "error" => "Not logged in"])); }
		$fields = ["title", "description", "saleType", "price", "itemId"];

		foreach ($fields as $field) {
			if (!isset($_POST[$field])) {
				echo json_encode(["status" => "error", "error" => "Missing parameter."]);
				die();
			}
		}
		if($shop->isCreator($_POST["itemId"], $_SESSION["id"])) {
			try {
				$stock = 0;
				$tradeable = 0;
				if ($_POST["saleType"] == "tradeable") {
					$_POST["saleType"] = 0;
					$tradeable = 1;
					$stock = $_POST["stock"];
				}
				$update = $shop->updateItem($_POST["itemId"], [ 
					"name" => $_POST["title"], 
					"description" => $_POST["description"],
					"sale_type" => $_POST["saleType"],
					"price" => $_POST["price"],
					"tradeable" => $tradeable,
					"stock" => $stock,
					"updated" => date("Y-m-d H:i:s")
				]);
				$rest->success();
				
			} catch (Exception $e) {
				$rest->error($e->getMessage());
			}
			
		} else {
			$rest->error("Invalid Permissions");
		}
		
	} else {
		echo json_encode(["status" => "error", "error" => "Invalid or missing CSRF token"]);
	}
} else {
	echo json_encode(["status" => "error", "error" => "Invalid or missing CSRF token"]);
}