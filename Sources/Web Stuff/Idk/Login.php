<?php
  	include("DBTools.php");
	$link=dbConnect();

	$name = safe($_POST['name']);
	$pass = safe($_POST['pass']);
	$key = safe($_POST['key']);

	$query = "SELECT * FROM `LoginSystem` WHERE name = '". $name ."'";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());	
    $num_results = mysql_num_rows($result);  
	
    if($num_results > 0)
    {
		$row = mysql_fetch_assoc($result);
		$realKey = md5($name . $secretGameKey);
	
		if($realKey == $key)
		{
			if(strtolower($row['pass']) == strtolower($pass))
			{
				echo md5($name . $secretServerKey);
			}
			else
			{
				echo 'false';
			}
		}
		else
		{
			echo 'false';
		}
    }
	else
	{
		echo 'false';
	}
?>