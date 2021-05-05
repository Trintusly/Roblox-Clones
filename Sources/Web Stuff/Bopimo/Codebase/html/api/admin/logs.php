<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
// admin power 2 (not sure what simples wants)
require("admin.php");

if ($admin->isAllowed($_SESSION["id"])) {
	
	$where = [];
	
	if (isset($_GET["username"])) {
		if (is_string($_GET["username"]) && !empty($_GET["username"])) {
			if ($admin->user_exists($_GET["username"])) {
				$userId = $shop->usernameToId($_GET["username"]);
				if ($userId) {
					$where["user"] = $userId;
				}
			}
		}
	}
	
	$page = 1;
	if (isset($_GET["page"])) {
		if(is_numeric($_GET["page"])) {
			$page = $_GET["page"];
		}
	}
	
	if (isset($_GET["affectedId"])) {
		if (is_numeric($_GET["affectedId"]) && !empty($_GET["affectedId"])) {
				$where["affected"] = $_GET["affectedId"];
		}
	}
	
	if (isset($_GET["type"])) {
		if (is_string($_GET["type"]) && !empty($_GET["type"])) {
				$where["type"] = $_GET["type"];
		}
	}
	
	if (isset($_GET["action"])) {
		if (is_string($_GET["action"]) && !empty($_GET["action"])) {
				$where["msg"] = $_GET["action"];
		}
	}
	
	$logs = $admin->getLogs($where, $page);
	$total = $admin->getLogs($where, $page, 10,true);
	//var_dump($logs);
	if ($logs) {
		
		foreach ($logs as $index => $log) {
			$logs[$index]['username'] = $admin->get_user($log["user"], ["username"])->username;
		}
		
		$rest->success([ "result" => $logs, "total" => $total[0]['total']]);
	} else {
		$rest->error("No results");
	}
} else {
	$rest->error("Not allowed");
}