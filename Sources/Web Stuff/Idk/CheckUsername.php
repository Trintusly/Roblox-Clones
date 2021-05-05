<?php
  	include("DBTools.php");
	$link=dbConnect();

	$name = safe($_POST['name']);

	$query = "SELECT * FROM `LoginSystem` WHERE name = '". $name ."'";
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