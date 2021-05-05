<?php
	require('../../SiT_3/config.php');
	if (isset($_GET['id'])) {
		$game_id = mysqli_real_escape_string($conn,$_GET['id']);
		
		$dataSQL = "SELECT * from `game_data` WHERE `game_id`='$game_id'";
		$data = mysqli_query($conn,$dataSQL);
		$dataRow = mysqli_fetch_assoc($data);
		
		echo $dataRow['type'];
		echo "\nDATA\n";
		echo $dataRow['data'];
	}
?>