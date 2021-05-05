<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/api/community/class.php");
require ("../rest.php");

header("Content-type: application/json");

if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if (isset($_POST["name"]) && isset($_POST["tag"]) && isset($_POST["description"]) && isset($_POST["postable"]) && isset($_POST["type"]) && isset($_FILES["logo"])) {
			$localUser = $com->local_info(["id"]);
			if($bop->isBanned($localUser->id)) { die(); };
			if ($localUser) {
				try {
					$com->createCommunity($_POST["name"],$_POST["description"], $_POST["tag"], $_POST["postable"], $_POST['type'], $localUser->id, $_FILES["logo"]);
					$rest->success();
					die();
				} catch(Exception $e) {
					$rest->error($e->getMessage());
					die();
				}
			}
		} else {
			echo "Not enough psramx";
		}
	} else {
		echo "nog odo asd";
	}
}