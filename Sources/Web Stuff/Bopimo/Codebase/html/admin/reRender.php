<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localUser = $bop->local_info(["id"]);
if(!$bop->isAllowed($localUser->id) || !isset($_GET['id']))
{
  die("bad request");
}
if(!is_numeric($_GET['id']))
{
  die("bad request");
}
$uid = (int) $_GET['id'];
if(!$bop->user_exists($uid))
{
  die("user does not exist");
}
$bop->update_("avatar", [
  "hat1" => "0",
  "hat2" => "0",
  "hat3" => "0",
  "tool" => "0",
  "shirt" => "0",
  "pants" => "0",
  "face" => "0",
  "tshirt" => "0"
], ["id" => $uid]);
$blend = new blender;
$blend->renderAvatar($uid);
die(header("location: /profile/{$uid}"));
?>
