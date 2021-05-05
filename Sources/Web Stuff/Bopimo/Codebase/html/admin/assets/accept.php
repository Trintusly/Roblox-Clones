<?php
require("/var/www/html/site/bopimo.php");

$requiredLevel = 1; // Trial Mod Minimum To Access
if(!$bop->isAllowed($requiredLevel))
{
  require("/var/www/html/error/404.php");
  die();
}

$user = $bop->local_info();
$avatar = $bop->avatar($user->id);
?>
