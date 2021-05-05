<?php
if(!isset($_POST['uid']) || !isset($_POST['num']))
{
  die();
}
if(!is_numeric($_POST['uid']) || !is_numeric($_POST['num']))
{
  die();
}
$uid = (int) $_POST['uid'];
$num = (int) $_POST['num'];
require("/var/www/html/api/community/class.php");
$user = $bop->get_user($uid);
if(is_bool($user))
{
  die();
}
$tag = $bop->look_for("community_member_tags", ["id" => $num]);
if(is_bool($tag))
{
  die();
}
$community = $com->get($tag->cid);
$bop->update_("community_member", ["tag" => $tag->num, "perm" => $tag->perm], ["uid" => $uid, "cid" => $community->id]);
require("/var/www/html/api/rest.php");
$rest->success(["Successfully updated tag for member."]);
?>
