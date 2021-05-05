<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localInfo = $bop->local_info();
$lookFor = $bop->look_for("invites", ["uid" => $localInfo->id]);
if(!is_bool($lookFor))
{
  die(header("location: /invites"));
}
$bop->insert("invites", ["uniq" => uniqid(), "uid" => $localInfo->id]);
die(header("location: /invites"));
?>
