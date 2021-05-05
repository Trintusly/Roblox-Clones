<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require("/var/www/html/api/rest.php");
if(!isset($_POST['id']))
{
  $rest->error("Bad request (No ID defined)");
  die();
}
if(!is_numeric($_POST['id']))
{
  $rest->error("Bad request (ID is not integer)");
  die();
}
require("/var/www/html/site/bopimo.php");
$tid = $_POST['id'];
$thread = $bop->look_for("threads", [
  "id" => $tid
]);
if(!$thread)
{
  $rest->error("Bad request (thread doesn't exist)");
  die();
}

$user = $bop->local_info();
if(intval($user->admin) == 0)
{
  $rest->error("Bad request (Privileges do not match minimum)");
}

$bop->update_("threads", ["deleted" => intval(!boolval($thread->deleted))], ["id" => $tid]);
$bop->insert("admin_logs", [
  "user" => $user->id,
  "affected" => $thread->id,
  "msg" => "deleted",
  "type" => "thread"
]);

$rest->success();
?>
