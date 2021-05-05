<?php

if(!isset($_GET['id']))
{
  die("Bad request");
}

if(!is_numeric($_GET['id']))
{
  die("bad request");
}
$uid = (int) $_GET['id'];

require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die();
}
$localUser = $bop->local_info();
if(!$bop->isAllowed($localUser->id))
{
  die();
}
if(!$bop->user_exists($uid))
{
  die("user don't exist");
}
$user = $bop->get_user($uid, ["hidden"]);
if($user->hidden == "0")
{
  $bop->update_("users", ["hidden" => "1"], ["id" => $uid]);
} else {
  $bop->update_("users", ["hidden" => "0"], ["id" => $uid]);
} 
$bop->insert("admin_logs", [
"user" => $localUser->id,
"affected" => $uid,
"msg" => "censored",
"type" => "user"
]);
$bop->updateAdminPoints(3);
die(header("location: /profile/{$uid}"));
?>
