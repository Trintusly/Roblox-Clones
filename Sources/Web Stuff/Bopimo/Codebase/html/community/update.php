<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_POST['cid']) || !isset($_POST['req']) || !isset($_POST['desc']) || !isset($_POST['tid']))
{
  die();
}
if(!is_numeric($_POST['cid']) || !is_numeric($_POST['tid']))
{
  die();
}
require("/var/www/html/api/community/class.php");
require("/var/www/html/api/rest.php");
$cid = (int) $_POST['cid'];
$tid = (int) $_POST['tid'];
$community = $com->get($cid);
if(is_bool($community))
{
  die();
}
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localInfo = $bop->local_info();
$owner = $com->getOwner($cid);
if($owner->id != $localInfo->id)
{
  die();
}

switch($_POST['req'])
{

  case "update description":
    if(strlen($_POST['desc']) <= 4)
    {
      $rest->error("Description must be more than 4 characters!");
      die();
    }
    if(strlen($_POST['desc']) > 5000)
    {
      $rest->error("Description must be less than 5000 characters!");
      die();
    }
    $bop->update_("community", [
      "desc" => $_POST['desc']
    ], [
      "id" => $community->id
    ]);
    $rest->success(["Successfully updated description!"]);
    break;

  case "update tag name":
    $tag = $bop->look_for("community_member_tags", ["id" => $tid]);
    if(is_bool($tag))
    {
      die();
    }
    $look = $bop->look_for("community_member_tags", ["cid" => $cid, "name" => $_POST['desc']]);
    if(!is_bool($look))
    {
      $rest->error("Tag with that name already exists!");
      die();
    }
    $bop->update_("community_member_tags", ["name" => $_POST['desc']], ["id" => $tid]);
    $rest->success(["Updated tag name."]);
    break;

  case "up":
    if($_POST['desc'] != "del")
    {
      if($com->updateTagPerm($tid, $_POST['desc']) == false)
      {
        $rest->error("Something went wrong.");
      } else {
        $rest->success(["Successfully updated permissions!"]);
      }
    } else {
      if($com->deleteTag($tid) == false)
      {
        $rest->error("You cannot remove this tag, as it is the default tag, or will create 0 tags under a permission template!");
      } else {
        $rest->success(["Successfully deleted tag!"]);
      }
    }
    break;

  case "create tag":
    if($community->postable == 1 && $_POST['desc'] > 2)//postable
    {
      $rest->error();
      die();
    } elseif($community->postable == 0 && $_POST['desc'] > 3)
    {
      $rest->error();
      die();
    }

    $tag = $com->createTag($cid, $_POST['desc'], $tid);
    if(is_bool($tag))
    {
      $rest->error("This tag name is already in use.");
      die();
    }
    $rest->success(["Created tag."]);
    break;
  case "get search pending":
    
    break;

  default:
    die("Bad request.");
}
?>
