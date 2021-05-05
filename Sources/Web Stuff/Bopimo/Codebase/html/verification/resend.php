<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localUser = $bop->local_info();
$verify = $bop->look_for("verification", ["user" => $localUser->id]);
if($verify)
{
  $bop->delete("verification", ["id" => $verify->id]);
}
header("location: /verification");
?>
