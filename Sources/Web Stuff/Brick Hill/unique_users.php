<?php
	include("SiT_3/config.php");
	$ips = array();
	$sql = "SELECT * FROM `beta_users`";
	$users = $conn->query($sql);
	while($row=$users->fetch_assoc()) {
		$ips[] = $row['IP'];
	}
	$ips = array_unique($ips);
	echo count($ips);
?>