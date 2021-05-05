<?php
	include('../../SiT_3/config.php');
	if(isset($_POST['user']) && isset($_POST['item']) && isset($_GET['wq9084n3290v8'])) {
		$userID = mysqli_real_escape_string($conn,intval($_POST['user']));
		$itemID = mysqli_real_escape_string($conn,$_POST['item']);
		
		$checkSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' AND `user_id`='$userID'";
		$check = $conn->query($checkSQL);
		
		if($check->num_rows <= 0) {
			$serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC";
			$serialQ = $conn->query($serialSQL);
			$serialRow = $serialQ->fetch_assoc();
			$serial = $serialRow['serial']+1;
			
			$addSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$userID','$itemID','$serial')";
			$add = $conn->query($addSQL);
		}
	}
?>