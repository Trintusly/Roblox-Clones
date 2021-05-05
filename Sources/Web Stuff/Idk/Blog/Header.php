<?php
session_id();
session_start();
ob_start();
date_default_timezone_set('America/Chicago');
$connection = mysql_pconnect("localhost","brickpla_usr","2zqKKQQ*bZF&+_+") or die("Error connecting to database, hang tight, we are working on it.");
mysql_select_db("brickpla_db") or die("Error connecting to database, hang tight, we are working on it.");
?>
<html>
	<head>
		<title>Blog - BrickPlanet</title>
		<link rel='stylesheet' href='style.css'>
	</head>
	<body>
		<div id='TopMenu'>
			<td>
                       <center>Official BrickPlanet Blog</center>
			</td></tr></table>
			<td>
			<center><a href='../'>Back to BrickPlanet</a></center>
			</td></tr></table>
		</div>
		<br />
		<center>
		<div id='MainContainer'>
		