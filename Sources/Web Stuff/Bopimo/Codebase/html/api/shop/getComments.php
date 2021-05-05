<?php 

header("Content-type: application/json");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require("/var/www/html/api/rest.php");
require("/var/www/html/api/shop/shop.php");

if (isset($_GET["itemId"])) {
	if (is_numeric($_GET["itemId"])) {
		try {
			$comments = $shop->getComments($_GET["itemId"]);
			foreach ($comments as $id => &$comment) {
				$poster = (array) $shop->get_user($comment["user_id"]);
				$poster["avatar"] = $shop->avatar($comment["user_id"])->cache;
				$comment["postedAgo"] = $shop->timeAgo(strtotime($comment["posted"]));
				$comment["body"] = htmlentities($comment["body"]);
				$comment["username"] = htmlentities($shop->trueUsername($poster['id']));
				$comment["avatar"] = htmlentities($poster['avatar']);
			}
			$rest->success(["admin"=> $shop->isAdmin($_SESSION["id"]), "data" => $comments]);
		} catch (Exception $e) {
			$rest->error($e->getMessage());
		}
	} else {
		$rest->error("Invalid parameter values");
	}
} else {
	$rest->error("Missing parameters");
}