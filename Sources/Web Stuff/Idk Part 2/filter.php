<?php
session_id();
session_start();
ob_start();
date_default_timezone_set('America/Chicago');
$connection1 = @mysql_connect("sql201.rf.gd","rfgd_19602460","magic8888") or die("We are currently overloaded with users. Please try again in 1-5 minutes. Do not constantly refresh the page.");
mysql_select_db("rfgd_19602460_db") or die("We are currently overloaded with users. Please try again in 1-5 minutes. Do not constantly refresh the page.");



	function SecurePost($var) {
	
		return mysql_real_escape_string(strip_tags(stripslashes($var)));
	
	}

	/*Filter */
	

	/* Session */
	
	
	$Admin = $_SESSION['Admin'];
	
	if ($User) {
	
		$MyUser = mysql_query("SELECT * FROM Users WHERE Username='".$User."'");
		$myU = mysql_fetch_object($MyUser);
		$UserExist = mysql_num_rows($MyUser);
		
			if ($UserExist == "0") {
			
				session_destroy();
				header("Location: /index.php");
			
			}
	
	}
	$User = $_SESSION['Username'];
	function filter($string) {
	//array
	$words = array("fuck", "bitch", "gay", "asshole", "cunt", "dick", "nigga", "nigger", "penis", "vagina", "pussy", "sex", "blowjob", "s3x", "shit", "cum", "sperm", "lesbian", "slut", "anal", "penus", "cock", "tits", "weed", "faggot");
	$new =   array("****", "*****", "***", "*******", "****", "****", "*****", "******", "*****", "******", "*****", "***", "*******", "***", "****", "***", "*****", "*******", "****", "****", "*****", "****", "****", "****", "******");
	$string1 = str_ireplace($words, $new, $string);
	$findme = "***";
	$pos = strpos($string1, $findme);
	if ($pos !== false) {
	$User = $_SESSION['Username'];
		$MyUser = mysql_query("SELECT * FROM Users WHERE Username='".$User."'");
		$myU = mysql_fetch_object($MyUser);
	if ($_SERVER['PHP_SELF'] != "/register.php") {
	mysql_query("INSERT INTO Reports (Message, OffenseID, Link, IP, Content) VALUES('The user ".$User." said  (".$string."). Our filters detected profanity.','".$myU->ID."','".$_SERVER['PHP_SELF']."','".$_SERVER['REMOTE_ADDR']."','".$string."')");
	}
	$string1 = "[ Content Deleted ]";
	return $string1;
	}
	else {
	return $string1;
	}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function SecureString($value) {
	
	$value = mysql_real_escape_string(stripslashes(strip_tags($value)));
	return $value;

	
	}
	
	
	
	
	

?>