<?php
require("/var/www/html/site/bopimo.php");

if(!$bop->loggedIn())
{
  die("bad");
}

$request = $_GET['req'];

$requests = array(
  "hat" => 1,
  "face" => 3,
  "shirt" => 4,
  "pants" => 5,
  "tshirt" => 6,
  "tool" => 2
);

if(!isset($requests[$request]))
{
  die();
}

$user = $bop->local_info();
$avatar = $bop->avatar($user->id);
$inventory = $bop->query("SELECT inventory.id, inventory.item_id FROM inventory INNER JOIN items ON items.id = inventory.item_id WHERE items.category=? AND inventory.equipped=0 AND inventory.user_id=?", [$requests[$request], $user->id], false);
if($inventory->rowCount() == 0)
{
  ?>
  <center><h2>No Results</h2></center>
  <?php
  die();
}
foreach($inventory->fetchAll()[0] as $i)
{
  $i = (object) $i;
  $shop = $bop->look_for("items", ["id" => $i->item_id]);
  ?>
  <div class="col-2-12">
    <div class="image-cont far-left-rad far-right-rad" style="width:100%;">
      <div class="image">
        <img src="https://storage.bopimo.com/thumbnails/<?=$shop->id?>.png" height="25" class="image">
        <span class="equip" data-1="<?=$i->id?>"></span>
      </div>
      <div class="text">
        <a href="/item/<?=$shop->id?>">
          <?=htmlentities($shop->name)?>
        </a>
      </div>
    </div>
  </div>
  <?php
}
?>

<script>
$(document).ready(function(){
  $(".equip").click(function(){
    $.post("equipUn.php", {req: $(this).attr("data-1"), req2: "equip"}, function(reply){
      $("#content-1").load("load-equipped.php");
  		$("#content-3").load("fetch_inventory.php?req="+$(".current").attr("data-category"));
      $("#avr").html("<img src='/css/loading.gif' class='image'>");
  		$("#avr").load("render.php");
    });
  });
});
</script>
