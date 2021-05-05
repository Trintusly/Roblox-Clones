<?php

$dbName = 'brickpla_db';
$host = 'localhost';
$username = 'brickpla_usr';
$password = '2zqKKQQ*bZF&+_+';

$secretGameKey = "86938";
$secretServerKey = "86938";

function dbConnect()
{
	global  $dbName;
	global  $host;
	global  $username;
	global  $password;

	$link = mysql_connect($host, $username, $password);
	
	if(!$link)
	{
		fail("Couldn�t connect to database server");
	}
	
	if(!@mysql_select_db($dbName))
	{
		fail("Couldn�t find database $dbName");
	}
	
	return $link;
}
	
function safe($variable)
{
	$variable = addslashes(trim($variable));
	return $variable;
}

function fail($errorMsg)
{
	print $errorMsg;
	exit;
}

?>