<?php
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
//$session = true;
require("shop.php");
header("Content-type: application/json");
if (!$shop->logged_in()) { die(json_encode(["status" => "error", "error" => "Not logged in"])); }
if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if (!$shop->tooFast()) {

			$fields = ["category", "title", "description", "saleType", "price"];

			foreach ($fields as $field) {
				if (!isset($_POST[$field])) {
					echo json_encode(["status" => "error", "error" => "Missing parameter."]);
					die();
				}
			}

			$price = (is_numeric($_POST["price"])) ? $_POST["price"] : 0;

			$modelCategories = [1,2];
			$adminCategories = [1,2,3,7];

			$model = false;
			if ($shop->isAdmin()) {
			$model = (isset($_FILES["model"])) ? $_FILES["model"] : false;
			}
			if (in_array($_POST["category"], $modelCategories) && !isset($_FILES["model"])) {
				echo json_encode(["status" => "error", "error" => "Missing model."]);
				die;
			} else if (!isset($_FILES["texture"]) && $_POST['category'] != "7") {
				echo json_encode(["status" => "error", "error" => "Missing texture."]);
				die;
			}

			if (in_array($_POST["category"], $adminCategories) && !$shop->isAdmin()) {
				die(json_encode(["status"=> "error", "error" => "d"]));
			}

			$texture = ($_POST["category"] != "7") ? $_FILES["texture"] : false;
			$userid = $shop->local_info(["id"])->id;
			if($bop->isBanned($userid))
			{
				die();
			}
			$create = $shop->createItem($_POST["title"], $_POST["description"], $price, $userid, $_POST["category"], $_POST["saleType"], $texture, $model);
			
			if ($_POST["category"] == "7") {
				if ($create) {
					echo json_encode(["status" => "ok", "id" => $create]);
				}
				die();
			}
			
			//var_dump($create);
			if ($create) {

				exec("php thumbnail.php " . $create . " " . $_POST["category"]);
				$shop->addItem($create, $userid, "0", $userid);
				echo json_encode(["status" => "ok", "id" => $create, "debug" => $price, "debug2" => $_POST["price"]]);

			} else {
				echo json_encode(["status" => "error", "error" => $create]);
			}
		} else {
			echo json_encode(["status" => "error", "error" => "You are creating items too fast"]);
		}
	} else {
		echo json_encode(["status" => "error", "error" => "Invalid or missing CSRF token"]);
	}
} else {
	echo json_encode(["status" => "error", "error" => "Invalid or missing CSRF token"]);
}

?>
