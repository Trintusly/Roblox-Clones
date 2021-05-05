<?php 


error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
require("../rest.php");
require("../shop/shop.php");



if (!$shop->logged_in()) { die(json_encode(["status" => "error", "error" => "Not logged in"])); }
if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if (isset($_POST['giving']) && isset($_POST['wanting']) && isset($_POST["to"])) {
			if($shop->sendTrade($_SESSION['id'], $_POST['to'], $_POST['giving'], $_POST['wanting'])) {
				$rest->success();
			}
		}
	}
}

?>