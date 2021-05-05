<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("/var/www/html/site/bopimo.php");

if(!$bop->loggedIn())
{
  die("bad request (#1)");
}

if(!isset($_POST['req']) || !is_numeric($_POST['req']))
{
  die();
}

$allowedRequests = array("equip", "unequip");

if(!isset($_POST['req2']))
{
  die();
}

$request1 = $_POST['req2'];

if(!in_array($request1, $allowedRequests))
{
  die();
}

$reBind = array(
  "1" => "hat1",
  "2" => "hat2",
  "3" => "hat3",
  "4" => "tool",
  "5" => "face",
  "6" => "tshirt",
  "7" => "shirt",
  "8" => "pants"
);

$rebindTrue = array( //goes with isaiah's gay for avatar
  "hat" => 1,
  "face" => 3,
  "shirt" => 4,
  "pants" => 5,
  "tshirt" => 6,
  "tool" => 2
);

$rebind2 = array(
  "1" => "hat",
  "2" => "hat",
  "3" => "hat",
  "4" => "tool",
  "5" => "face",
  "6" => "tshirt",
  "7" => "shirt",
  "8" => "pants"
);
if($request1 == "equip")
{
  $invId = $_POST['req'];
  $user = $bop->local_info();
  $avatar = $bop->avatar($user->id);
  $inventory = $bop->look_for("inventory", ["id" => $invId]);


  if(!$inventory)
  {
    die("no inventory");
  }

  if($inventory->equipped != 0)
  {
    die();
  }

  require("/var/www/html/api/shop/shop.php");

  $shop = $bop->look_for("items", ["id" => $inventory->item_id]);
  switch($shop->category)
  {
    case "1":
      if($avatar->hat1 == 0)
      {
        $chosen = "hat1";
      } elseif($avatar->hat2 == 0) {
        $chosen = "hat2";
      } elseif($avatar->hat3 == 0) {
        $chosen = "hat3";
      }
      if(!isset($chosen))
      {
        $updatePrev = $bop->update_("inventory", ["equipped" => "0"], [
          "user_id" => $user->id,
          "item_id" => $avatar->hat1,
          "equipped" => "1"
        ]);
        $chosen = "hat1";
      }
      $bop->update_("avatar", [$chosen => $inventory->item_id], ["id" => $avatar->id]);
      $bop->update_("inventory", ["equipped" => "1"], ["id" => $inventory->id]);
      break;

      case "2":
      case "3":
      case "4":
      case "5":
      case "6":
      if($avatar->{$chosen} != 0)
      {
        $updatePrev = $bop->update_("inventory", ["equipped" => "0"], [
          "user_id" => $user->id,
          "item_id" => $avatar->{$chosen},
          "equipped" => "1"
        ]);
      }
      $bop->update_("avatar", [$chosen => $shop->id], ["user_id" => $user->id]);
      $bop->update_("inventory", ["equipped" => "1"], ["id" => $inventory->id]);
      break;
  }
} elseif($request1 == "unequip") {
  $user = $bop->local_info();
  $avatar = (array) $bop->avatar($user->id);
  if(!isset($reBind[$_POST['req']]))
  {
    die();
  }

  $column = $reBind[$_POST['req']];

  $cur = $avatar[$column];
  $bop->update_("inventory", ["equipped" => "0"], [
    "equipped" => 1,
    "item_id" => $cur
  ]);
  $bop->update_("avatar", [$column => "0"], ["id" => $avatar['id']]);
}
?>
