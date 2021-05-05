<?php 

header("Content-type: application/json");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require("/var/www/html/api/rest.php");
require("/var/www/html/api/shop/shop.php");

if (isset($_GET["commentId"])) {
	if (is_numeric($_GET["commentId"])) {
		try {
			$comment = $shop->getComment($_GET["commentId"]);
			$comment["body"] = htmlentities($comment["body"]);
			$rest->success(["data" => $comment]);
		} catch (Exception $e) {
			$rest->error($e->getMessage());
		}
	} else {
		$rest->error("Invalid parameter values");
	}
} else {
	$rest->error("Missing parameters");
}