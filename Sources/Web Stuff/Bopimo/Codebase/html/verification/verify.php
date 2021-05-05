<?php
if(!isset($_GET['id']))
{
  require("/var/www/html/error/404.php");
  die();
}
if(!is_string($_GET['id']))
{
  require("/var/www/html/error/404.php");
  die();
}
$id = (string) $_GET['id'];
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localUser = $bop->local_info();
$verify = $bop->look_for("verification", ["user" => $localUser->id, "uniq" => $id]);
if(!$verify)
{
  require("/var/www/html/error/404.php");
  die();
}
$bop->delete("verification", ["id" => $verify->id]);
$bop->update_("users", ["verified" => "1"], ["id" => $localUser->id]);
header("location: /home")
?>
