<?php 
include('../../SiT_3/config.php');

$UserID = mysqli_real_escape_string($conn, $_GET['ID']);
$findUserSQL = "SELECT * FROM `beta_users` WHERE `id` = '$UserID'";
$findUser = $conn->query($findUserSQL);

if ($findUser->num_rows > 0) {
	echo 'True';
} elseif ($findUser->num_rows == 0) {
	echo 'False';
}

?>