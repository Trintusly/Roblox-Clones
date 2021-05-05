<?php
header('Content-Type: application/json');
require('../../SiT_3/config.php');

$gameID = mysqli_real_escape_string($conn, intval($_GET['ID']));

$findGameSQL = "SELECT * FROM `games` WHERE `id` = '$gameID'";
$findGame = $conn->query($findGameSQL);

if ($findGame->num_rows > 0) {
	
	$thumbnail = array (
		"thumbnail" => "http://www.brick-hill.com/thumbnail.php"
	);
	
	$json = json_encode($thumbnail, JSON_PRETTY_PRINT);
	
	echo $json;
	
} else {
	
	$error = array (
		"error" => "invalid game"
	);
	
	$json = json_encode($error, JSON_PRETTY_PRINT);
	
	echo $json;
	
}
?>