<?php 
	include('../../SiT_3/config.php');
	if (isset($_GET['id'])) {
		$UserID = mysqli_real_escape_string($conn, intval($_GET['id']));
		$findUserSQL = "SELECT * FROM `beta_users` WHERE `id` = '$UserID'";
		$findUser = $conn->query($findUserSQL);
		
		$my_file = 'file.txt';
		$handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
		$data = $UserID;
		fwrite($handle, $data);
		
		$userRow = (object) $findUser->fetch_assoc();
		$username = $userRow->{'username'};
		
		echo $username;
	}
?>