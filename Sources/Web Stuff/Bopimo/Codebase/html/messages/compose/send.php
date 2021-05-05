<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/api/rest.php");
if(!isset($_POST['title']) || !isset($_POST['body']) || !isset($_POST['uid']))
{
  $rest->error("Invalid arguments.");
  die();
}
require("/var/www/html/site/bopimo.php");
if (isset($_POST["token"])) {
  if ($bop->checkToken($_POST["token"])) {
    if(!is_string($_POST['title']) || !is_string($_POST['body']) || !is_numeric($_POST['uid']))
    {
      $rest->error("Invalid arguments.");
    }
    $uid = (int) $_POST['uid'];
    $title = (string) $_POST['title'];
    $body = (string) $_POST['body'];
    if(!$bop->logged_in())
    {
      $rest->error("User not logged in.");
      die();
    }
    $localUser = $bop->local_info();
    $string = str_replace(' ', '', $title);
    $string = str_replace('!', '', $string);
    if(!ctype_alnum($string))
    {
      $rest->error("Please no special characters in your title!");
      die();
    }
    if(strlen($title) < 4 || strlen($title) > 45)
    {
      $rest->error("Title must be 4 - 45 characters.");
      die();
    }
    if(strlen($body) < 4 || strlen($body) > 2000)
    {
      $rest->error("Body must be 4 - 2000 characters.");
      die();
    }
    if(!$bop->user_exists($uid))
    {
      $rest->error("This user does not exist.");
      die();
    }
    if($bop->isBanned($uid))
    {
      $rest->error("This user is banned.");
      die();
    }
    if($bop->tooFast())
    {
      $rest->error("You are sending messages too fast.");
      die();
    }
    $bop->updateFast();
    //peak human performance is $body and $title and $uid
    require("/var/www/html/messages/class.php");
    $msg = $message->new($uid, $localUser->id, $title, $body);
    $avatar = $bop->avatar($localUser->id);
    $bop->notify($uid, $localUser->username." sent a message.", "https://storage.bopimo.com/avatars/".$avatar->cache.".png", "/message/view/".$msg->id);
    $return = array(
      "msg" => $msg
    );
    $rest->success($return);
  }
}
?>
