<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
if(!isset($_GET['id']))
{
  $player['err'] = true;
  die(json_encode($player));
}
if(!is_numeric($_GET['id']))
{
  $player['err'] = true;
  die(json_encode($player));
}

$id = (int) $_GET['id'];
require("/var/www/html/site/bopimo.php");
$user = $bop->get_user($id);
if(!$user)
{
  $player['err'] = true;
  die(json_encode($player));
}
$avatar = $bop->avatar($id);
$info = array(
  "id" => $user->id,
  "username" => $user->username
);
$colors = array(
  "head" => $avatar->head_color,
  "torso" => $avatar->torso_color,
  "leftArm" => $avatar->left_arm_color,
  "rightArm" => $avatar->right_arm_color,
  "leftLeg" => $avatar->left_leg_color,
  "rightLeg" => $avatar->right_leg_color
);
$items = array(
  "hats" => [
    "hat1" => false,
    "hat2" => false,
    "hat3" => false
  ],
  "tool" => false,
  "tshirt" => false,
  "shirt" => false,
  "pants" => false,
  "face" => 0
);
if($avatar->hat1 != "0")
{
  $items['hats']['hat1'] = [
    'obj' => "https://storage.bopimo.com/assets/hats/{$avatar->hat1}.obj",
    'tex' => "https://storage.bopimo.com/assets/hats/{$avatar->hat1}.png"
  ];
}
if($avatar->hat2 != "0")
{
  $items['hats']['hat2'] = [
    'obj' => "https://storage.bopimo.com/assets/hats/{$avatar->hat2}.obj",
    'tex' => "https://storage.bopimo.com/assets/hats/{$avatar->hat2}.png"
  ];
}
if($avatar->hat3 != "0")
{
  $items['hats']['hat3'] = [
    'obj' => "https://storage.bopimo.com/assets/hats/{$avatar->hat3}.obj",
    'tex' => "https://storage.bopimo.com/assets/hats/{$avatar->hat3}.png"
  ];
}
if($avatar->tool != "0")
{
  $items['tool'] = [
    'obj' => "https://storage.bopimo.com/assets/tools/{$avatar->tool}.obj",
    'tex' => "https://storage.bopimo.com/assets/tools/{$avatar->tool}.png"
  ];
}

if($avatar->shirt != "0")
{
  $items['shirt'] = "https://storage.bopimo.com/assets/shirts/{$avatar->shirt}.png";
}

if($avatar->tshirt != "0")
{
  $items['tshirt'] = "https://storage.bopimo.com/assets/tshirts/{$avatar->tshirt}.png";
}

if($avatar->pants != "0")
{
  $items['pants'] = "https://storage.bopimo.com/assets/pants/{$avatar->pants}.png";
}


if($avatar->face != "0")
{
  $items['face'] = "https://storage.bopimo.com/assets/faces/{$avatar->face}.png";
}

$player = array(
  "info" => $info,
  "colors" => $colors,
  "items" => $items
);

die(json_encode($player));
?>
