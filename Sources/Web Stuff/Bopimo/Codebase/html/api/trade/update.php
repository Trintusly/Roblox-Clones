<?php 

error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
require("../rest.php");
require("../shop/shop.php");



if (!$shop->logged_in()) { die(json_encode(["status" => "error", "error" => "Not logged in"])); }
if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if (isset($_POST['action']) && isset($_GET['id'])) {
			try {
				$curId = $_SESSION['id'];
				$trade = $shop->getTradeProtected($_GET['id'], $_SESSION['id']);
				if ($trade->status != "0") {
					$rest->error("You cannot update this trade any further");
					die();
				}
				switch ($_POST['action']) {
					case "cancel":
						if ($trade->from_user == $curId) {
							$shop->update_("trades", ['status' => '-2'], ['id' => $_GET['id']]);
							$rest->success();
							die();
						}
						break;
					case "accept":
						if($trade->to_user == $curId) {
							$shop->acceptTrade($_GET['id']);
							$rest->success();
							die();
						}
						break;
					case "decline":
						$shop->update_("trades", ['status' => '-1'], ['id' => $_GET['id']]);
						$rest->success();
						die();
						break;
					default:
						$rest->error("Invalid action");
						die();
				}
			} catch (Exception $e) {
				$rest->error($e->getMessage());
			}
			
		} else {
			$rest->error("Missing params");
			die();
		}
	}
}
echo json_encode(["status" => "error", "error" => "Invalid or missing CSRF token"]);
