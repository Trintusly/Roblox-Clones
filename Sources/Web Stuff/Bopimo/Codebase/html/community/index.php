<?php
$ads = true;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$pageName = "Communities";
require("/var/www/html/site/header.php");
require("/var/www/html/api/community/class.php");
?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-9016364683167219",
enable_page_level_ads: true
});
</script>
<div class="col-1-1">
  <form action="" method="POST" id="searchForm">
    <div class="col-1-12"><a class="button success" href="/community/create">Create</a></div>
    <div class="col-10-12" style="padding-left:20px;"><input type="text" class="width-100" placeholder="Search term here" id="searchQuery"></div>
    <div class="col-1-12"><input type="submit" class="button success width-100" value="Search"></div>
  </form>
</div>
<script src="/community/js/search.js"></script>
<?php
if($bop->logged_in())
{
  $localInfo = $bop->local_info();
  ?>
  <div class="content">
    <div class="page-title">
      Your communities
    </div>
    <?php
    $communities = $bop->query("SELECT DISTINCT(community.id), community.desc, community.pending, community.name, community.shorthand, community.founder, community.created, community.cache FROM community INNER JOIN community_member ON community.id = community_member.cid WHERE community_member.uid=?", [$localInfo->id], true);
    if(count($communities) == 0)
    {
      ?>
      <div class="col-1-1"><div class="banner danger">You are not in any communities!</div></div>
      <?php
    } else {
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
    }
    ?>
  </div>
  <?php
}
?>
<div class="page-title">
  Popular groups
</div>
<?php
$popular = $bop->query("SELECT * FROM community ORDER BY members DESC LIMIT 0, 5", [], true);
foreach($popular as $community)
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
