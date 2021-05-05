<?php
	include('SiT_3/config.php');
	for($i = 1; $i <= 1908; $i += 1) {
		$crateSQL = "SELECT * FROM `crate` WHERE `id`='$i'";
		$crate = $conn->query($crateSQL);
		if($crate->num_rows == 0) {
			echo $i.'<br>';
		}
	}
?>