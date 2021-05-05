<?php
require("/var/www/html/site/bopimo.php");
if($bop->logged_in())
{
  die(header("location: /home"));
}
$pageName = "Landing";
/*
require("/var/www/html/site/header.php");


$players = $bop->query("SELECT COUNT(*) FROM users", [])->fetchColumn();
$randPlayers = $bop->query("SELECT * FROM users WHERE hidden=0 AND lastseen > 0 ORDER BY RAND() LIMIT 0, 5", [], true);

$items = $bop->query("SELECT COUNT(*) FROM items", [])->fetchColumn();
$randItems = $bop->query("SELECT * FROM items WHERE verified=1 ORDER BY RAND() LIMIT 0, 5", [], true);

$communities = $bop->query("SELECT COUNT(*) FROM community", [])->fetchColumn();
$randCommunities = $bop->query("SELECT * FROM community WHERE pending=1 ORDER BY members DESC LIMIT 0, 5", [], true);
?>
<meta charset="UTF-8">
<meta property="og:site_name" content="bopimo.com">
<meta property="og:image" content="https://www.bopimo.com/css/logo-small.png">
<meta name="description" content="Welcome to Bopimo, the free community-based sandbox game. Sign up and play today!">
<meta name="keywords" content="Bopimo, Bopimo thread, Bopimo Game">
<meta name="author" content="Bopimo">
<div class="content">
  <div class="page-title">Welcome to Bopimo, the free community-based sandbox.</div>
  <div class="col-1-1">
    <div class="card border">
      <div class="col-2-12 centered" style="border-right:solid 2px #B5B5B5;height:200px;">
        <br><br>
        <div class="page-title">
          <u>Users</u>
        </div>
        <span style="font-size:25px;"><?=$players?></span>
      </div>
      <?php
      foreach($randPlayers as $user)
      {
        $avatar = $bop->avatar($user['id']);
        ?>
        <div class="col-2-12 centered" style="padding-right:0px;">
          <a href="/profile/<?=$user['id']?>" style="color:black;">
            <object data="https://storage.bopimo.com/avatars/<?=$avatar->cache?>.png"  class="image" type="image/png">
              <img class="image" src="https://storage.bopimo.com/avatars/Wn8dCwts4fTE7NrhBmayXluHR.png">
            </object>
            <?=htmlentities($user['username'])?>
          </a>
        </div>
        <?php
      }
      ?>
    </div>
  </div>

  <div class="col-1-1">
    <div class="card border">
      <?php
      foreach($randItems as $item)
      {
        ?>
        <div class="col-2-12 centered" style="padding-right:0px;">
          <a href="/item/<?=$item['id']?>" style="color:black;">
            <object data="https://storage.bopimo.com/thumbnails/<?=$item['id']?>.png"  class="image" type="image/png">
              <img class="image" src="https://storage.bopimo.com/thumbnails/declined.png">
            </object>
            <span style="text-overflow:ellipsis"><?=substr(htmlentities($item['name']), 0, 14)?></span>
          </a>
        </div>
        <?php
      }
      ?>
      <div class="col-2-12 centered" style="border-left:solid 2px #B5B5B5;height:200px;">
        <br><br>
        <div class="page-title">
          <u>Items</u>
        </div>
        <span style="font-size:25px;"><?=$items?></span>
      </div>
    </div>
  </div>

  <div class="col-1-1">
    <div class="card border">
      <div class="col-2-12 centered" style="border-right:solid 2px #B5B5B5;height:200px;">
        <br><br>
        <div class="page-title">
          <u>Communities</u>
        </div>
        <span style="font-size:25px;"><?=$communities?></span>
      </div>
      <?php
      foreach($randCommunities as $community)
      {
        ?>
        <div class="col-2-12 centered" style="padding-right:0px;">
          <a href="/community/view/<?=$community['id']?>" style="color:black;">
            <object data="https://storage.bopimo.com/community/<?=$community['cache']?>.png"  class="image" type="image/png">
              <img class="image" src="https://storage.bopimo.com/thumbnails/declined.png">
            </object>
            <span style="text-overflow:ellipsis"><?=substr(htmlentities($community['name']), 0, 14)?></span>
          </a>
        </div>
        <?php
      }
      ?>
    </div>
  </div>
  <div class="page-title">
    What is Bopimo?
  </div>
  <div class="card border">
    Bopimo is a free, community-based sandbox game that strives to allow as much freedom as possible. Right now, the website has:
    <ul>
      <li>User Registration, Login</li>
      <li>Established Economy</li>
      <li>Items</li>
      <li>Community</li>
      <li>Forums</li>
      <li>Avatar Customization</li>
      <li>Friend System</li>
      <li>Fun</li>
    </ul>
    Join now for free!
  </div>
</div>
<?php */
include("index3.php");
?>
