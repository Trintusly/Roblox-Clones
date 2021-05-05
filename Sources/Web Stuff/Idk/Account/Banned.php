<?php
session_id();
session_start();
ob_start();
date_default_timezone_set('America/Chicago');
$connection = mysql_pconnect("localhost","socialpa_user","lolkpass123") or die("Error connecting to database, hang tight, we are working on it.");
mysql_select_db("socialpa_database") or die("Error connecting to database, hang tight, we are working on it.");
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
		$IP = $_SERVER['REMOTE_ADDR'];

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
	
	if (!$User) {
	header("Location: /index.php");
	}
	if ($myU->Ban == "0") {
	header("Location: /index.php");
	}
?>
<style>
body {
background-color:#ddd;
font-family:Arial;
font-size:10pt;
margin:0;
padding:0;
color:#777777;
text-shadow:0 1px 1px #ccc;
font-size:15px;
}

a {
color:#999;
text-decoration:none;
}
</style>
<center>
<img src='/Imagess/SPNewLogo.png' width='300'>
</center>
<div style='margin-top:54px;margin-left:150px;'>
<?php
if ($myU->Ban == "1") {
			echo "
			<b style='font-size:20px;'>";
								if ($myU->BanLength == "0") {
								
									echo "Reminder/Warning";
								
								}
								if ($myU->BanLength == "1") {
								
									echo "Banned for 1 Day";
								
								}
								if ($myU->BanLength == "3") {
								
									echo "Banned for 3 Days";
								
								}
								if ($myU->BanLength == "7") {
								
									echo "Banned for 7 Days";
								
								}
								if ($myU->BanLength == "14") {
								
									echo "Banned for 14 Days";
								
								}
								if ($myU->BanLength == "forever") {
								
									echo "Account Deleted";
								
								}
			echo "</b>
								<div id='HeadText'>
								";

								
								if ($myU->BanLength != "forever") {
								echo "Rip your account";
								}
								
								echo "
								<font style='font-size:12px;'>
								Reason: <b>".$myU->BanType."</b>
								<br /><br />
								Our staff has found your account in violation of our terms. We have such rights to suspend your account if you do not abide by our rules.
								</font>
								<br />
								<br />
									";
									if ($myU->BanContent) {
									echo "
									<div style='background:white;padding:7px;border:1px solid #ccc;width:97%;text-align:left;'>
									 <b>Bad Content:</b> <i>".$myU->BanContent."</i>
									 <br />
									 <font style='font-size:9px;'>The following text in italics is offensive text you have typed that is not approved by our staff.</font>
									</div>
									";
									}
									echo "
									</center>
									<br />
									<b>Moderator Note:</b> $myU->BanDescription
<br />
			";
		
		
	
	$open = $myU->BanTime;
	if($myU->BanLength != "forever")
	{
	if($myU->BanLength == "0")
	{
	
		echo "<a href='?Reactivate=Yes'><font color='green'>Reactivate Account</font></a>";
	
	}
	else if($time1 >= $open)
	{
	


									
							
		echo "<a href='?Reactivate=Yes'><font color='green'>Reactivate Account</font></a>";
	
	}
	else if ($time1 <= $open) {
	
		echo "You can reactivate your account on ".$TimeUp."";
		

	}
	
	$Reactivate = mysql_real_escape_string(strip_tags(stripslashes($_GET['Reactivate'])));
	if($Reactivate == "Yes")
	{
	
		if($myU->BanLength == "0")
		{
		
			mysql_query("UPDATE Users SET Ban='0' WHERE Username='$User'");
			mysql_query("UPDATE Users SET BanTime='' WHERE Username='$User'");	
			mysql_query("UPDATE Users SET BanLength='' WHERE Username='$User'");
			mysql_query("UPDATE Users SET BanType='' WHERE Username='$User'");
			mysql_query("UPDATE Users SET BanDescription='' WHERE Username='$User'");
			header("Location: /index.php");
		}
		else if($time1 >= $open)
		{
		
			if ($myU->BanLength != "forever") {
		
			mysql_query("UPDATE Users SET Ban='0' WHERE Username='$User'");
			mysql_query("UPDATE Users SET BanTime='' WHERE Username='$User'");	
			mysql_query("UPDATE Users SET BanLength='' WHERE Username='$User'");
			mysql_query("UPDATE Users SET BanType='' WHERE Username='$User'");
			mysql_query("UPDATE Users SET BanDescription='' WHERE Username='$User'");
			header("Location: /index.php");
			}
		}
		else { echo "Error"; }
	
	}
	}
	else
	{
	
	echo "<font color='#999' style='font-size:8pt;'>Your account has been terminated.</font>";
	
	
	
	
	}
	echo "

	";
	echo "<br /><BR /><font style='font-size:8pt;color:#999;'>Want to logout? <a href='../Logout.php'>Logout here</a>.</font>";
	}
?>
</div>