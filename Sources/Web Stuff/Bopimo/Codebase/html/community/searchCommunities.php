<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/site/header.php");
require("/var/www/html/api/community/class.php");
?>
<div class="col-1-1" style="margin-bottom:25px;">
  <a href="/community/" style="color:#8973f9">
  	<i class="fas fa-chevron-left"></i> Return to communities
  </a>
</div>
<?php
if(!isset($_GET['query']) || !isset($_GET['page']))
{
  die();
  $bop->footer();
}
if(!is_string($_GET['query']) || !is_numeric($_GET['page']))
{
  ?>
  <div class="col-1-1"><div class="banner danger">Invalid query.</div></div>
  <?php
  $bop->footer();
  die();
}
$stripped = strtolower(str_replace('-', '', $_GET['query']));
$show = str_replace("-"," ",$_GET['query']);
if(!ctype_alnum($stripped))
{
  ?>
  <div class="col-1-1"><div class="banner danger">No special characters in your search query.</div></div>
  <?php
  $bop->footer();
  die();
}
$communities = $bop->query("SELECT * FROM community WHERE stripped_name LIKE ? LIMIT 0, 10", ["%".$stripped."%"], true);
?>
<div class="content">
  <div class="page-title">
    Viewing results for: "<?=htmlentities($show)?>"
  </div>
</div>
<?php
foreach($communities as $community)
{
  $members = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0", [$community['id']])->fetchColumn();
  $owner = $com->getOwner($community['id']);
  $founder = $bop->get_user($community['founder']);
  ?>
  <div class="card border">
    <div class="col-2-12">
      <a href="/community/view/<?=$community['id']?>">
      <img src="<?php
      switch($community['pending'])
      {
        case "0":
        ?>
https://storage.bopimo.com/thumbnails/awaiting.png<?php
        break;
        case "1":
        ?>
https://storage.bopimo.com/community/<?=$community['cache']?>.png<?php
        break;
        case "2":
        ?>
https://storage.bopimo.com/thumbnails/declined.png<?php
        break;
      }
      ?>" class="image">
    </a>
    </div>
    <div class="col-6-12">
      <div class="item-name offsale disabled">
        <a style="color:#505050;" href="/community/view/<?=$community['id']?>"><?=$community['name']?></a>
      </div>
      <p style="font-size:12px;"><?=substr(htmlentities($community['desc']), 0, 2500)?></p>
    </div>
    <div class="col-4-12">
      Created: <b><?=substr($community['created'], 5, 2) . "/" . substr($community['created'], 8, 2) . "/" . substr($community['created'], 0, 4)?></b>
      <br>
      Founder: <a href="/profile/<?=$founder->id?>"><?=htmlentities($founder->username)?></a>
      <br>
      Current Owner: <a href="/profile/<?=$owner->id?>"><?=htmlentities($owner->username)?></a>
      <br>
      Members: <?=$members?>
    </div>
  </div>
  <?php
}
?>
<?php
$bop->footer();
?>
