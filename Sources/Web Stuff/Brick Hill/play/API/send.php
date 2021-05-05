<?php
	require('../../SiT_3/config.php');
	if (isset($_GET['id'])) {
		$game_id = mysqli_real_escape_string($conn,$_GET['id']);
		
		$dataSQL = "UPDATE `game_data` WHERE `game_id`='$game_id' SET `type`='1'";
		$data = mysqli_query($conn,$dataSQL);
	}
?>