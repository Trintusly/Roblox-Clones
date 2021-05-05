<?php
	
	if (!isset($argv[1])) {
		die("ok");
	}
	
	include 'blender.php';
	include '/var/www/html/site/connection.php';
	
	$id = $argv[1];
	echo "\n$id\n";
	$query = $con->prepare("SELECT * FROM avatar WHERE user_id = ?");
	$query->bind_param("s" , $id); 
	$query->execute();
	
	$result = $query->get_result();
	
	if ($result->num_rows > 0) {
		
		$avatar = $result->fetch_assoc();
		
		$colors = [
		"headColor",
		"torsoColor",
		"rightArmColor",
		"leftArmColor",
		"rightLegColor",
		"leftLegColor"
		];
		
		foreach ($colors as $color) {
			$avatar[$color] = explode('.', $avatar[$color]);
		}
		
		$blender = new blender;
		$render = $blender->renderAvatarID($id);
		
		
	} else {
		echo "Error\n";
	}
/*
} else {
	echo "heck you";
}*/