<?php
	include("DBTools.php");
	$link=dbConnect();

	$email = safe($_POST['email']);

	$query = "SELECT * FROM `LoginSystem` WHERE email = '". $email ."'";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
	$num_results = mysql_num_rows($result);

	if($num_results > 0)
	{
		$row = mysql_fetch_assoc($result);
		$realKey = md5($name . $secretGameKey);

		echo strtolower($row['forgot']);

		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 8; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		$query = "UPDATE LoginSystem SET forgot='$randomString' WHERE email = '". $email ."'";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());

		$to = $email;
		$subject = "Reset Code";

		$body = "Reset Code: " . strtolower($row['forgot']);
		mail($to, $subject, $body);
	}
?>