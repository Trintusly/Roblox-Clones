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

$unverified = $bop->query("SELECT * FROM items WHERE verified=0 LIMIT 0,1");

if($unverified->rowCount() == 0)
{
  ?>
  <div class="banner danger centered">
    No more items to verify. Check in soon, there will be plenty!
  </div>
  <?php
  die();
}

$un = $unverified->fetchObject();

$creator = $bop->get_user($un->creator);

var_dump($creator);
?>
