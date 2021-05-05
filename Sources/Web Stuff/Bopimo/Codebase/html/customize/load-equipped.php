<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  require("/var/www/html/error/404.php");
  die();
}

$user = $bop->local_info();

$avatar = $bop->avatar($user->id);
$hatString1;
$hatString2;
$hatString3;

//Hat 1
if($avatar->hat1 != 0)
{
  $shop1 = $bop->look_for("items", ["id" => $avatar->hat1]);
  $hatString1 = "<a href='/item/{$shop1->id}'>" . htmlentities($shop1->name) . "</a>";
  $hatImg1 = "https://storage.bopimo.com/thumbnails/{$shop1->id}.png";
} else {
  $hatImg1 = "/css/logo-small.png";
  $hatString1 = "Empty Slot";
}

//Hat 2
if($avatar->hat2 != 0)
{
  $shop2 = $bop->look_for("items", ["id" => $avatar->hat2]);
  $hatString2 = "<a href='/item/{$shop2->id}'>" . htmlentities($shop2->name) . "</a>";
  $hatImg2 = "https://storage.bopimo.com/thumbnails/{$shop2->id}.png";
} else {
  $hatImg2 = "/css/logo-small.png";
  $hatString2 = "Empty Slot";
}

//Hat 3
if($avatar->hat3 != 0)
{
  $shop3 = $bop->look_for("items", ["id" => $avatar->hat3]);
  $hatString3 = "<a href='/item/{$shop3->id}'>" . htmlentities($shop3->name) . "</a>";
  $hatImg3 = "https://storage.bopimo.com/thumbnails/{$shop3->id}.png";
} else {
  $hatImg3 = "/css/logo-small.png";
  $hatString3 = "Empty Slot";
}

if($avatar->tshirt != 0)
{
  $shopT = $bop->look_for("items", ["id" => $avatar->tshirt]);
  $tshirtString = "<a href='/item/{$shopT->id}'>" . htmlentities($shopT->name) . "</a>";
  $tshirtImg = "https://storage.bopimo.com/thumbnails/{$shopT->id}.png";
} else {
  $tshirtImg = "/css/logo-small.png";
  $tshirtString = "Empty Slot";
}

if($avatar->shirt != 0)
{
  $shopT = $bop->look_for("items", ["id" => $avatar->shirt]);
  $shirtString = "<a href='/item/{$shopT->id}'>" . htmlentities($shopT->name) . "</a>";
  $shirtImg = "https://storage.bopimo.com/thumbnails/{$shopT->id}.png";
} else {
  $shirtImg = "/css/logo-small.png";
  $shirtString = "Empty Slot";
}

if($avatar->pants != 0)
{
  $shopT = $bop->look_for("items", ["id" => $avatar->pants]);
  $pantsString = "<a href='/item/{$shopT->id}'>" . htmlentities($shopT->name) . "</a>";
  $pantsImg = "https://storage.bopimo.com/thumbnails/{$shopT->id}.png";
} else {
  $pantsImg = "/css/logo-small.png";
  $pantsString = "Empty Slot";
}

if($avatar->tool != 0)
{
  $shopT = $bop->look_for("items", ["id" => $avatar->tool]);
  $toolString = "<a href='/item/{$shopT->id}'>" . htmlentities($shopT->name) . "</a>";
  $toolImg = "https://storage.bopimo.com/thumbnails/{$shopT->id}.png";
} else {
  $toolImg = "/css/logo-small.png";
  $toolString = "Empty Slot";
}
?>


<div class="image-cont far-left-rad">
  <div class="top">Hat</div>
  <div class="image">
    <img src="<?=$hatImg1?>" height="25" class="image">
    <?php
    if($hatString1 !== "Empty Slot")
    {
      ?>
      <span class="equipped" data-1="1"></span>
      <?php
    }
    ?>
  </div>
  <div class="text"><?=$hatString1?></div>
</div>
<div class="image-cont">
  <div class="top">Hat</div>
  <div class="image">
    <img src="<?=$hatImg2?>" height="25" class="image">
    <?php
    if($hatString2 !== "Empty Slot")
    {
      ?>
      <span class="equipped" data-1="2"></span>
      <?php
    }
    ?>
  </div>
  <div class="text"><?=$hatString2?></div>
</div>
<div class="image-cont">
  <div class="top">Hat</div>
  <div class="image">
    <img src="<?=$hatImg3?>" height="25" class="image">
    <?php
    if($hatString3 !== "Empty Slot")
    {
      ?>
      <span class="equipped" data-1="3"></span>
      <?php
    }
    ?>
  </div>
  <div class="text"><?=$hatString3?></div>
</div>
<div class="image-cont far-right-rad">
  <div class="top">Tool</div>
  <div class="image">
    <img src="<?=$toolImg?>" height="25" class="image">
    <?php
    if($avatar->tool !== "0")
    {
      ?>
      <span class="equipped" data-1="4"></span>
      <?php
    }
    ?>
  </div>
  <div class="text"><?=$toolString?></div>
</div>
<div class="image-cont far-left-rad">
  <div class="top">Face</div>
  <div class="image">
    <img src="/css/logo-small.png" height="25" class="image">
    <?php
    if($avatar->face !== "0")
    {
      ?>
      <span class="equipped" data-1="5"></span>
      <?php
    }
    ?>
  </div>
  <div class="text">Empty Slot</div>
</div>
<div class="image-cont">
  <div class="top">T-Shirt</div>
  <div class="image">
    <img src="<?=$tshirtImg?>" height="25" class="image">
    <?php
    if($avatar->tshirt !== "0")
    {
      ?>
      <span class="equipped" data-1="6"></span>
      <?php
    }
    ?>
  </div>
  <div class="text"><?=$tshirtString?></div>
</div>
<div class="image-cont">
  <div class="top">Shirt</div>
  <div class="image">
    <img src="<?=$shirtImg?>" height="25" class="image">
    <?php
    if($avatar->shirt !== "0")
    {
      ?>
      <span class="equipped" data-1="7"></span>
      <?php
    }
    ?>
  </div>
  <div class="text"><?=$shirtString?></div>
</div>
<div class="image-cont far-right-rad">
  <div class="top">Pants</div>
  <div class="image">
    <img src="<?=$pantsImg?>" height="25" class="image">
    <?php
    if($avatar->pants !== "0")
    {
      ?>
      <span class="equipped" data-1="8"></span>
      <?php
    }
    ?>
  </div>
  <div class="text"><?=$pantsString?></div>
</div>

<script>
$(document).ready(function(){
  $(".equipped").click(function(){
    $.post("equipUn.php", {req: $(this).attr("data-1"), req2: "unequip"}, function(reply){
      $("#content-1").load("load-equipped.php");
  		$("#content-3").load("fetch_inventory.php?req="+$(".current").attr("data-category"));
      $("#avr").html("<img src='/css/loading.gif' class='image'>");
  		$("#avr").load("render.php");
    });
  });
});
</script>
