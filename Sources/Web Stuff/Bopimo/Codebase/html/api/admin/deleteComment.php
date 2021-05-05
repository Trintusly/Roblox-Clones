<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
// admin power 2 (not sure what simples wants)
require("/var/www/html/site/bopimo.php");
require("admin.php");

if ($admin->isAllowed($_SESSION["id"])) {
	if (isset($_POST["commentId"]) && isset($_POST["token"])) {
		if ($admin->checkToken($_POST["token"])) {
			try {
				$delete = $admin->deleteComment($_POST["commentId"], $_SESSION["id"]);
				$bop->updateAdminPoints(2);
				$rest->success();
			} catch (Exception $e) {
				$rest->error($e->getMessage());
			}
		} else {
			$rest->error("Invalid CSRF Token");
		}
	} else {
		$rest->error("Missing Parameters");
	}
} else {
	$rest->error("Not Allowed");
}
