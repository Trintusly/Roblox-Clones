<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_GET['id']))
{
  die();
}
if(!is_numeric($_GET['id']))
{
  die();
}
$cid = (int) $_GET['id'];
require("/var/www/html/api/community/class.php");
$community = $com->get($cid);
if(is_bool($community))
{
  require("/var/www/html/error/404.php");
  die();
}
if(!$bop->logged_in())
{
  require("/var/www/html/error/403.php");
  die();
}
$localInfo = $bop->local_info();
$owner = $com->getOwner($cid);
if($owner->id != $localInfo->id)
{
  require("/var/www/html/error/403.php");
  die();
}
$pageName = "Community Settings";
require("/var/www/html/site/header.php");
$tags = $com->tags($cid);
?>
<div class="popup-background active"></div>
<div class="col-1-1" style="margin-bottom:25px;">
  <a href="/community/view/<?=$community->id?>" style="color:#8973f9">
  	<i class="fas fa-chevron-left"></i> Return to view page
  </a>
</div>


<div class="content">
  <div class="page-title">
    <?=htmlentities($community->name)?> [<font color="#8973f9"><?=htmlentities($community->shorthand)?></font>] Settings
  </div>
  <div class="banner danger hidden">[Error]</div>
  <div class="banner success hidden">[Success]</div>
  <div class="tab-container" style="margin-bottom: 6px;">
	<div class="tab col-1-2 current tab1E" id="getPending">
		General
	</div>
	<div class="tab col-1-2 tab2E" id="getSent">
		Members
	</div>
</div>
<div id='tab1'>
  <div class="col-5-12">

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
	</div>
	<div class="col-7-12" style="padding-right:0px;">
    <div class="card b centered">
      <div class="top">Description</div>
      <div class="body">
        <textarea class="width-100" placeholder="Community Description" id="desc" style="height: 350px; margin-top: 5px; margin-bottom: 5px;"><?=htmlentities($community->desc)?></textarea>
        <button style="float:right;" class="button success" req="bio" id="updateDesc" cid="<?=$community->id?>">Update Description</button>
      </div>
    </div>
  </div>
</div>
<div id='tab2' style='display: none;'>
	<div class="col-5-12">
      <div class="card b centered">
        <div class="top">Tags</div>
        <div class="body" style="text-align:left;">
          <?php
          if($community->postable == "1")
          {
            ?>
            <div class="col-1-1">
              <div class="col-6-12" style="padding-right:-20px;">
                <input class="width-100" placeholder="New Tag Name" id="tagTitleNew">
              </div>
              <div class="col-2-12"  style="padding-right:-20px;">
                <button class="button success" id="createNewTag" cid="<?=$community->id?>" title="Create a new tag">Create</button>
              </div>
              <div class="col-4-12" style="padding-right:-20px;">
                <select style="width:80%;margin-left:20%;" id="newTagThing" title="Set the permission group of this tag.">
                  <option perm="0">Members</option>
                  <option perm="1">Administrators</option>
                </select>
              </div>
            </div>
            <font color="#8973f9" style="font-size:25px;">Members</font>
            <?php
            foreach($tags['members'] as $tag)
            {
              ?>
              <div class="col-1-1" id="tag_<?=$tag['id']?>">
                <div class="col-6-12" style="padding-right:-20px;">
                  <input class="width-100" placeholder="Tag Name" id="title_<?=$tag['id']?>" value="<?=htmlentities($tag['name'])?>">
                </div>
                <div class="col-2-12"  style="padding-right:-20px;">
                  <button class="button success updateTagName" class="width-100" req="bio" tid="<?=$tag['id']?>" cid="<?=$community->id?>" title="Rename tag">Update</button>
                </div>
                <div class="col-4-12" style="padding-right:-20px;">
                  <select style="width:80%;margin-left:20%;" class="member-tags" title="Change permission group of this tag.">
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="0">Members</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="1">Administrators</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="del"><font color="red">Delete</font></option>
                  </select>
                </div>
              </div>
              <?php
            }
            ?>
            <br>
            <font color="#8973f9" style="font-size:25px;">Administrators</font>
            <?php
            foreach($tags['administrators'] as $tag)
            {
              ?>
              <div class="col-1-1" id="tag_<?=$tag['id']?>">
                <div class="col-6-12" style="padding-right:-20px;">
                  <input class="width-100" placeholder="Tag Name" id="title_<?=$tag['id']?>" value="<?=htmlentities($tag['name'])?>">
                </div>
                <div class="col-2-12"  style="padding-right:-20px;">
                  <button class="button success updateTagName" class="width-100" req="bio" tid="<?=$tag['id']?>" cid="<?=$community->id?>" title="Rename tag">Update</button>
                </div>
                <div class="col-4-12" style="padding-right:-20px;">
                  <select style="width:80%;margin-left:20%;" class="member-tags" title="Change permission group of this tag.">
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="1">Administrators</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="0">Members</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="del"><font color="red">Delete</font></option>
                  </select>
                </div>
              </div>
              <?php
            }
          } else {


            /*
            TODO:

            Improve security on update.
            Improve UI mainly CSS on both settings and view page.
            Approving members feature for non-open groups.
            Prevent spam.
            Create community feature.
            */


            ?>
            <div class="">
              <div class="col-6-12" style="padding-right:-20px;">
                <input class="width-100" placeholder="Tag Name" id="tagTitleNew">
              </div>
              <div class="col-2-12"  style="padding-right:-20px;">
                <button class="button success" id="createNewTag" cid="<?=$community->id?>">Create</button>
              </div>
              <div class="col-4-12" style="padding-right:-20px;">
                <select style="width:80%;margin-left:20%;" id="newTagThing">
                  <option perm="0">Members</option>
                  <option perm="1">Posters</option>
                  <option perm="2">Administrators</option>
                </select>
              </div>
            </div>
            <font color="#8973f9" style="font-size:25px;">Members</font>
            <?php
            foreach($tags['members'] as $tag)
            {
              ?>
              <div class="" id="tag_<?=$tag['id']?>">
                <div class="col-6-12" style="padding-right:-20px;">
                  <input class="width-100" placeholder="Tag Name" id="title_<?=$tag['id']?>" value="<?=htmlentities($tag['name'])?>">
                </div>
                <div class="col-2-12"  style="padding-right:-20px;">
                  <button class="button success updateTagName" class="width-100" req="bio" tid="<?=$tag['id']?>" cid="<?=$community->id?>" title="Rename tag">Update</button>
                </div>
                <div class="col-4-12" style="padding-right:-20px;">
                  <select style="width:80%;margin-left:20%;" class="member-tags" title="Change permission group of this tag.">
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="0">Members</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="1">Posters</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="2">Administrators</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="del"><font color="red">Delete</font></option>
                  </select>
                </div>
              </div>
              <?php
            }
            ?>

            <br>
            <font color="#8973f9" style="font-size:25px;">Posters</font>
            <?php
            foreach($tags['posters'] as $tag)
            {
              ?>
              <div class="" id="tag_<?=$tag['id']?>">
                <div class="col-6-12" style="padding-right:-20px;">
                  <input class="width-100" placeholder="Tag Name" id="title_<?=$tag['id']?>" value="<?=htmlentities($tag['name'])?>">
                </div>
                <div class="col-2-12"  style="padding-right:-20px;">
                  <button class="button success updateTagName" class="width-100" req="bio" tid="<?=$tag['id']?>" cid="<?=$community->id?>" title="Rename tag">Update</button>
                </div>
                <div class="col-4-12" style="padding-right:-20px;">
                  <select style="width:80%;margin-left:20%;" class="member-tags" title="Change permission group of this tag.">
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="1">Posters</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="0">Members</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="2">Administrators</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="del"><font color="red">Delete</font></option>
                  </select>
                </div>
              </div>
              <?php
            }
            ?>
            <br>
            <font color="#8973f9" style="font-size:25px;">Administrators</font>
            <?php
            foreach($tags['administrators'] as $tag)
            {
              ?>
              <div class="" id="tag_<?=$tag['id']?>">
                <div class="col-6-12" style="padding-right:-20px;">
                  <input class="width-100" placeholder="Tag Name" id="title_<?=$tag['id']?>" value="<?=htmlentities($tag['name'])?>">
                </div>
                <div class="col-2-12"  style="padding-right:-20px;">
                  <button class="button success updateTagName" class="width-100" req="bio" tid="<?=$tag['id']?>" cid="<?=$community->id?>" title="Rename tag">Update</button>
                </div>
                <div class="col-4-12" style="padding-right:-20px;">
                  <select style="width:80%;margin-left:20%;" class="member-tags" title="Change permission group of this tag.">
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="2">Administrators</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="0">Members</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="1">Posters</option>
                    <option tid="<?=$tag['id']?>" cid="<?=$community->id?>" perm="del"><font color="red">Delete</font></option>
                  </select>
                </div>
              </div>
              <?php
            }
            ?>
            <?php
          }
          ?>

        </div>
      </div>
  </div>

<div class="col-7-12" style="padding-right:0px;">
  <?php
  if($community->open == "0")
  {
    ?>
    <div style="padding-bottom:10px;">
      <div class="card b centered">
        <div class="top">Approve Members</div>
        <div class="body">
          <div class="col-10-12">
            <input class="width-100" placeholder="Search Pending Members" id="searchPending">
          </div>
          <div class="col-2-12">
            <button class="button success" id="search" cid="<?=$community->id?>">Search</button>
          </div>
          <div class="col-1-1" id="searchHtmlPending"></div>
        </div>
      </div>
    </div>
    <?php
  }
  ?>


  <div class="card b centered">
    <div class="top">Members</div>
    <div class="body">
      <select class="width-100" id="member-tags">
        <?php
        $i = 0;
        $tags = $com->tags($community->id);
        foreach($tags as $tagParent)
        {
          if($i == 0) {
            ?>
            <option style="color:#8973f9;" showtype="perm" num="0">MEMBERS</option>
            <?php
          } elseif($i == 1 && $community->postable == "1") {
            ?>
            <option style="color:#8973f9;" showtype="perm" num="1">ADMINISTRATORS</option>
            <?php
          } elseif($i == 1 && $community->postable == "0") {
            ?>
            <option style="color:#8973f9;" showtype="perm" num="1">POSTERS</option>
            <?php
          } elseif($i == 2 && $community->postable == "0")
          {
            ?>
            <option style="color:#8973f9;" showtype="perm" num="2">ADMINISTRATORS</option>
            <?php
          }
          if($i == 3 || ($i == 2 && $community->postable == "1"))
          {
            break;
          }
          foreach($tagParent as $tag)
          {
            $members = $bop->query("SELECT COUNT(*) FROM community_member WHERE cid=? AND banned=0 AND tag=?", [$community->id, $tag['num']])->fetchColumn();
            ?>
            <option showtype="tag" num="<?=$tag['num']?>"><?=htmlentities($tag['name'])?> (<?=$members?>)</option>
            <?php
          }
          $i++; //increment tag parent selection
        }
        ?>
      </select>
      <div class="col-1-1">
        <span id="replace"></span>
      </div>
    </div></div>
  </div>
</div>
<?php
$bop->footer();
?>
<script>
$(document).ready(function(){
  curPage = 1;
  load(1);

  $(".tab1E").click(function () {
	  $("#tab1").show();
	  $("#tab2").hide();
	  $(".current").removeClass("current");
	  $(this).addClass("current");
  });

  $(".tab2E").click(function () {
	  $("#tab1").hide();
	  $("#tab2").show();
	  $(".current").removeClass("current");
	  $(this).addClass("current");
  });



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
    $.post("/community/js/fetchSettings.php", {
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
});
</script>
<script src="/community/js/settings.js"></script>
