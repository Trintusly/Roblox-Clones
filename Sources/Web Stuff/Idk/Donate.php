<?php
include "Header.php";

	$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
	
	if (!$ID) {
	echo "Error";
	exit;
	}
	
	$getUser = mysql_query("SELECT * FROM Users WHERE ID='$ID'");
	$gU = mysql_fetch_object($getUser);
	
	if ($myU->ID == $gU->ID) {
	echo "Error";
	exit;
	}
	
	if ($gU->IP == $myU->IP) {
	
		//alt donate = no
		echo "<b>You can not alt donate.</b>";
		die;
	
	}
	
	echo "
		<form action='' method='POST'>
	<div id='ProfileText'>
		Donate to $gU->Username
	</div>
	<div id='aB'>
		<input type='text' name='DonateValue'> <input type='submit' name='Submit' value='Send'>
	</div>
	</form>
	";
	$DonateValue = mysql_real_escape_string(strip_tags(stripslashes($_POST['DonateValue'])));
	$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
	
		if ($Submit) {
		
			if ($myU->Bux >= $DonateValue) {
		
			if (!$DonateValue) {
			
				echo "<b>Please insert an amount!</b>";
				exit;
			
			}
			if ($DonateValue < 0) {
			
				echo "Insufficient funds.";
				exit;
			
			}
			if (!is_numeric($DonateValue)) {
			echo "Insufficient funds.";
			exit;
			}
			
			
			
			mysql_query("UPDATE Users SET Bux=Bux + $DonateValue WHERE ID='".$gU->ID."'");
			mysql_query("UPDATE Users SET Bux=Bux - $DonateValue WHERE ID='".$myU->ID."'");
			
			//pm
			$getUser = mysql_query("SELECT * FROM Users WHERE ID='$ID'");
			$gU = mysql_fetch_object($getUser);
			
			mysql_query("INSERT INTO PMs (SenderID, ReceiveID, Title, Body, time) VALUES ('1','".$ID."','You received a donation!','".$myU->Username." just donated you $DonateValue Bux! That's amazing!','".$now."')");
			
	mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','donated $gU->Username $DonateValue','".$_SERVER['PHP_SELF']."')");
			
			header("Location: user.php?ID=$ID");
			
			}
			else {
			
				echo "Insufficient funds.";
			
			}
		
		}
	

include "Footer.php";
?>