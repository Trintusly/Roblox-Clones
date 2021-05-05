<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("../rest.php");
require("avatar.php");

if ($avatar->loggedIn()) {
	if(isset($_POST["limb"]) && isset($_POST["hex"])) {
		try {
			$avatar->changeColor($_SESSION["id"], $_POST["limb"], $_POST["hex"]);
			$render = new blender;
			$restult = $render->renderAvatar($_SESSION['id']);
			$rest->success();
		} catch (Exception $e) {
			$rest->error($e->getMessage());
		}
	} else {
		$rest->error("Missing parameters");
	}
} else {
	$rest->error("You must be logged in to use this");
}