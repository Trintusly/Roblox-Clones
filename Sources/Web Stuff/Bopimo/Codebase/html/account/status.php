<?php
require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/rest.php");

if(!$bop->logged_in()) //not logged in
{
  $rest->error("Error changing status: You are not logged in.");
  die();
}

if($bop->antiJake($_POST['status']))
{
  $rest->error("Error changing status: All fields are required.");
  die();
}

$status = $_POST['status'];

if(strlen($status) < 3 || strlen($status) > 65)
{
  $rest->error("Error changing status: Status must 3 - 65 characters long.");
  die();
}

if($bop->tooFast(20))
{
  $rest->error("You are performing actions too fast. Please try again later.");
  die();
}
$bop->updateFast();
$user = $bop->local_info();
$bop->update_("users", [
  "status" => $status
], [
  "id" => $user->id
]);
$text = $status;
$bop->insert("dashboard", [
  "text" => $text,
  "time" => time(),
  "user" => $user->id
]);
$rest->success();
?>
