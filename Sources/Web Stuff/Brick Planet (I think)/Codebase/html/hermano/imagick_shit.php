<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");

	$bg = new Imagick();
	$bg->newImage(1280, 1280, new ImagickPixel('transparent'));
	$bg->setImageFormat('png32');
	
	$GetUser = $db->prepare("SELECT AvatarURL FROM User WHERE User.ID IN (174,10,100369,88571,100834,21397,55483,35023,33712,91893,36081,66117,123953,35311,94459,38357,34199,2843,34203,80565,47940,34192,101503,33409,39614,56148,40910,73753,58603,77611,68930,17263,125003,5995,47558,100254,51305,2925,106492,36683,5228,34205,30163,78949,42635,71870,61989,86341,574,60198,55910,33606,2799,61987,51067,34262,106836,78543,46250,11989,61992,1973,60601,104623,23642,102269,43221,73659,68813,78187,61986,46798,40778,95166,35571,7350,55881,83185,38415,108212,80429,1991,609,36187,98048,2759,85513,68465,70127,754,98554,70904,5553,89095,56554,107675,36863,8309,13673,83159)");
	$GetUser->execute();
	$x = 0;
	$xI = 0;
	$y = 0;
	
	while ($gU = $GetUser->fetch(PDO::FETCH_OBJ)) {
		if ($xI == 10) { $y += 128; $x = 0; $xI = 0; }
		file_put_contents('/tmp/overlay.png', file_get_contents('https://cdn.brickcreate.com/'.$gU->AvatarURL.'-thumb.png'));
		$bg->compositeImage(new Imagick('/tmp/overlay.png'), Imagick::COMPOSITE_DEFAULT, $x, $y);
		$x += 128;
		$xI++;
	}
	
	header('Content-Type: image/png');
	echo $bg;
	
	//$bg->destroy();
	//$overlay->destroy();