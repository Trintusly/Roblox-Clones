<?php
	include('../../SiT_3/config.php');
	if(isset($_GET['ip']) && isset($_GET['id'])) {
		$ip = mysqli_real_escape_string($conn,$_GET['ip']);
		$gameID = mysqli_real_escape_string($conn,intval($_GET['id']));
		$pingSQL = "UPDATE `games` SET `address`='$ip' WHERE `id`='$gameID'";
		$ping = $conn->query($pingSQL);
	}
?>