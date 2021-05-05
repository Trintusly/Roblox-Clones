<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_POST['page']) || !isset($_POST['type']) || !isset($_POST['num']) || !isset($_POST['cid']))
{
  die();
}
if(!is_numeric($_POST['page']) || ($_POST['type'] != "perm" && $_POST['type'] != "tag") || !is_numeric($_POST['num']) || !is_numeric($_POST['cid']))
{
  die("e2");
}
if($_POST['page'] <= 0)
{
  die();
}
require("/var/www/html/api/community/class.php");
$community = $com->get($_POST['cid']);
if(is_bool($community))
{
  die("b3");
}
if($_POST['type'] == "perm")
{
  $members = $com->members($community->id, false, $_POST['num'], $_POST['page'], 12);
} elseif($_POST['type'] == "tag") {
  $members = $com->members($community->id, $_POST['num'], false, $_POST['page'], 12);
}
if(count($members) == 0)
{
  ?>
  No results.
  <?php
  if($_POST['page'] != "1")
  {
    ?>
    <div class="col-1-1">
      <button style="float: left; width: auto;" id="previousPage" class="shop-search-button"><i class="fas fa-chevron-left"></i></button>
      <script>
      $(document).ready(function(){
        curPage = <?=$_POST['page']?>;
        function load(page) {
          $.post("/community/fetch.php", {
            "page": curPage,
            "type": $("#member-tags").find(":selected").attr("showType"),
            "num": $("#member-tags").find(":selected").attr("num"),
            "cid": <?=$community->id?>
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
          console.log(curPage);
        });
        $("#previousPage").click(function(){
          curPage = curPage - 1;
          load(curPage);
          console.log(curPage);
        });
      });
      </script>

    </div>
    <?php
  }
  die();
}
foreach($members as $member)
{
  $user = $bop->get_user($member['uid']);
  $avatar = $bop->avatar($user->id);
  $memberRow = $com->getMember($community->id, $user->id);
  $getTag = $bop->look_for("community_member_tags", ["cid" => $community->id, "num" => $memberRow->tag]);
  ?>
  <div class="col-2-12 centered" style="padding-right:0px;">
    <a style="color:black;" href="/profile/<?=$user->id?>">
      <img src="https://storage.bopimo.com/avatars/<?=$avatar->cache?>.png" style="width:100%;">
      <?=htmlentities($user->username)?>
      <br>
    </a>
    <select style="width:80%;margin-left:20%;" uid="<?=$user->id?>" class="updateUserTag">
      <option><?=htmlentities($getTag->name)?></option>
      <?php
      $tagsS = $com->tags($community->id);
      foreach($tagsS["members"] as $t)
      {
        if($getTag->num != $t['num'])
        {
          ?>
          <option num="<?=$t['id']?>"><?=htmlentities($t['name'])?></option>
          <?php
        }
      }
      if($community->postable == "0")
      {
        foreach($tagsS["posters"] as $t)
        {
          if($getTag->num != $t['num'])
          {
            ?>
            <option num="<?=$t['id']?>"><?=htmlentities($t['name'])?></option>
            <?php
          }
        }
      }
      foreach($tagsS["administrators"] as $t)
      {
        if($getTag->num != $t['num'])
        {
          ?>
          <option num="<?=$t['id']?>"><?=htmlentities($t['name'])?></option>
          <?php
        }
      }
      ?>
    </select>
  </div>
  <?php
}
?>
<div class="col-1-1">
  <?php
  if(intval($_POST['page']) > 1)
  {
    ?>
    <button style="float: left; width: auto;" id="previousPage" class="shop-search-button"><i class="fas fa-chevron-left"></i></button>
    <?php
  }
  if(count($members) == 12)
  {
    ?>
    <button style="float: right; width: auto;" id="nextPage" class="shop-search-button"><i class="fas fa-chevron-right"></i></button>
    <?php
  }
  ?>
</div>
<script>
$(document).ready(function(){
  curPage = <?=$_POST['page']?>;
  function load(page) {
    $.post("/community/fetchSettings.php", {
      "page": curPage,
      "type": $("#member-tags").find(":selected").attr("showType"),
      "num": $("#member-tags").find(":selected").attr("num"),
      "cid": <?=$community->id?>
    }, function(reply){
      $("#replace").html(reply);
    });
  }
  $(".updateUserTag").change(function(){
    var selected = $(this).find(":selected");
    console.log($(this).attr("uid")+" "+selected.attr("num"));
    $.post("/community/js/updateMember.php",
      {
        "uid": $(this).attr("uid"),
        "num": selected.attr("num")
      }, function(reply){
        location.reload();
      });
  });
  $("#nextPage").click(function(){
    curPage = curPage + 1;
    load(curPage);
    console.log(curPage);
  });
  $("#previousPage").click(function(){
    curPage = curPage - 1;
    load(curPage);
    console.log(curPage);
  });
});
</script>
