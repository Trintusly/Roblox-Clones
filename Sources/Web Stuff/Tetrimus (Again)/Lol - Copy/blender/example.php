<?php 

include 'blender.php';
$blender = new blender;

$avatar = $blender->renderAvatar([ "Head" => [255,0,0] ],[],["filename" => "/var/www/html/assets/avatar/kek.png"]);
?>