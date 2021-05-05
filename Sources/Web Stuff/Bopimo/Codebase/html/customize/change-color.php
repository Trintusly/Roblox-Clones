<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("/var/www/html/site/bopimo.php");

if(!$bop->logged_in())
{
	die("not logged in");
}

if($bop->antiJake($_POST['part']) || $bop->antiJake($_POST['color']))
{
	die("die evil jake");
}

$parts = ["head_color", "torso_color", "right_arm_color", "left_arm_color", "right_leg_color", "left_leg_color"];

$OldColors = array(
	"#F9EBEA",
	"#F4ECF7",
	"#EBF5FB",
	"#E8F6F3",
	"#EAFAF1",
	"#FEF5E7",
	"#FBEEE6",
	"#FDFEFE",
	"#EAECEE",
	"#CD6155",
	"#A569BD",
	"#85C1E9",
	"#73C6B6",
	"#82E0AA",
	"#F8C471",
	"#E59866",
	"#F4F6F7",
	"#808B96",
	"#A93226",
	"#7D3C98",
	"#2E86C1",
	"#138D75",
	"#28B463",
	"#D68910",
	"#BA4A00",
	"#D0D3D4",
	"#273746"
);

$colors = [
"FD0D00", "FF4C01", "FFFF01","26FC06","00FFE7","0014FF","FF00D9","FD5043",
"FF7E47","FFFF47","5FFF47","47FEF0","4657FF","FF48E1","FFB5B6","FFC8B4","FFFAB5","C3FFB5","B6FFF4","B1C2FF","rainbow"];

foreach ($colors as &$color) {
	$color = "#" . $color;
}

$part = $_POST['part'];
$color = $_POST['color'];

if(empty($color) || empty($part))
{
	die("bad request d");
}

if(!in_array($color, $colors) || !in_array($part, $parts))
{
	die("bad request");
}
$color = ltrim($color, "#");
$bop->update_("avatar", [
	$part => $color
], [
	"user_id" => $_SESSION['id']
]);

$render = new blender;
$render->renderAvatar($_SESSION['id']);
?>
