<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_POST['tid']) || !isset($_POST['req']))
{
  die();
}
if(!is_numeric($_POST['tid']))
{
  die();
}
$tid = (int) $_POST['tid'];
require("/var/www/html/api/community/class.php");
require("/var/www/html/api/rest.php");
$community = $com->get($tid);

switch($_POST['req'])
{
  case "approve":
    $com->approveMember($tid);
    $rest->success(["Approved member!"]);
    break;
  case "decline":
    $com->declineMember($tid);
    $rest->success(["Declined member!"]);
    break;
}
?>
