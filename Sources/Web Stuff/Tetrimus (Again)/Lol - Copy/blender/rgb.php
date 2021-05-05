<?php 

include "/var/www/html/site/connection.php";

function displayRgb ($rgb) {
	return "rgb(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . ")";
}

function goodRgb ($rgb) {
	return $rgb[0] . "." . $rgb[1] . "." . $rgb[2];
}

$rgb = [rand(0,255), rand(0,255), rand(0,255)];

$rgbDark = [];

foreach ($rgb as $val) {
	
	$val = $val - 55;
	if ($val <= 0) {
		$val = 0;
	}
	//echo $val;
	$rgbDark[] = $val;
}

$avatarQuery = "INSERT INTO avatar VALUES (?, '226.226.226', '".goodRgb($rgb)."', '226.226.226', '226.226.226','".goodRgb($rgbDark)."','".goodRgb($rgbDark)."',0,0,0)";

echo "<div style='padding: 10px;background-color: ".displayRgb($rgb)."'></div>";
echo "<div style='padding: 10px;background-color: ".displayRgb($rgbDark)."'></div>";
echo $avatarQuery;

?>