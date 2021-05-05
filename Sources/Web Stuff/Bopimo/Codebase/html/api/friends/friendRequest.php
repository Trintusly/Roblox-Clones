<?php
require("friends.php");
if ($friends->loggedIn()) {
	$localUser = $bop->local_info(["id"]);
	if($bop->isBanned($localUser->id))
	{
		die();
	}
	if (isset($_POST["userId"]) && isset($_POST["action"]) && isset($_POST["token"])) {
		if ($friends->checkToken($_POST["token"])) {
			switch ($_POST["action"]) {
				case "remove":
				case "cancel":
					$status = ($_POST["action"] == "cancel") ? "0" : 1;
					if ($friends->friendRequestExists( $_SESSION["id"], $_POST["userId"], $status )) {
						$decline = $friends->friendRequest( $_SESSION["id"], $_POST["userId"], '-1' );
						if ($decline) {
							$rest->success();
						}
					} else {
						$rest->error("No request found ");
					}
					break;
				case "accept":
					if ($friends->friendRequestRow( $_SESSION["id"], $_POST["userId"], 0 )) {
						$accept = $friends->friendRequest( $_SESSION["id"], $_POST["userId"], '1' );
						if ($accept) {
							$rest->success();
						}
					} else {
						$rest->error("No friend request found");
					}
					break;
				case "add":
					if (!$friends->friendRequestRow( $_SESSION["id"], $_POST["userId"], 1) && $_POST["userId"] !== $_SESSION["id"]) {
						$add = $friends->friendRequest($_POST["userId"],  $_SESSION["id"], '0' );
						if ($add) {
							$rest->success();
						}
					} else {
						$rest->error("already friends");
					}
					break;
				default:
					$rest->error("Invalid action");
					break;
			}
		} else {
			$rest->error("Invalid CSRF token");
		}
	} else {
		$rest->error("Missing Parameters");
	}
} else {
	$rest->error("You must be logged in to use this");
}
