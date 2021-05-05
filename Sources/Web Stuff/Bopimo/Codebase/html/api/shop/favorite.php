<?php
require("shop.php");
header("Content-type: application/json");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST["item_id"]) && isset($_POST["action"]) && isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if (is_numeric($_POST["item_id"]) && is_string($_POST["action"])) {
			
			try {
				$id = $shop->local_info(["id"])->id;
				switch ($_POST["action"]) {
					case "remove":
							$shop->removeFavorite($_POST["item_id"], $id);
							echo json_encode(["status" => "ok", "dd"=>""]);
						break;
					default:
							$shop->addFavorite($_POST["item_id"], $id);
							echo json_encode(["status" => "ok"]);
						break;
				}
			} catch (Exception $e) {
				echo json_encode(["status" => "error", "error" => $e]);
				die();
			}
		} else {
			echo json_encode(["status" => "error", "error" => "Invalid value(s)"]);
			die();
		}
	} else {
		echo json_encode(["status" => "error", "error" => "Invalid or missing CSRF token"]);
		die();
	}
} else {
	echo json_encode(["status" => "error", "error" => "Missing parameter(s)"]);
}