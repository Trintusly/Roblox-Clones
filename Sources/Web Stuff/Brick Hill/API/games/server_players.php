<?php
	include('../../SiT_3/config.php');
	if(isset($_GET['players']) && isset($_GET['id'])) {
		$playing = mysqli_real_escape_string($conn,intval($_GET['players']));
		$gameID = mysqli_real_escape_string($conn,intval($_GET['id']));
		$pingSQL = "UPDATE `games` SET `playing`='$playing' WHERE `id`='$gameID'";
		$ping = $conn->query($pingSQL);
	}
?>