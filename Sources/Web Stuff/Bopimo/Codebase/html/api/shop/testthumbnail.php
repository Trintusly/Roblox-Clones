<?php 
require("shop.php");

$id = 1;
$category = 6;
$filename = 1;
$shopRender->renderItem($id, $category);
var_dump($shopRender->export("/var/www/storage/thumbnails/" . $filename, 512, "", ""));
$render = file_get_contents("/var/www/storage/thumbnails/" . $filename . ".png");
?><br>
<img src="https://storage.bopimo.com/thumbnails/<?=$filename?>.png" />
<?php 
//unlink("/var/www/storage/thumbnails/" . $filename . ".png");
?>