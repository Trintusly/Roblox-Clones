<?php
$groupLimit = 4;
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
$communities = $bop->query("SELECT COUNT(*) FROM community_member WHERE uid=? AND banned=0", [$localInfo->id])->fetchColumn();
if($communities > $groupLimit)
{
  $rest->error("You are in too many communities. ({$groupLimit} is the maximum)");
  die();
}
$community = $com->get($cid);
if(is_bool($community))
{
  die();
}
$member = $com->getMember($cid, $localInfo->id);
if(is_bool($member) && !$com->isPending($cid, $localInfo->id)) //not a member (will create)
{
  if($community->open == "1") // Is an open community
  {
    $bop->insert("community_member", [
      "cid" => $cid,
      "uid" => $localInfo->id,
      "tag" => $community->default_tag
    ]);
    $bop->update_("community", ["members" => $community->members + 1], ["id" => $community->id]);
    $rest->success();
  } else {
    $bop->insert("community_join_requests", [
      "uid" => $localInfo->id,
      "cid" => $cid,
      "time" => time()
    ]);
    $rest->success();
  }
} elseif($com->isPending($cid, $localInfo->id)) {
  $rest->error("You are pending to join already.");
}
?>
