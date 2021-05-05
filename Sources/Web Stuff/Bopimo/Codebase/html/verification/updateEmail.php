<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/rest.php");
if (isset($_POST["token"])) {
  if ($bop->checkToken($_POST["token"])) {
    if(!$bop->logged_in())
    {
      $rest->error("Not logged in.");
      die();
    }
    $localUser = $bop->local_info();
    if(!isset($_POST["email"]))
    {
      $rest->error("Invalid arguments.");
      die();
    }
    if(!is_string($_POST['email']))
    {
      $rest->error("Invalid arguments.");
      die();
    }
    $email = (string) $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $rest->error("Invalid email.");
      die();
    }
    $users = $bop->query("SELECT COUNT(*) FROM users WHERE email=? AND verified=1", [$email])->fetchColumn();
    if($users == 3)
    {
      $rest->error("This email has three attached users, which is the maximum.");
      die();
    }
    if($bop->tooFast(60))
    {
      $rest->error("Please wait ~1 minute to update your email again.");
      die();
    }
    if($localUser->email == $email)
    {
      $rest->error("This is already your email.");
      die();
    }
    $string = str_replace(".", "", $email);
    $string = str_replace("@", "", $string);
    $string = str_replace("-", "", $string);
    if(!ctype_alnum($string))
    {
      $rest->error("No special characters in email.");
      die();
    }
    $verify = $bop->look_for("verification", ["user" => $localUser->id]);
    if($verify)
    {
      $bop->delete("verification", ["id" => $verify->id]);
    }
    $bop->updateFast();
    $bop->update_("users", ["verified" => "0", "email" => $email], ["id" => $localUser->id]);
    $rest->success();
  }
}
?>
