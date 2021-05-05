<?php
require("/var/www/html/api/rest.php");
if(!isset($_POST['search']))
{
  $rest->error("Invalid search.");
  die();
}
if(!is_string($_POST['search']))
{
  $rest->error("Invalid arguments.");
  die();
}
if(!ctype_alnum($_POST['search']))
{
  $rest->error("No special characters in your search query.");
  die();
}
$search = (string) $_POST['search'];
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  $rest->error("Not logged in.");
  die();
}
$localUser = $bop->local_info();
$res = $bop->query("SELECT users.id, users.username, avatar.cache FROM users INNER JOIN avatar ON avatar.user_id = users.id WHERE users.id NOT IN (select id from punishment where user=users.id and ended=0) AND users.id <> ? AND users.hidden = 0 AND users.username LIKE ? LIMIT 0,6", [$localUser->id, "%{$search}%"], true);
$return = array(
  "res" => $res
);
$rest->success($return);
?>
