<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("admin.php");

/*
if (isset($_POST["token"]) && isset($_POST["itemId"]) && isset($_POST["action"])) {
	if ($bop->checkToken($_POST["token"])) {
		if ($admin->isAllowed($_SESSION["id"])) {
			try {
				switch ($_POST["action"]) {
					case "decline":
					$admin->updateItem($_POST["itemId"], ["verified" => -1]);
					case "approve":
					$admin->updateItem($_POST["itemId"], ["verified" => -1]);
				}
				$rest->success();
			} catch (Exception $e) {
				$rest->error($e->getMessage());
			}
		}
	}
}