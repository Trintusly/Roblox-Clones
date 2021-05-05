<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("../rest.php");
require("avatar.php");

$userId = $_SESSION["id"];

if (isset($_GET["userId"])) {
	if (is_string($_GET["userId"])) {
		$userId = $_GET["userId"];
	}
}

$wearing = $avatar->getWearing($userId);
if ($wearing) {
	foreach ($wearing as $column => $itemId) {
		switch ($column) {
			case "hat1":
			case "hat2":
			case "hat3":
			case "shirt":
			case "pants":
			case "tshirt":
			case "tool":
			case "face":
				if ($itemId > 0) {
					unset($wearing[$column]);
					$wearing[$column]["name"] = htmlentities($avatar->getItem($itemId)['name']);
					$wearing[$column]["elm"] = $column;
					$wearing[$column]["id"] = $itemId;
				}
				break;
		}
	}
	$rest->success(["data" => $wearing]);
} else {
	$rest->error();
}

?>