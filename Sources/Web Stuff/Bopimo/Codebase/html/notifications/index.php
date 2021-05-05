<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localUser = $bop->local_info();
$res = $bop->query("SELECT * FROM notifications WHERE user=? ORDER BY `read` ASC, time DESC LIMIT 0, 10", [$localUser->id], true);
$read = $items = $bop->query("SELECT COUNT(*) FROM notifications WHERE user=? AND `read` = 0", [$localUser->id])->fetchColumn();
$bop->update_("notifications", ["read" => "1"], ["user" => $localUser->id, "read" => "0"]);
$pageName = "Notifications ({$read})";
require("/var/www/html/site/header.php");
if($read == 0)
{
  ?>
  <div class="banner success">You have no new notifications!</div>
  <?php
} else {
  ?>
  <div class="banner warning">You have <?=$read?> new notification(s).</div>
  <?php
}
?>
<div class="col-1-1"><div class="page-title">Notifications (<?=$read?>)</div></div>
<?php
foreach($res as $row)
{
  ?>
  <div class="col-1-1">
    <div class="card border" style="margin-bottom:5px;">
      <div class="col-1-12">
        <img class="image" src="<?=$row['img']?>">
      </div>
      <div class="col-11-12" style="margin-top:calc(4.25% - 30px);display:inline-block;">
        <div class="page-title"><a href="<?=$row['redirect']?>" target="_blank" style="color:black;"><?=($row['read'] == "0") ? "<b>" . $row['msg'] . "</b><font color='red'>*</font>" : $row['msg']?></a><span style="font-size:12.5px;color:grey;margin-left:1px;"> <?=$bop->timeAgo($row['time'])?></span></div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
$bop->footer();
?>
