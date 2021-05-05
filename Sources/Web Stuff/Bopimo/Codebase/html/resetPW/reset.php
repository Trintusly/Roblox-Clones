<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_GET['id']))
{
  require("/var/www/html/error/404.php");
  die();
}
if(!is_string($_GET['id']))
{
  require("/var/www/html/error/404.php");
  die();
}
$id = (string) $_GET['id'];
require("/var/www/html/site/bopimo.php");
if($bop->logged_in())
{
  session_destroy();
}
$verify = $bop->look_for("password_requests", ["uniq" => $id]);
if(!$verify)
{
  require("/var/www/html/error/404.php");
  die();
}
require("/var/www/html/site/header.php");
?>
<div class="banner success hidden">Test</div>
<div class="banner danger hidden">Test</div>
<div class="page-title">Reset Password</div>
<div class="col-1-1"><div class="card border">
  <form action="" id="submitReset">
    <input type="text" class="hidden disabled" id="uuid" value="<?=$id?>">
    <input type="password" placeholder="New Password" id="pw1" class="width-100">
    <input type="password" placeholder="Confirm Password" id="pw2" class="width-100">
    <input type="submit" value="Reset" class="button success">
  </form>
</div></div>
<script src="/resetPW/main.js"></script>
<?php
$bop->footer();
?>
