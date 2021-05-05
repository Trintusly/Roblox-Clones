<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header('Location: ../'); die();}
	
	$userID = $userRow->{'id'};
	$findFriendsSQL = "SELECT * FROM `friends` WHERE  `to_user_id` = '$userID' ORDER BY `id` DESC";
	$findFriends = $conn->query($findFriendsSQL);
	
	
?>

<?php 
// Get incoming data
// is it an A or D?
if(isset($_POST['accept'])){
	// Accept
	$FriendReqID = mysqli_real_escape_string($conn,$_POST['OtherUserId']);
	// Both people data
	$FriendQuery = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE `id`='$FriendReqID'");
	$Friend = mysqli_fetch_array($FriendQuery);
	$UserQuery = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE `id`='$userID'");
	$User = mysqli_fetch_array($UserQuery);
	// Message
	mysqli_query($conn,"INSERT INTO `messages` VALUES (NULL,'$Sender','$FriendReqID',CURDATE(),'Friend Request Accepted','Your Friends Request to $User[username] has been accepted','0')");
	// UPDATE
	mysqli_query($conn,"UPDATE `friends` SET `accepted`='1' WHERE `from_user_id`='$FriendReqID' AND `to_user_id`='$userID'");
	mysqli_query($conn,"UPDATE `friends` SET `pending`='0' WHERE  `from_user_id`='$FriendReqID' AND `to_user_id`='$userID'");
	echo"<script>window.location='index'</script>";
}else{
	// decccccccline!
	// Message from luke! or Me! :o
	$FriendReqID = mysqli_real_escape_string($conn,$_POST['OtherUserId']);
	// Both people data
	$FriendQuery = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE `id`='$FriendReqID'");
	$Friend = mysqli_fetch_array($FriendQuery);
	$UserQuery = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE `id`='$userID'");
	$User = mysqli_fetch_array($UserQuery);
	mysqli_query($conn,"DELETE * FROM `friends` WHERE `from_user_id`='$FriendReqID' AND `to_user_id`='$userID'");
	mysqli_query($conn,"DELETE * FROM `friends` WHERE `from_user_id`='$FriendReqID' AND `to_user_id`='$userID'");
	// Messages from me or luke? who knows? heads or tails? What coin? American cent or British Pennies? Either wll do lol
	$MeOrLuke = rand(1,2);
	if($MeOrLuke == 1){
		$Sender = 1;
		// luke sends
	}else{
		$Sender = 6;
		// I said
	}
	// Sent to them
	mysqli_query($conn,"INSERT INTO `messages` VALUES (NULL,'$Sender','$FriendReqID',CURDATE(),'Friend Request Declined','Your Friends Request to $User[username] has been declined','0')");
	echo"<script>window.location='index'</script>";
}
?>