<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /"));
}
$user = $bop->local_info();
$banned = $bop->isBanned($user->id);
if(!$banned)
{
  die(header("location: /"));
}
if($banned->expires - time() > 0)
{
  die(header("location: /"));
}
$bop->update_("punishment", ["ended" => "1"], ["id" => $banned->id]);
$bop->update_("users", ["hidden" => 0], ["id" => $user->id]);
header("location: /");
?>
