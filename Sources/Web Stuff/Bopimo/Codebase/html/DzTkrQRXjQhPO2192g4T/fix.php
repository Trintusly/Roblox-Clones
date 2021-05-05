<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/api/shop/shop.php");
$rows = $bop->query("SELECT DISTINCT(payment_logs.user) FROM payment_logs", [], true);
$i = 0;
foreach($rows as $row) {
  $i++;
  $item = $bop->look_for("inventory", ["user_id" => $row['user'], "item_id" => "1034"]);
  if($item == false){
  $bop->insert("inventory", [
    "item_id" => "1034",
    "user_id" => $row['user'],
    "price" => "0",
    "from_id" => "3",
    "serial" => $i,
    "own" => "1",
    "equipped" => "0",
    "type" => "hat"
  ]);
  echo "done to: {$row['user']} <br>";
  } else {echo "exists {$row['user']} <br>";}
}
?>

