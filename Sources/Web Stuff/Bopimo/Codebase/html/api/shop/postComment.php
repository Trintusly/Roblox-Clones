<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require("/var/www/html/api/rest.php");
require("/var/www/html/api/shop/shop.php");

if (isset($_POST["itemId"]) && isset($_POST["body"]) && isset($_POST["token"])) {
	if ($shop->loggedIn()) {
		if ($shop->checkToken($_POST["token"])) {
			if (is_numeric($_POST["itemId"]) && is_string($_POST["body"])) {
				if (!$shop->tooFast()) {
					try {
						$comment = $shop->postComment($_SESSION["id"], $_POST["itemId"], $_POST["body"]);
						$rest->success();
						$shop->updateFast();
					} catch (Exception $e) {
						$rest->error($e->getMessage());
					}
				} else {
					$rest->error("You are posting too fast (try waiting a few seconds)");
				}
			} else {
				$rest->error("Invalid parameter values");
			}
		} else {
			$rest->error("Invalid CSRF token");
		}
	} else {
		$rest->error("You must be logged in to use this");
	}
} else {
	$rest->error("Missing parameters");
}