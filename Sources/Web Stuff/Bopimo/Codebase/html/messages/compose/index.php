<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localUser = $bop->local_info();
if(isset($_GET['id']))
{
  if(is_numeric($_GET['id']))
  {
    $uid = (int) $_GET['id'];
    if($bop->user_exists($uid) && $uid != $localUser->id)
    {
      if(!$bop->isBanned($uid))
      {
        $foundUser = $bop->get_user($uid);
      }
    }
  }
}
require("/var/www/html/site/header.php");
?>
<div class="banner danger hidden">No replies</div>
<div class="col-1-1"><a href="/messages" style="color:#8973f9">
		<i class="fas fa-chevron-left"></i> Return to messages
	</a></div>
<div class="col-1-1">
  <div class="page-title" id="composeTo">Compose a message<?=(isset($foundUser)) ? " to ".htmlentities($foundUser->username)."" : ""?></div>
</div>
<div class="col-1-1">
  <form action="" id="mainForm" method="POST">
    <div class="col-11-12"><input type="text" id="searchQuery" class="width-100" placeholder="Search Username"></div>
    <div class="col-1-12"><input type="submit" value="Search" style="float:right;" class="button success"></div>
    <div class="col-1-1"><div class="card border">Search Results:<br><span id="searches"></span></div></div>
    <div class="col-1-1"><input type="text" <?=(!isset($foundUser)) ? 'id="username" username uid value="No Username Selected"' : 'id="username" username="'.htmlentities($foundUser->username).'" uid="'.$foundUser->id.'" value="'.$foundUser->username.'" style="color:green"'?> class="width-100" disabled></div>
  </form>
  <form id="messageForm">
    <div class="col-1-1"><input type="text" id="title" placeholder="Message Title" class="width-100"></div>
    <div class="col-1-1"><textarea style="width:calc(100% - 17px);height:200px;" id="body" placeholder="Message Body"></textarea></div>
    <center><input type="submit" value="Send" class="button success"></center>
  </div>
</div>
<script src="main.js"></script>
<?php
$bop->footer();
?>
