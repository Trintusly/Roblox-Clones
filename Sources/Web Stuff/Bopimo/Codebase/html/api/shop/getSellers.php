<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require ("shop.php");
require ("../rest.php");

header("Content-type: application/json");


	if (isset($_GET["id"])) {
		$page = 1;
		$id = $_GET["id"];
		try {
			$localUser = $shop->local_info(["id"]);
			$sellers = $shop->getOtherSellers($id, $page);
			foreach ($sellers as $id=> &$row) {
				$seller = (array) $shop->get_user($row["seller_id"]);
				$row['avatar'] =  $shop->avatar($row["seller_id"])->cache;
				$row['username'] = $seller["username"];
				$row['current_user'] = $localUser->id;
			}
			die(json_encode(["status" => "ok", "result" => $sellers], JSON_PRETTY_PRINT));
		} catch (Exception $e) {
			die($rest->error($e->getMessage()));
		}
		
	}


echo json_encode(["status" => "error", "error" => "Invalid Params"]);
