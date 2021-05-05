<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("admin.php");

if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if ($admin->isAllowed($_SESSION['id'])) {
			
			$actions = [ "approve", "decline"];
			
			if (isset($_POST["item_id"]) && isset($_POST["action"])) {
				if (is_numeric($_POST["item_id"]) && in_array($_POST["action"], $actions)) {
					try {
						$action = $_POST["action"];
						$item = $_POST["item_id"];
						if ($action == "approve") {
							$admin->approve($item, $bop->local_info("id")->id);
							$rest->success();
						} else {
							$admin->decline($item, $bop->local_info("id")->id);
							$rest->success();
						}
					} catch (Exception $e) {
						$rest->error($e);
					}
				} else {
					$rest->error("Invalid data");
				}
			} else {
				$rest->error("Missing parameter(s)");
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