<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'blender.php';

$blender = new blender;

$obj = "/var/www/html/assets/hats/gay.obj";
$tex = "/var/www/html/assets/hats/gay.png";
$gay3 = "/var/www/html/assets/hats/gay" . rand(0,1000);
unlink($gay3 . ".py");
$actuallyGay = $blender->renderHat ($obj, $tex, $gay3);
