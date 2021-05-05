<?php
require("/var/www/html/site/bopimo.php");
header("Content-type: application/json");
if(!$bop->logged_in())
{
	die(json_encode(["status" => "error", "error" => "Not logged in"]));
}

$avatar = $bop->avatar($_SESSION['id']);
echo json_encode(["status" => "ok", "avatar" => $avatar->cache])
?>