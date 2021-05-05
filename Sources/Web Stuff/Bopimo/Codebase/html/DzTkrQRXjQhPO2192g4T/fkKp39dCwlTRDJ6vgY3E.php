<?php
//https://www.bopimo.com/DzTkrQRXjQhPO2192g4T/fkKp39dCwlTRDJ6vgY3E.php


require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/shop/shop.php");

if(!$bop->logged_in())
{
  die(header("location: /"));
}

$user = $bop->local_info(["id", "bop"]);

if(!is_numeric($_GET['a']))
{
  die(header("location: /"));
}

$amount = $_GET['a'];

$bop->update_("users", ["bop" => $amount + intval($user->bop)], ["id" => $user->id]);
$bop->insert("payment_logs", [
  "user" => $user->id,
  "amount" => $amount,
  "time" => time()
]);
$inv = $bop->look_for("inventory", ["user_id" => $user->id, "item_id" => 1034]);
if(!$inv)
{
  $bop->insert("inventory", [
    "item_id" => 1034,
    "user_id" => $user->id,
    "price" => 0,
    "from_id" => 3,
    "serial" => 0,
    "own" => 1,
  ]);
}
die(header("location: /membership/?succ"));
?>
