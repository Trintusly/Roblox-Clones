<?php 
include('../../SiT_3/config.php');

$PlaceID = mysqli_real_escape_string($conn, intval($_GET['ID']));
$findPlaceSQL = "SELECT * FROM `games` WHERE `id` = $PlaceID";
$findPlace = $conn->query($findPlaceSQL);

if ($findPlace->num_rows > 0) {
	echo 'True';
} elseif ($findPlace->num_rows == 0) {
	echo 'False';
}

?>