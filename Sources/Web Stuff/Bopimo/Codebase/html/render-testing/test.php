<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("render-class.php");

$blender = new blender;

$img = $blender->renderAvatar(1);

echo "<textarea>{$blender->curPY()}</textarea>";
?>
<img src="http://storage.bopimo.com/avatars/<?=$img?>">