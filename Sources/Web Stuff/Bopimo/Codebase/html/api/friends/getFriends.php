<?php 

require "friends.php";

$status = "accepted";
if (isset($_GET["pending"])) {
	$status = "pending";
}

if (isset($_GET["sent"])) {
	$status = "sent";
}

if (isset($_GET["userId"]) && !isset($_GET["pending"]) && !isset($_GET["sent"])) {
	if (is_numeric($_GET["userId"])) {
		$userId = $_GET["userId"];
	}
} else {
	if ($friends->loggedIn()) {
		$userId = $_SESSION["id"];
		//$userId = 3;
	}
}

if (isset($userId)) {
	try {
		$friendList = $friends->getFriends($userId, $status);
		foreach ($friendList as &$request) {
			$user = (array) $friends->get_user(($status == "sent" || $request["from"] == $_SESSION["id"]) ? $request["to"] : $request["from"]);
			$user["avatar"] = $friends->avatar($user["id"])->cache;
			$request["user"]["id"] = $user["id"];
			$request["user"]["username"] = $friends->trueUsername($user["id"]);
			$request["user"]["avatar"] = $user["avatar"];
		}
		$rest->success(["data" => $friendList]);
	} catch (Exception $e) {
		$rest->error($e->getMessage());
	}
} else {
	$rest->error("Missing Parameters");
}