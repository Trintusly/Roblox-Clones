<?php 

//header('Content-Type: application/json');

include('../../SiT_3/config.php');
include('../../SiT_3/PHP/helper.php');

$userID = trim(mysqli_real_escape_string($conn, intval($_GET['id'])));
//$part = mysqli_real_escape_string($conn,$_GET['part']);

if (empty($userID)) {
	
	$errorArray = array(
		"error" => "Invalid Query"
	);
	
	echo json_encode($errorArray, JSON_PRETTY_PRINT);
	
} else {
	
	$findUserSQL = "SELECT * FROM `beta_users` WHERE `id` = '$userID'";
	$findUser = $conn->query($findUserSQL);
	
	if ($findUser->num_rows > 0) {
		
		$findUserAvatarSQL = "SELECT * FROM `avatar` WHERE `user_id` = '$userID'";
		$findUserAvatar = $conn->query($findUserAvatarSQL);
		$userAvatar = (object) $findUserAvatar->fetch_assoc();
		
		$avatarArray = array(
			"Head" => $userAvatar->{'head_color'},
			"Torso" => $userAvatar->{'torso_color'},
			"RightArm" => $userAvatar->{'right_arm_color'},
			"LeftArm" => $userAvatar->{'left_arm_color'},
			"RightLeg" => $userAvatar->{'right_leg_color'},
			"LeftLeg" => $userAvatar->{'left_leg_color'},
			"Face" => $userAvatar->{'face'},
			"TShirt" => $userAvatar->{'tshirt'},
			"Shirt" => $userAvatar->{'shirt'},
			"Pants" => $userAvatar->{'pants'},
			"hat1" => $userAvatar->{'hat1'},
			"hat2" => $userAvatar->{'hat2'},
			"hat3" => $userAvatar->{'hat3'}
		);
		
		echo $avatarArray["Head"].":";
		echo $avatarArray["Torso"].":";
		echo $avatarArray["RightArm"].":";
		echo $avatarArray["LeftArm"].":";
		echo $avatarArray["RightLeg"].":";
		echo $avatarArray["LeftLeg"].":";
		echo $avatarArray["Face"].":";
		echo $avatarArray["TShirt"].":";
		echo $avatarArray["Shirt"].":";
		echo $avatarArray["Pants"].":";
		echo $avatarArray["hat1"].":";
		echo $avatarArray["hat2"].":";
		echo $avatarArray["hat3"];
		
	} elseif ($findUser->num_rows == 0) {
		
		$errorArray = array(
			"error" => "Invalid User (ID)"
		);
		
		echo json_encode($errorArray, JSON_PRETTY_PRINT);
		
	}
 
}
 


?>