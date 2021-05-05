<?php
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
require("../rest.php");
require("avatar.php");

if (isset($_GET["category"])) {
	$category = ($_GET["category"] == "all") ? false : $_GET["category"];
	$category = (is_string($category)) ? $category : 1;
	$query = (isset($_GET["query"])) ? $_GET["query"] : false;
	$query = (is_string($query)) ? $query : false;
	if ($avatar->loggedIn() && !isset($_GET["userId"])) {
		$userId = $_SESSION["id"];
	} else {
		$userId = 1;
	}
	$notWearing = false;
	if (isset($_GET["userId"])) {
		if (is_string($_GET["userId"])) {
			$userId = $_GET["userId"];
		}
	}
	if (isset($_GET["notWearing"])) {
		$notWearing = true;
	}

	$inventory = $avatar->getInventory($userId, $notWearing, $category, $query, false);
	if ($inventory) {
		//var_dump($inventory);
		foreach ($inventory as $index => &$item) {
			$item['name'] = htmlentities($item['name']);
			if ($notWearing) {
				if ($avatar->isWearing($avatar->itemType($item['item_id']),$item['item_id'], $userId)) {
					unset($inventory[$index]);
				}
			}
		}
		if (count($inventory) > 0) {
			$rest->success(["data" => $inventory]);
		} else {
			$rest->error("No results");
		}
	} else {
		$rest->error("No results");
	}

}
