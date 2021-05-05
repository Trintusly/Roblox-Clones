<?php
if(!isset($_POST['desc']) || !isset($_POST['cid']))
{
  die("4");
}
if(!is_numeric($_POST['cid']))
{
  die("3");
}
$cid = (int) $_POST['cid'];
require("/var/www/html/api/community/class.php");
$community = $com->get($cid);
if(is_bool($community))
{
  die("2");
}
if($community->open == "1")
{
  die("1");
}
$getLike = $bop->query("SELECT DISTINCT(community_join_requests.id), community_join_requests.uid, community_join_requests.cid, community_join_requests.time, users.username FROM community_join_requests INNER JOIN users ON community_join_requests.uid = users.id WHERE users.username LIKE ? AND cid=? LIMIT 0, 12", ["%".$_POST['desc']."%", $cid], true);
if(count($getLike) == 0)
{
  die("No results.");
}
foreach($getLike as $row)
{
  $avatar = $bop->avatar($row['uid']);
  ?>
  <div class="col-3-12 centered" style="padding:0px;font-size:15px;">
    <img src="https://storage.bopimo.com/avatars/<?=$avatar->cache?>.png" class="image">
    <?=htmlentities($row['username'])?>
    <br>
    <span style="font-size:30px;">
      <a href="#" class="declineMember" pid="<?=$row['id']?>"><font color='red'><i class="fas fa-times"></i></font></a>
      <a href="#" class="approveMember" pid="<?=$row['id']?>"><font color="green"><i class="fas fa-check"></i></font></a>
    </span>
  </div>
  <?php
}
?>
<script src="/community/js/approvedecline.js"></script>
