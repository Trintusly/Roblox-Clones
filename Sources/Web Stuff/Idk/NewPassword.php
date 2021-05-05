<?php
	include("DBTools.php");
	$link=dbConnect();

	$email = safe($_POST['email']);
	$pass = safe($_POST['pass']);
	$key = safe($_POST['key']);
	$realKey = md5($email . $secretGameKey);

	if($realKey == $key)
	{
		$query = "UPDATE LoginSystem SET pass='$pass' WHERE email = '" . $email . "'";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());
		$num_results = mysql_num_rows($result);
		echo "true";
	}
?>