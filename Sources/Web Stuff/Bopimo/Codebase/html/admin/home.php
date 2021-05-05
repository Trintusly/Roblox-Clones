<?php
require("/var/www/html/site/bopimo.php");

/*
Admin Levels:

1 - Trial Moderator
*/

$requiredLevel = 1; // Trial Mod Minimum To Access
if(!$bop->isAllowed($requiredLevel))
{
  require("/var/www/html/error/404.php");
  die();
}

$user = $bop->local_info();
$avatar = $bop->avatar($user->id);

$logs = $bop->query("SELECT * FROM admin_logs WHERE user=? ORDER BY id DESC LIMIT 0, 10", [$user->id]);
?>
<div class="col-4-12">
  <div class="card b centered">
    <div class="top">You</div>
    <div class="body">
      <img src="https://storage.bopimo.com/avatars/<?=$avatar->cache?>.png" class="image">
      <br><br>
      Rank: <?=$bop->modString($user->id)?>
      <br>
      Admin Points: <b><u><?=$user->admin_points?></u></b>
    </div>
  </div>
  <div class="card b">
	<div class="top centered">Gift Item</div>
    <div class="body" id="giftContainer">
		<span style="color:grey;font-size:0.9rem">User ID</span>
		<input id="giftUserId" type="text" style="width:100%;padding:3px;">
		<span style="color:grey;font-size:0.9rem">Item ID</span>
		<input id="giftItemId" type="text" style="width:100%;padding:3px;">
		<div class="shop-search-button centered" id="giftItem" style="width:50%;margin: auto;">Gift</div>
	</div>
  </div>
</div>
<div class="col-8-12">
  <div class="card b">
    <div class="top">Recent Moderation Actions</div>
  </div>
  <?php
  if($logs->rowCount() == 0)
  {
    ?>
    <div class="banner alert">No Results</div>
    <?php
  } else {
    foreach($logs as $log)
    {
      $log = (object) $log;
      ?>
      <div class="card border">You <?=$log->msg?> <?=$log->type?> #<?=$log->affected?></div>
      <?php
    }
  }
  ?>
</div>
