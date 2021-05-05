<?php
if(!isset($_GET['id']) || !isset($_GET['p']))
{
  require("/var/www/html/error/404.php");
  die();
}

if(!is_numeric($_GET['id']) || !is_numeric($_GET['p']))
{
  require("/var/www/html/error/404.php");
  die();
}
$uid = (int) $_GET['id'];
require("/var/www/html/site/bopimo.php");
if(!$bop->user_exists($uid))
{
  require("/var/www/html/error/404.php");
  die();
}
$user = $bop->get_user($uid);
$page = (int) $_GET['p'];
$limit = 18;
if($page == 1)
{
  $trueP = 0;
} else {
  $trueP = $page * $limit - $limit;
}
$sql = "LIMIT {$trueP}," . $limit;
require("/var/www/html/site/header.php");
$friends = $bop->query("SELECT DISTINCT(a.cache), a.user_id, u.username, f.id FROM `friends` as f, `avatar` as a, `users` as u WHERE ((f.to=? AND a.user_id=f.from) OR (f.from=? AND a.user_id=f.to)) AND f.status=1 AND u.id=a.user_id ORDER BY f.id ASC {$sql}", [$user->id, $user->id]);
?>
<div class="col-1-1">
  <a href="/profile/<?=$uid?>" style="color:#8973f9">
  	<i class="fas fa-chevron-left"></i> Return to profile
  </a>
</div>
<br><br>
<?php
if(!$friends)
{
  ?>
  <div class="banner danger">No Results</div>
  <?php
  die();
}
?>
<div class="col-1-1">
  <div class="card b">
    <div class="top"><?=htmlentities($user->username)?>'s Friends</div>
    <div class="body">
      <div class="col-1-1">
        <?php
        foreach($friends as $friend)
        {
          $friend = (object) $friend;
          ?>
          <div class="col-2-12 centered" style="padding-right:0;">
            <a style="color:black;" href="/profile/<?=$friend->user_id?>">
              <img src="https://storage.bopimo.com/avatars/<?=$friend->cache?>.png" style="width:100%;">
              <?=htmlentities($friend->username)?>
            </a>
          </div>
          <?php
        }
        ?>
      </div>
      <div class="col-1-1">

      </div>
    </div>
  </div>
</div>

<?php require("/var/www/html/site/footer.php"); ?>
