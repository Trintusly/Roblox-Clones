<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require ("shop.php");
require ("../rest.php");

header("Content-type: application/json");

if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if (isset($_POST["id"])) {
			$localUser = $shop->local_info(["id"]);
			if($bop->isBanned($localUser->id)) { die(); };
			if ($localUser) {
				try {
					$item = $shop->getItem($_POST['id']);
					if ($item['category'] == 7) {
						$buy = $shop->buyBundle($_POST['id'],$localUser->id);
					} else {
						$buy = $shop->buy($_POST['id'],$localUser->id);
					}
					$rest->success();
				} catch (Exception $e) {
					$rest->error($e->getMessage());
				}
				die();
			}
		}
	}
}
echo json_encode(["status" => "error", "error" => "Invalid or missing CSRF token"]);
