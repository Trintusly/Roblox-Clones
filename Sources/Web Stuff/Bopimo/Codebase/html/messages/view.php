<?php
if(!isset($_GET['id']))
{
  require("/var/www/html/error/404.php");
  die();
}
if(!is_numeric($_GET['id']))
{
  require("/var/www/html/error/404.php");
  die();
}
$mid = (int) $_GET['id'];
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localUser = $bop->local_info();
$msg = $bop->look_for("messages", ["id" => $mid]);
if(!$msg)
{
  require("/var/www/html/error/404.php");
  die();
}
if(!($msg->to == $localUser->id || $msg->from == $localUser->id))
{
  require("/var/www/html/error/404.php");
  die();
}
require("/var/www/html/site/header.php");
if($msg->to == $localUser->id)
{

  $bop->update_("messages", ["read" => 1], ["id" => $mid]);
}
$otherUser = $bop->get_user($msg->from);
$otherAvatar = $bop->avatar($otherUser->id);
?>
<div class="col-1-1">
  <a href="/messages" style="color:#8973f9">
		<i class="fas fa-chevron-left"></i> Return to messages
	</a>
</div>
<div class="col-1-1">
  <div class="page-title"><?=htmlentities($msg->title)?></div>
</div>
<div class="col-1-1">
  <div class="card border">
    <div class="col-3-12">
      <a href="/profile/<?=$otherUser->id?>" style="color:black">
        <center><img src="https://storage.bopimo.com/avatars/<?=$otherAvatar->cache?>.png" class="image">
        <?=htmlentities($otherUser->username)?></center>
      </a>
    </div>
    <div class="col-9-12" style="word-wrap:break-word;">
      <?=nl2br($bop->bbCode($msg->body))?>
    </div>
  </div>
</div>
<center><a href="/messages/compose/?id=<?=$otherUser->id?>" class="button success">Reply</a></center>
<?php
$bop->footer();
?>
