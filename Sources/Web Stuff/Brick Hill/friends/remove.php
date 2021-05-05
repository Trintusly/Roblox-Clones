<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header("Location: index"); die();}
	
	if (isset($_GET['id'])) {
	  	$toID = mysqli_real_escape_string($conn,$_GET['id']);
	  	$fromID = $_SESSION['id'];
	  	
	  	mysqli_query($conn,"UPDATE  `friends` SET  `status`='declined' WHERE  (`from_id`='$fromID' AND `to_id`='$toID') OR (`from_id`='$toID' AND `to_id`='$fromID')");
	  }
	
	if (isset($_GET['id'])) {header("location: ../user?id=$toID");}
?>