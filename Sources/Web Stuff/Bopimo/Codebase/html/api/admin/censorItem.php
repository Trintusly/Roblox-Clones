<?php
require("/var/www/html/site/bopimo.php");
require("admin.php");
if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if ($admin->isAllowed($_SESSION['id'])) {
			if (isset($_POST["itemId"])) {
				try {
					$update = $shop->updateItem($_POST["itemId"], [
						"name" => "Censored",
						"description" => "Censored"
					]);
					$bop->updateAdminPoints(3);
					$rest->success();

				} catch (Exception $e) {
					$rest->error($e->getMessage());
				}
			} else {
				$rest->error("Missing parameters");
			}
		} else {
			$rest->error("Not allowed");
		}
	} else {
		$rest->error("Missing or invalid CSRF token");
	}
} else {
	$rest->error("Missing or invalid CSRF token");
}
?>
