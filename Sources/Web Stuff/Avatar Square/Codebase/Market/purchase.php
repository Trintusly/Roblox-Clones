<? include "../header.php";
if ($user){
$money=$myu->emeralds;
$id=$_GET['id'];
$item = $handler->query("SELECT * FROM items WHERE id=" . $id);
$gB = $item->fetch(PDO::FETCH_OBJ);
$amount=$gB->amount;
if ($gB->onsale == 1){

if ($money >= $gB->price){

if ($gB->collectable != "true"){
if ($amount != 0){
$new = ($money - $gB->price);
$handler->query("UPDATE `users` SET `emeralds`='$new' WHERE `id`='$myu->id'");
$handler->query("INSERT INTO inventory (item,user) VALUES ($id,$myu->id)");
}
} else {

if ($amount >= 1){
$amount1=($amount - 1);
$new = ($money - $gB->price);
$handler->query("UPDATE `users` SET `emeralds`='$new' WHERE `id`='$myu->id'");
$handler->query("UPDATE `items` SET `amount`='$amount1' WHERE `id`='$gB->id'");
$handler->query("INSERT INTO inventory (item,user) VALUES ($id,$myu->id)");

} else {
?> <center><h2>Item is sold out!</h2></center> <?
}

}

}

} else {
?> <center><h2>Item not on sale!</h2></center> <?
}
}
?>

<head><meta http-equiv="refresh" content="1; url=/Customize/"></head>