<?php 

include('../../SiT_3/config.php');

//Get the url query "UID"
$UID = $_GET['UID'];

if(strlen($UID) > 30) {
	// If the user ID length is over 30 automatically reject it
	die('Invalid UID');
}

if(!ctype_alnum($UID)) {
	// If UID is not alphanumeric automatically reject it
	die('Invalid UID');
}

//Make UID Safe for SQL
$UID = mysqli_real_escape_string($conn, $UID);

$findUserSQL = "SELECT * FROM `beta_users` WHERE `unique_key` = '$UID'";
$findUser = $conn->query($findUserSQL);

if($findUser->num_rows > 0) {
	
	$userRow = (object) $findUser->fetch_assoc();
	echo $userRow->{'id'};
	
} else {
	die('Invalid UID');
}

?>