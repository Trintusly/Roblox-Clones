<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/rest.php");
if($bop->logged_in())
{
  session_destroy();
}
if(!isset($_POST['id']) || !isset($_POST['pw1']) || !isset($_POST['pw2']))
{
  $rest->error("Invalid arguments.");
  die();
}
if(!is_string($_POST['id']) || !is_string($_POST['pw1']) || !is_string($_POST['pw2']))
{
  $rest->error("Invalid arguments.");
  die();
}
$pw1 = (string) $_POST['pw1'];
$pw2 = (string) $_POST['pw2'];
$id = (string) $_POST['id'];
if($pw1 != $pw2)
{
  $rest->error("Passwords do not match.");
  die();
}
$verify = $bop->look_for("password_requests", ["uniq" => $id]);
if(!$verify)
{
  $rest->error("Request not found.");
  die();
}
if(empty($pw1))
{
  $rest->error("Password cannot be empty.");
  die();
}
if(strlen($pw1) < 3 || strlen($pw1) > 200)
{
  $rest->error("Password must be 3 - 200 characters long.");
  die();
}
$hashed = password_hash($pw1, PASSWORD_DEFAULT);
$bop->update_("users", ["password" => $hashed], ["id" => $verify->user]);
$bop->delete("password_requests", ["id" => $verify->id]);
/*$return = array(
  "pw" => $hashed,
  "id" => $verify->id
);*/
$rest->success();
?>
