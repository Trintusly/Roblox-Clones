<?php 
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);

require("../rest.php");
require("../shop/shop.php");

if (!$shop->logged_in()) { die(json_encode(["status" => "error", "error" => "Not logged in"])); }
if (isset($_GET['type'])) {
	$uid = $_SESSION['id'];
	try {
		switch($_GET['type']) {
			case "sent":
				$trades = (array)  $shop->getTrades("SELECT * FROM trades WHERE status = 0 AND from_user = ?", [$uid]);
				break;
			case "history":
				$trades = (array) $shop->getTrades("SELECT * FROM trades WHERE status != 0 AND (from_user = ? OR to_user = ?)", [$uid, $uid]);
				break;
			default:
				$trades = (array) $shop->getTrades("SELECT * FROM trades WHERE status = 0 AND to_user = ?", [$uid]);
		}
		
		foreach ($trades as &$trade) {
			if ($_GET['type'] == "sent") {
				$user = $shop->get_user($trade["to_user"]);
			} else {
				$user = $shop->get_user($trade["from_user"]);
			}
			$trade["oid"] = $user->id;
			$trade["avatar"] = $user->avatar;
			$trade["username"] = $user->username;
		}
		
		$rest->success(["data"=>$trades]);
	} catch (Exception $e) {
		$rest->error($e->getMessage());
	}
}
?>