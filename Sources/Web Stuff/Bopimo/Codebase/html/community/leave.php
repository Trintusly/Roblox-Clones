<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_POST['cid']))
{
  die();
}

if(!is_numeric($_POST['cid']))
{
  die();
}
$cid = (int) $_POST['cid'];
require("/var/www/html/api/community/class.php");
require("/var/www/html/api/rest.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localInfo = $bop->local_info();
$community = $com->get($cid);
if(is_bool($community))
{
  die();
}
$owner = $com->getOwner($cid);
$member = $com->getMember($cid, $localInfo->id);
if($owner->id == $localInfo->id)
{
  die();
}
$bop->delete("community_member", ["id" => $member->id]);
$bop->update_("community", ["members" => $community->members - 1], ["id" => $community->id]);
$rest->success(["You have left this group."]);
?>
