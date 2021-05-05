<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/rest.php");

if(!$bop->logged_in())
{
  $rest->error("Error Friending User: Not logged in.");
  die();
}

if(!is_numeric($_POST['uid']))
{
  $rest->error("Invalid User ID.");
  die();
}

$user = $bop->get_user($_POST['uid']);

if(!$user)
{
  $rest->error("User Does Not Exist.");
  die();
}

$localUser = $bop->local_info();

$friend = $bop->query("SELECT * FROM friends WHERE (`to`=? AND `from`=?) OR (`to`=? AND `from`=?)", [$localUser->id, $user->id, $user->id, $localUser->id])->fetchAll();

if($friend)
{
  $rest->error("You Are Already Friends With This User.");
  die();
}

$time = time();

$friend = $bop->insert("friends", [
  "to" => $user->id,
  "from" => $localUser->id,
  "created" => $time,
  "accepted" => "0"
]);
$rest->success();
?>
