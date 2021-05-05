<?php
require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/rest.php");

if (!isset($_POST["token"])) {
  $rest->error("Invalid CSRF token.");
  die();
}

if (!$bop->checkToken($_POST["token"])) {
  $rest->error("Invalid CSRF token.");
  die();
}

if(!$bop->logged_in())
{
  $rest->error("Not logged in.");
  die();
}
$localUser = $bop->local_info();
$pwrs = $bop->query("SELECT COUNT(*) FROM password_requests WHERE user=? AND ? < time + 86400", [$localUser->id, time()])->fetchColumn();
if($pwrs != 0)
{
  $rest->error("You have made a password reset request within the last 24 hours.");
  die();
}
if(!$bop->isVerified($localUser->id))
{
  $rest->error("This user is not verified.");
  die();
}
$uuid = $bop->uuid();
$pre = $bop->insert("password_requests", [
  "user" => $localUser->id,
  "uniq" => $uuid,
  "time" => time()
]);
$message = '<head><link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"><link rel="stylesheet" type="text/css" href="/css/main.css?c=1535223873"></head>';
$message = "<center>";
$message .= "<img src='https://www.bopimo.com/images/logo.png'><br>";
$message .= "<h1>Reset your password for {$localUser->username}</h1><br>";
$message .= "<a class='button success' href='https://www.bopimo.com/reset/{$uuid}'>Click here to reset</a>";
$message .= "</center>";
$bop->mail($localUser->email, "Bopimo password reset for {$localUser->username}", $message);
session_destroy();
$return = array(
  "msg" => "An email as been sent to {$localUser->email}, be sure to check your spam for the email. You have been logged out."
);
$rest->success($return);
?>
