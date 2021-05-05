<?php
$ads = true;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/api/community/class.php");
if(!isset($_GET['id'])) {die(header("location: /"));}
if(!is_numeric($_GET['id'])) {
  require("/var/www/html/error/403.php");
  die();
}
$community = $com->get($_GET['id']);
if($community == false)
{
  require("/var/www/html/error/404.php");
  die();
}
$pageName = htmlentities($community->name);
?>
<meta charset="UTF-8">
<meta property="og:site_name" content="bopimo.com">
<meta property="og:image" content="<?php
$owner = $com->getOwner($_GET['id']);
$founder = $bop->get_user($community->founder);
switch($community->pending)
{
  case "0":
  ?>
https://storage.bopimo.com/thumbnails/awaiting.png<?php
  break;
  case "1":
  ?>
https://storage.bopimo.com/community/<?=$community->cache?>.png<?php
  break;
  case "2":
  ?>
https://storage.bopimo.com/thumbnails/declined.png<?php
  break;
}
?>">
<meta name="description" content="<?=htmlentities(substr($community->desc, 0, 200))?>">
<meta name="keywords" content="Bopimo, Bopimo thread, Bopimo Game">
<meta name="author" content="<?=htmlentities($founder->username)?>">
<?php
require("/var/www/html/site/header.php");
?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-9016364683167219",
enable_page_level_ads: true
});
</script>
<?php
$cid = (int) $_GET['id'];
if($bop->logged_in())
{
  $localUser = $bop->local_info();
  if($com->isCommunityBanned($_GET['id'], $localUser->id))
  {
    ?>
    <div class="banner danger centered">
      You are banned from this community!
    </div>
    <div class="col-1-1" style="margin-bottom:25px;">
      <a href="/community" style="color:#8973f9">
      	<i class="fas fa-chevron-left"></i> Return to communities
      </a>
    </div>
    <?php
    $bop->footer();
    die();
  }
}
$members = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0", [$community->id])->fetchColumn();
?>
<style>

.hover-edit {
	color:grey;
}
.hover-edit:hover {
	color: #000;
	cursor: pointer;
}
.popup-background {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 200px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.3);
}

.popup-background.active,.popup.active {
	display: block;
}

.popup {
	display: none;
	z-index: 2;
	position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

}
</style>
<div class="banner danger hidden">Error changing bio: All fields are required.</div>
<div class="banner success hidden">
    [Success]
  </div>
<div class="col-1-1" style="margin-bottom:25px;">
  <a href="/community" style="color:#8973f9">
  	<i class="fas fa-chevron-left"></i> Return to communities
  </a>
</div>
<div class="content">
  <div class="page-title"><?=htmlentities($community->name)?> [<font color="#8973f9"><?=htmlentities($community->shorthand)?></font>]
    <?php
    if($bop->logged_in()) {
      $localInfo = $bop->local_info();
      if($founder->id == $localInfo->id) {
        ?>
        <div class="hover-edit" style="float:right;padding-right:10px;font-size:1.5rem;"><a href="/community/<?=$community->id?>/settings/" title="Edit this community."><i class="far fa-edit"></i></a></div></div>
        <?php
      }
    }
    ?>
</div>
<div class="col-4-12">
  <div class="card b centered" style="margin-bottom:5px;">
    <div class="top">Logo</div>
    <div class="body">
      <img src="<?php
      switch($community->pending)
      {
        case "0":
        ?>
https://storage.bopimo.com/thumbnails/awaiting.png<?php
        break;
        case "1":
        ?>
https://storage.bopimo.com/community/<?=$community->cache?>.png<?php
        break;
        case "2":
        ?>
https://storage.bopimo.com/thumbnails/declined.png<?php
        break;
      }
      ?>" class="image">
    </div>
  </div>
  <?php
  if($bop->logged_in())
  {
    $localMember = $com->getMember($_GET['id'], $localUser->id);
    if(is_bool($localMember) && !$com->isPending($cid, $localUser->id)) //Not a member
    {
      ?>
      <div class="buy-button button success" id="joinNow" style="width:calc(100% - 40px);margin-bottom:5px;margin-top:5px;text-align:center;">Join Now</div>
      <?php
    } elseif($com->isPending($cid, $localUser->id)) {
      ?>
      <div class="buy-button button offsale disabled" id="joinNow" style="width:calc(100% - 40px);margin-bottom:5px;margin-top:5px;text-align:center;">Pending</div>
      <?php
    } elseif($owner->id != $localMember->uid) {
      ?>
      <div class="buy-button button danger" id="leaveNow" style="width:calc(100% - 40px);margin-bottom:5px;margin-top:5px;text-align:center;">Leave</div>
      <?php
    }
  }
  ?>
  <div class="card b centered">
    <div class="top">Statistics</div>
    <div class="body" style="text-align:left;">
      Created: <b><?=substr($community->created, 5, 2) . "/" . substr($community->created, 8, 2) . "/" . substr($community->created, 0, 4)?></b>
      <br>
      Founder: <a href="/profile/<?=$founder->id?>"><?=htmlentities($founder->username)?></a>
      <br>
      Current Owner: <a href="/profile/<?=$owner->id?>"><?=htmlentities($owner->username)?></a>
      <br>
      Members: <?=$members?>
    </div>
  </div>
</div>
<div class="col-8-12">
  <div class="card b centered">
    <div class="top">About <?=htmlentities($community->name)?></div>
    <div class="body" style="height:450px;text-align:left;">
      <?=nl2br($bop->bbCode(htmlentities($community->desc)))?>
    </div>
  </div>
</div>
<div class="col-1-1">
  <div class="card b">
    <div class="top centered">Members</div>
    <div class="body">
      <div class="col-1-1">
        <select class="width-100" id="member-tags">
          <?php
          $tags = $com->tags($_GET['id']);
          if($community->postable == "1")
          {
            $membersN = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND perm=0", [$community->id])->fetchColumn();
            $adminsN = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND perm=1", [$community->id])->fetchColumn();
            $foundersN = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND perm=2", [$community->id])->fetchColumn();
            ?>
            <option style="color:#8973f9;" num="0" tagNum="false" showType="perm">MEMBERS (<?=$membersN?>)</option>
            <?php
            foreach($tags['members'] as $tag)
            {
              $count = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND tag=?", [$community->id, $tag['num']])->fetchColumn();
              ?>
              <option showType="tag" perm="false" num="<?=$tag['num']?>"><?=htmlentities($tag['name'])?> (<?=$count?>)</option>
              <?php
            }
            ?>
            <option style="color:#8973f9;" num="1" showType="perm">ADMINISTRATORS (<?=$adminsN?>)</option>
            <?php
            foreach($tags['administrators'] as $tag)
            {
              $count = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND tag=?", [$community->id, $tag['num']])->fetchColumn();
              ?>
              <option showType="tag" perm="false" num="<?=$tag['num']?>"><?=htmlentities($tag['name'])?> (<?=$count?>)</option>
              <?php
            }
            ?>
            <option style="color:#8973f9;" num="2" tagNum="false" showType="perm">FOUNDER (<?=$foundersN?>)</option>
            <option num="<?=$tags['founder'][0]['num']?>" showType="tag" perm="false"><?=htmlentities($tags['founder'][0]['name'])?></option>
            <?php
            var_dump($tags['founder'][0]['name']);
          } else {
            $membersN = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND perm=0", [$community->id])->fetchColumn();
            $postersN = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND perm=1", [$community->id])->fetchColumn();
            $adminsN = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND perm=2", [$community->id])->fetchColumn();
            $foundersN = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND perm=3", [$community->id])->fetchColumn();
            ?>
            <option style="color:#8973f9;" num="0" tagNum="false" showType="perm">MEMBERS (<?=$membersN?>)</option>
            <?php
            foreach($tags['members'] as $tag)
            {
              $count = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND tag=?", [$community->id, $tag['num']])->fetchColumn();
              ?>
              <option showType="tag" perm="false" num="<?=$tag['num']?>"><?=htmlentities($tag['name'])?> (<?=$count?>)</option>
              <?php
            }
            ?>
            <option style="color:#8973f9;" num="1" tagNum="false" showType="perm">POSTERS</option>
            <?php
            foreach($tags['posters'] as $tag)
            {
              $count = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND tag=?", [$community->id, $tag['num']])->fetchColumn();
              ?>
              <option showType="tag" perm="false" num="<?=$tag['num']?>"><?=htmlentities($tag['name'])?> (<?=$count?>)</option>
              <?php
            }
            ?>
            <option style="color:#8973f9;" num="2" showType="perm">ADMINISTRATORS</option>
            <?php
            foreach($tags['administrators'] as $tag)
            {
              $count = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND tag=?", [$community->id, $tag['num']])->fetchColumn();
              ?>
              <option showType="tag" perm="false" num="<?=$tag['num']?>"><?=htmlentities($tag['name'])?> (<?=$count?>)</option>
              <?php
            }
            ?>
            <option style="color:#8973f9;" num="3" tagNum="false" showType="perm">FOUNDER</option>
            <option num="<?=$tags['founder'][0]['num']?>" showType="tag" perm="false"><?=htmlentities($tags['founder'][0]['name'])?></option>
            <?php
            var_dump($tags['founder'][0]['name']);
          }
          ?>
        </select>
      </div>
      <span id="replace"></span>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
  curPage = 1;
  load(1);
  function error(msg)
  {
    $(".danger").text(msg);
    $(".danger").removeClass("hidden");
    window.setTimeout(function(){
      $(".danger").addClass("hidden");
    }, 3000);
  }
  function success(msg)
  {
    $(".banner.success").text(msg);
    $(".banner.success").removeClass("hidden");
    window.setTimeout(function(){
      $(".banner.success").addClass("hidden");
    }, 3000);
  }
  function load(page) {
    $.post("/community/fetch.php", {
      "page": curPage,
      "type": $("#member-tags").find(":selected").attr("showType"),
      "num": $("#member-tags").find(":selected").attr("num"),
      "cid": <?=$_GET['id']?>
    }, function(reply){
      $("#replace").html(reply);
    });
  }
  $("#member-tags").change(function(b){
    load(curPage);
  });
  $("#nextPage").click(function(){
    curPage = curPage + 1;
    load(curPage);
    console.log("dab");
  });
  $("#joinNow").click(function(){
    $.post("/community/join.php", {"cid":<?=$community->id?>}, function(reply){
      if(reply.status == "ok")
      {
        location.reload();
      } else {
        error(reply.error);
      }
    });
  });
  $("#leaveNow").click(function(){
    $.post("/community/leave.php", {"cid":<?=$community->id?>}, function(reply){
      if(reply.status == "ok")
      {
        location.reload();
      } else {
        error(reply.error);
      }
    });
  });
});
</script>
<?php
$bop->footer();
?>
