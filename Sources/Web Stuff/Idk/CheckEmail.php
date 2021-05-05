<?php
  	include("DBTools.php");
	$link=dbConnect();

	$email = safe($_POST['email']);

	$query = "SELECT * FROM `LoginSystem` WHERE email = '". $email ."'";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());	
    $num_results = mysql_num_rows($result);  
	
    if($num_results > 0)
    {
		echo 'false';
    }
	else
	{
		echo 'true';
	}
?>