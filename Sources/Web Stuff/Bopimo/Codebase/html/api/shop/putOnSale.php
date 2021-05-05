<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require ("shop.php");
require ("../rest.php");

header("Content-type: application/json");

if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if (isset($_POST["id"]) && isset($_POST['price']) && isset($_POST['serial'])) {
			$localUser = $shop->local_info(["id"]);
			if($bop->isBanned($localUser->id)) { die(); };
			if ($localUser) {
				try {
					
					$buy = $shop->addOtherSeller($_POST['id'], $_POST['serial'], $localUser->id, $_POST['price']);
					$rest->success();
				} catch (Exception $e) {
					$rest->error($e->getMessage());
				}
				die();
			}
		} else {
			die('anus');
		}
	}
}
echo json_encode(["status" => "error", "error" => "Invalid or missing CSRF token"]);
