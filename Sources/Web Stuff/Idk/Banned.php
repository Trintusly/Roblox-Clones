<?php
include "Global.php";
echo '<link rel="stylesheet" href="https://brickplanet.gq/Base/Style/Main.css">';
if ($myU->Premium == 1) {

	echo "
	<style>
		body {
		background:url(https://brickplanet.gq/Images/PremiumBG.png);
		background-repeat:no-repeat;
		background-attachment:fixed;
		background-position:center top; 
		background-size:cover;
		height:100%;
		}
	</style>
	<center>
	";

}
		if ($myU->Ban == "1") {
echo "
			<div id='Header'>
				<table cellspacing='0' cellpadding='0' width='1100'>
					<tr>
						<td width='200'>
							<img src='https://brickplanet.gq/Imagess/SPNewLogo.png'  height='40'>
						</td>
					</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<br />
";
			echo "

			<div id='Container'>
			<div style='border:1px solid black;width:900px;padding:30px; margin: 30px auto; '>
			<center>
			<table>
				<tr>
					<td id=''><center>
			<div id='LargeText' style='text-align:center;'>";
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
			echo "</div>
					
								<div id='HeadText'>
								";

								
								if ($myU->BanLength != "forever") {
								$TimeUp = date("F j, Y g:iA","".$myU->BanTime."");
								}
								
								echo "
							</div>
							</td>
							</tr>
							<tr>
							<td align='left'>
								<font style='font-size:12px;'>
								<table>
									<tr>
										<td>
											Reason:
										</td>
										<td>
											<b>".$myU->BanType."</b>
										</td>
									</tr>
									<tr>
										<td>
											Time Banned:
										</td>
										<td>
											<b>".date("F j, Y g:iA","".$myU->TimeBanned."")."</b>
										</td>
									</tr>
								</table>
								<br />
								Our staff has found your account in violation of our terms. We have such rights to suspend your account if you do not abide by our rules.
								</font>
								<br />
								<center>
								<div id='aB' style='border-radius:5px;width:900px;'>
									";
									if ($myU->BanContent) {
									echo "
									<div style='background:white;padding:7px;border:1px solid #ccc;width:97%;text-align:left;'>
									 <b>Offensive Content:</b> <i>".$myU->BanContent."</i>
									 <br />
									 <font style='font-size:9px;'>The following text in italics is offensive text you have typed that is not approved by our staff.</font>
									</div>
									";
									}
									echo "
									</center>
									<br />
									<b>Moderator Note:</b> $myU->BanDescription
								</div>
							</td></tr></table>
<br />
			";
		
		
	
	$time1 = time();
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
	
	echo "<font color='red'>Your account has been terminated.</font>";
	
	
	
	
	}
	echo "</div>
						</td>
				</tr>
			</table>

	";
	echo "<br /><font style='font-size:8pt;color:#999;'>Want to logout? <a href='../Logout.php'>Logout here</a>.</font>";
	}
	
	
