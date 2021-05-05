<?php
// Set the content-type
header('Content-type: image/png');

function genKey() {
	return rand(1,9) . rand(10000,99999) . range(1,9);
}

$key = $_GET['key'];
$im = imagecreatefrompng($image);
$white = imagecolorallocate($im, 255, 255, 255);
$font = 'FSEX300.ttf';
//$key = substr(hash('sha256', genKey()), 0, 10);
imagettftext($im, 20, 0, 140, 195, $white, $font, $key);

imagepng($im);
imagedestroy($im);
?>