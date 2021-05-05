<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/api/rest.php");
if(!isset($_POST['category']) || !isset($_POST['page']))
{
  $rest->error("Invalid arguments.");
  die();
}
if(!is_string($_POST['category']) || !is_numeric($_POST['page']))
{
  $rest->error("Invalid arguments.");
  die();
}
$page = (int) $_POST['page'];
$category = (string) $_POST['category'];
if($page <= 0)
{
  $rest->error("Invalid page number.");
  die();
}
$return = array();

require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  $rest->error("Not logged in.");
  die();
}
$limit = 10;
if($page == 1)
{
  $trueP = 0;
} else {
  $trueP = $page * $limit - $limit;
}
$sql = "LIMIT {$trueP}," . $limit;
$localUser = $bop->local_info(["id", "username"]);
switch($category)
{
  case "unread":
    $fetch = $bop->query("SELECT messages.id, messages.title, messages.body, messages.read, messages.time, messages.to, messages.from, users.username, users.id as uid, avatar.cache FROM `messages` INNER JOIN users ON users.id = messages.from INNER JOIN avatar ON avatar.user_id = users.id WHERE `to`=? AND `read`=0 ORDER BY messages.id DESC {$sql}", [$localUser->id], true);
    break;
  case "read":
    $fetch = $bop->query("SELECT messages.id, messages.title, messages.body, messages.read, messages.to, messages.from, users.username, messages.time, users.id as uid, avatar.cache FROM `messages` INNER JOIN users ON users.id = messages.from INNER JOIN avatar ON avatar.user_id = users.id WHERE `to`=? AND `read`=1 ORDER BY messages.id DESC {$sql}", [$localUser->id], true);
    break;
  case "outgo":
    $fetch = $bop->query("SELECT messages.id, messages.title, messages.body, messages.read, messages.to, messages.from, users.username, users.id as uid, messages.time, avatar.cache FROM `messages` INNER JOIN users ON users.id = messages.from INNER JOIN avatar ON avatar.user_id = users.id WHERE `from`=? ORDER BY messages.id DESC {$sql}", [$localUser->id], true);
    break;
  default:
    $rest->error("Invalid category.");
    die();
}
$count = count($fetch);

$return['res'] = $fetch;
$return['count'] = $count;
$return['local'] = $localUser;
$rest->success($return);
?>
