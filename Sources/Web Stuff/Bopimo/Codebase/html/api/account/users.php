<?php

require "../rest.php";
require "account.php";

if (isset($_GET["query"])) {

	if (is_string($_GET["query"])) {

		$page = 1;
		if (isset($_GET["page"])) {
			if (is_numeric($_GET["page"])) {
				$page = $_GET["page"];
			}
		}
		try {
			$data = $account->searchUsers($_GET["query"], $page, 24, false);
			foreach ($data as &$user) {
				$user["bio"] = htmlentities($user["bio"]);
				$user['currentTime'] = time();
				$user['username'] = $shop->trueUsername($user["id"]);
			}
			$total = $account->searchUsers($_GET["query"], $page, 24, true);
			$rest->success(["data" => $data, "total" => $total]);
		} catch (Exception $e) {
			$rest->error($e->getMessage());
		}
	}



}
