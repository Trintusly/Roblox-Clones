<?php 
	include('../../SiT_3/config.php');
	
	if (isset($_GET['id'])) {
		$UserKey = mysqli_real_escape_string($conn, $_GET['id']);
		$findUserSQL = "SELECT * FROM `beta_users` WHERE `unique_key` = '$UserKey'";
		$findUser = $conn->query($findUserSQL);
		if ($findUser->num_rows > 0) {
			$userRow = (object) $findUser->fetch_assoc();
			$userID = $userRow->{'id'};
			echo $userID;
		} else {
			echo 'error';
		}
		
	}
?>