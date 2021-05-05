<? include "../../header.php";
$id = $_GET['id'];
$item = $handler->query("SELECT * FROM items WHERE id=" . $_GET['id']);
$gI = $item->fetch(PDO::FETCH_OBJ);
$handler->query("UPDATE `users` SET `$gI->type`='$gI->wearable' WHERE `id`='$myu->id'");
?>
<head><meta http-equiv="refresh" content="1; url=/Customize/"></head>