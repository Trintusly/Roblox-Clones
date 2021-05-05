<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header("Location: index"); die();}
	if($power < 1) {header("Location: index"); die();}
	
	if(isset($_GET['id'])) {
		$threadID = $_GET['id'];
		$threadIDSafe = mysqli_real_escape_string($conn, $threadID);
		
		$boardID = mysqli_real_escape_string($conn,$_POST['move']);
		$scrubSQL = "UPDATE `forum_threads` SET `body`='[ Content Removed ]' WHERE `id`='$threadIDSafe'";
		$scrub = $conn->query($scrubSQL);
		header("Location: thread?id=".$threadIDSafe);
	} else {
		header("Location: index");
	}
?>