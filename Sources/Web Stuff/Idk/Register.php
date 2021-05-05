<?php
	include("DBTools.php");
	$link=dbConnect();
	
	$name = safe($_POST['name']);
	$password = safe($_POST['pass']);
	$email = $_POST['email'];

	$key = safe($_POST['key']);
    $real_key = md5($name . $secretGameKey);
	
    if($real_key == $key)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 8; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		$query = "INSERT INTO `LoginSystem`(`name`, `email`, `pass`, `forgot`) VALUES ('$name','$email','$password','$randomString')";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());

		echo md5($name . $secretServerKey);
	}
	else
	{
		echo 'false';
	}
?>