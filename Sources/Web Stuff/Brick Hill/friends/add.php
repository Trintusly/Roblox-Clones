<?php
  include("../SiT_3/config.php");
  include("../SiT_3/header.php");
  
  if(!$loggedIn) {header("Location: index"); die();}
  
  $id = mysqli_real_escape_string($conn,$_SESSION['id']);
  
  if (isset($_POST['OtherUserId'])) {
  	$senderID = mysqli_real_escape_string($conn,$_POST['OtherUserId']);
  	$AlreadyFriendsQ = mysqli_query($conn,"SELECT * FROM `friends` WHERE `to_id`='$id' AND `from_id`='$senderID' AND `status`='accepted' OR `to_id`='$senderID' AND `from_id`='$id' AND `status`='accepted'");
  	$AlreadyFriends = mysqli_num_rows($AlreadyFriendsQ);
  }
  
  if (isset($_POST['accept'])) {
	if ($AlreadyFriends == 0) {
		$AddFriendQ = mysqli_query($conn,"UPDATE  `friends` SET  `status`='accepted' WHERE  `from_id`='$senderID' AND `to_id`='$id'");
	}
  } else if (isset($_POST['decline'])) {
  	$DeclineFriendQ = mysqli_query($conn,"UPDATE  `friends` SET  `status`='declined' WHERE  `from_id`='$senderID' AND `to_id`='$id'");
  } else if (isset($_GET['id'])) {
  	$toID = mysqli_real_escape_string($conn,intval($_GET['id']));
  	$fromID = mysqli_real_escape_string($conn,$_SESSION['id']);
  	
  	$AlreadySentQ = mysqli_query($conn,"SELECT * FROM `friends` WHERE ((`to_id`='$toID' AND `from_id`='$fromID') OR (`to_id`='$fromID' AND `from_id`='$toID')) AND `status`='pending'");
  	$AlreadySent = mysqli_num_rows($AlreadySentQ);
  	
  	if (($AlreadySent == 0) && ($toID != $fromID)) {
  		mysqli_query($conn,"INSERT INTO `friends` VALUES (NULL,'$fromID','$toID','pending')");
  	}
  }

if (isset($_GET['id'])) {header("location: ../user?id=$toID");
} else {header("location: index");}
?>