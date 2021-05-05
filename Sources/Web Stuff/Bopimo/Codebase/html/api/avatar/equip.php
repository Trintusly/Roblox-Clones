<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("../rest.php");
require("avatar.php");
//var_dump($avatar->equip(3,12));


if ($avatar->loggedIn()) {
	if (isset($_POST["item"]) && isset($_POST["token"]) && isset($_POST["action"])) {
		if (is_string($_POST["item"]) && $avatar->checkToken($_POST["token"]) && is_string($_POST["action"])) {
			if ($avatar->itemExists($_POST["item"])) {
				$item = $avatar->getItem($_POST["item"]);
				if ($item['verified'] == 1) {
					try {
						switch ($_POST["action"]) {
							case "remove":
								$avatar->unequip($_SESSION["id"], $_POST["item"]);
								break;
							default:
								$avatar->equip($_SESSION["id"], $_POST["item"]);
								break;
						}
						$rest->success();
						$render = new blender;
						$restult = $render->renderAvatar($_SESSION['id']);
					} catch (Exception $e) {
						$rest->error($e->getMessage());
					}
				} else {
					$rest->error("Item is not approved");
				}
			} else {
				$rest->error("Item does not exist");
			}
		} else {
			$rest->error();
		}
	} else {
		$rest->error("Missing parameters");
	}
} else {
	$rest->error("You must be logged in to use this api");
}