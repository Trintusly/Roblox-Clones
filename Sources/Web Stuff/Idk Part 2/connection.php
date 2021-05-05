<?php
session_id();
session_start();
ob_start();
date_default_timezone_set('America/Chicago');
session_name('ASC_SESSID');
$connection = @mysql_connect("sql201.rf.gd","rfgd_19602460","magic8888") or die("We are currently overloaded with users. Please try again in 1-5 minutes. Do not constantly refresh the page.");
mysql_select_db("rfgd_19602460_db") or die("We are currently overloaded with users. Please try again in 1-5 minutes. Do not constantly refresh the page.");


        /* Filter */
        include 'filter.php';

	/* Session */
	
	$User = $_SESSION['Username'];
	$Password = $_SESSION['Password'];
	$Admin = $_SESSION['Admin'];
	 
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $IP=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $IP=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $IP=$_SERVER['REMOTE_ADDR'];
		}
		
	if ($User) {
	
		$MyUser = mysql_query("SELECT * FROM Users WHERE Username='".$User."'");
		$myU = mysql_fetch_object($MyUser);
		$UserExist = mysql_num_rows($MyUser);
		
			if ($UserExist == "0") {
			
				session_destroy();
				header("Location: /index.php");
			
			}
			mysql_query("UPDATE Users SET IP='$IP' WHERE Username='$myU->Username'");
			
			$checkifInDatabase = mysql_query("SELECT * FROM UserIPs WHERE IP='$IP' AND UserID='$myU->ID'");
			$cii = mysql_num_rows($checkifInDatabase);
			
				if ($cii == "0") {
				mysql_query("INSERT INTO UserIPs (UserID, IP) VALUES('$myU->ID','$IP')");
				}
				
			if ($Password != $myU->Password) {
			session_destroy();
			}
	
	}
	
	//referrals
	$getReferrals = mysql_query("SELECT * FROM Users");
	while ($gR = mysql_fetch_object($getReferrals)) {
	
			if ($gR->SuccessReferrer >= 3) {
			
				//check if badge is already there
				
				$getBadge = mysql_query("SELECT * FROM Badges WHERE UserID='".$gR->ID."' AND Position='Referrer'");
				$Badge = mysql_num_rows($getBadge);
				
					if ($Badge == 0) {
					
						mysql_query("INSERT INTO Badges (UserID, Position) VALUES('".$gR->ID."','Referrer')");
					
					}
			
			}
	
	}
	
	$updateCode = mysql_query("SELECT * FROM Users");
	
		while ($uC = mysql_fetch_object($updateCode)) {
		
			$Mix = "$uC->Username$uC->Password";
		
			$Hash = md5($Mix);
			mysql_query("UPDATE Users SET Hash='$Hash' WHERE ID='$uC->ID'");
		
		}
	
	$getNoAvatars = mysql_query("SELECT * FROM Users WHERE Body=''");
	while ($gN = mysql_fetch_object($getNoAvatars)) {
	
		mysql_query("UPDATE Users SET Body='Avatar.png' WHERE ID='$gN->ID'");
	
	}
	
	$now = time();
	
	$timeout = 5; 
	
	$xp = 60;
	$expires = $now + $timeout*$xp;
	mysql_query("UPDATE Users SET visitTick='$now' WHERE Username='$User'");
	mysql_query("UPDATE Users SET expireTime='$expires' WHERE Username='$User'");
	
	if ($myU->Ban == "1" && $_SERVER['PHP_SELF'] != "/Banned.php") {
	
		header("Location: http://indev.getasc.online/Banned.php");
	
	}
								$Bux = $myU->Bux;
							
								if ($Bux >= 100000&&$Bux <= 999999) {
								
									$BuxShort = substr($Bux, 0,3);
									
									$Bux = "".$BuxShort."K+";
								
								}
								else if ($Bux >= 1000000&&$Bux <= 9999999) {
								
									$BuxShort = substr($Bux, 0,1);
									
									$Bux = "".$BuxShort."M+";
								
								}
								else if ($Bux >= 10000000&&$Bux <= 99999999) {
								
									$BuxShort = substr($Bux, 0,2);
									
									$Bux = "".$BuxShort."M+";
								
								}
								else if ($Bux >= 100000000&&$Bux <= 999999999) {
								
									$BuxShort = substr($Bux, 0,3);
									
									$Bux = "".$BuxShort."M+";
								
								}
								else if ($Bux >= 1000000000&&$Bux <= 9999999999) {
								
									$BuxShort = substr($Bux, 0,1);
									
									$Bux = "".$BuxShort."B+";
								
								}
								else if ($Bux >= 10000000000&&$Bux <= 99999999999) {
								
									$BuxShort = substr($Bux, 0,2);
									
									$Bux = "".$BuxShort."B+";
								
								}
								else if ($Bux >= 100000000000&&$Bux <= 999999999999) {
								
									$BuxShort = substr($Bux, 0,3);
									
									$Bux = "".$BuxShort."B+";
								
								}
								else if ($Bux >= 1000000000000&&$Bux <= 9999999999999) {
								
									$BuxShort = substr($Bux, 0,1);
									
									$Bux = "".$BuxShort."T+";
								
								}
								else if ($Bux >= 10000000000000&&$Bux <= 99999999999999) {
								
									$BuxShort = substr($Bux, 0,2);
									
									$Bux = "".$BuxShort."T+";
								
								}
								else if ($Bux >= 1000000000) {
								
									$Bux = "&#8734;";
								
								}
								else if ($Bux >= 100&&$Bux <= 99999) {
								
									$Bux = number_format($Bux);
								
								}
						
						$getPremium = mysql_query("SELECT * FROM Users WHERE Premium='1'");
							while ($gP = mysql_fetch_object($getPremium)) {
							
								$checkBadge = mysql_query("SELECT * FROM Badges WHERE UserID='$gP->ID' AND Position='Premium'");
								$Badge = mysql_num_rows($checkBadge);
								
								if ($Badge == 0) {
								
									mysql_query("INSERT INTO Badges (UserID, Position) VALUES('$gP->ID','Premium')");
								}
								if ($gP->PremiumExpire != "unlimited") {
								if ($now > $gP->PremiumExpire) {
								
									mysql_query("UPDATE Users SET Premium='0' WHERE ID='$gP->ID'");
									mysql_query("DELETE FROM Badges WHERE UserID='$gP->ID' AND Position='Premium'");
								
								}
								}
								
							
							}
							
							$now = time();
							if ($now > $myU->getBux) {
							$NewBux = $now + 86400;
							if ($myU->Premium == 0) {
							
								$AmountToAdd = 100;
							
							}
							else {
							
								$AmountToAdd = 250;
							
							}
							mysql_query("UPDATE Users SET Bux=Bux + ".$AmountToAdd." WHERE ID='$myU->ID'");
							mysql_query("UPDATE Users SET getBux='$NewBux' WHERE ID='$myU->ID'");
							}
						
?>