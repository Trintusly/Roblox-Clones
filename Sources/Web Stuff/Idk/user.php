<?php
include "Header.php";
$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));



if (!$ID) {
header ("Location: https://brickplanet.gq/DoesntExist.php");

}
else {
	$gU = mysql_fetch_object($getUser = mysql_query("SELECT * FROM Users WHERE ID='".$ID."'"));
	$UserExist = mysql_num_rows($getUser = mysql_query("SELECT * FROM Users WHERE ID='".$ID."'"));
	if ($UserExist == "0") {
	
header("Location: https://brickplanet.gq/DoesntExist.php");
		exit;
	
	}
				$checkBan = mysql_query("SELECT * FROM IPBans WHERE IP='$gU->IP'");
				$Ban = mysql_num_rows($checkBan);
if ($gU->Premium == 1) {

	echo "
	";
	
	// <style>
	//	body {
		//background:url(https://brickplanet.gq/premium-background.png) top center repeat-x black;
	
		//height:100%;
		//}
	//</style>
//	";

}
if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true") {

	if ($Ban > 0) {
	
		echo "
	<center>
	<div id='cA' style='width:90%;'>
		<b>This user is IP banned forever. "; if ($myU->PowerMegaModerator == "true"||$myU->PowerAdmin == "true") { echo "<a href='../user.php?ID=$ID&IP=Revert'>(revert)</a>"; } echo "</b>
	</div>
	<br />
		";
	$IP = mysql_real_escape_string(strip_tags(stripslashes($_GET['IP'])));
	if ($IP == "Revert") {
	mysql_query("DELETE FROM IPBans WHERE IP='$gU->IP'");
	header("Location: user.php?ID=$ID");
	}
	}

}
	
	if ($gU->Ban == "1") {
		
		if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true") {
		
			$getHistory = mysql_query("SELECT * FROM BanHistory WHERE UserID='$ID'");
			$gH = mysql_fetch_object($getHistory);
			$getMod = mysql_query("SELECT * FROM Users WHERE ID='$gH->WhoBanned'");
			$gM = mysql_fetch_object($getMod);
		
				echo "
				
				This user is banned.
				<a href='../BanUser.php?ID=$ID&Unban=True'>
					(revert)
				</a>
				<p>Ban Reason: $gU->BanType</p>
				<p>Ban Time: $gU->BanTime</p>
							<p>Ban Length: $gU->BanLength</p>

				<p>Ban Description: $gU->BanDescription</p>
								<p>Moderator Note: $gH->BanContent</p>
								
								<p>Banned By: $gM->Username</p>

				";
		
		}
		
		else {
		
			header("Location: ../UserBanned.php");
			die();
		
		}
	}
	}
	
	if ($User) {
	
		if ($myU->ID != $ID) {
		
			mysql_query("UPDATE Users SET pviews=pviews + 1 WHERE ID='".$ID."'");
		
		
					$CheckIfFriend = mysql_query("SELECT * FROM FRs WHERE SenderID='".$myU->ID."' AND ReceiveID='".$ID."'");
					
					$Check_A = mysql_num_rows($CheckIfFriend);
					
					$CheckIfFriendd = mysql_query("SELECT * FROM FRs WHERE SenderID='".$ID."' AND ReceiveID='".$myU->ID."'");
					
					$Check_B = mysql_num_rows($CheckIfFriendd);
					
					$SendFR = mysql_real_escape_string(strip_tags(stripslashes($_GET['SendFR'])));
					$Close = mysql_real_escape_string(strip_tags(stripslashes($_POST['Close'])));
					
					if ($SendFR == "send") {
					
					if ($Check_A >= "1" || $Check_B >= "1") {
					
						echo "
						<script>alert('It seems you are already friends with this user or you already sent them a friend request.');</script>
			
						";
					

						
						}
						else {
						
							mysql_query("INSERT INTO FRs (SenderID, ReceiveID, Active) VALUES ('".$myU->ID."','".$ID."','0')");
							
							echo "
					<script>alert('You have sent user $gU->Username a friend request!');</script>
							";
							
						
						}
						
					if ($Close) {
					
						header("Location: user.php?ID=$ID");
					
					}
					
					}
					
					}
	
	}
	
	
echo "
<!DOCTYPE html>

<head><meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'><meta name='generator' content='Webflow'>

<link rel='stylesheet' type='text/css' href='NewUserProfiles.css'><script src='https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js'></script><script>WebFont.load({
  google: {
    families: ['Source Sans Pro:200,300,regular,600,700,900']s
  }
});</script><script type='text/javascript' src='https://daks2k3a4ib2z.cloudfront.net/0globals/modernizr-2.7.1.js'></script><link rel='shortcut icon' type='image/x-icon' href='https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico'><link rel='apple-touch-icon' href='https://daks2k3a4ib2z.cloudfront.net/img/webclip.png'></head><body>
";

if ($gU->Premium == "1") { echo "
<div class='premiumbanner'><div>You are viewing the profile&nbsp;of a Premium membership member.</div></div>";
}


if ($gU->ProfileStatus) {
echo "
<div class='premiumbanner'><div>Status:&nbsp;<strong>$gU->ProfileStatus</strong></div></div>
";
}
else {
echo "
<div class='premiumbanner'><div>Status:&nbsp;<strong>This user has not made a status yet.</strong></div></div>
";
}


if ($myU->PowerAdmin == "true") {
$ScrubStatus = $_GET['ScrubStatus'];
$SetToNone = $_GET['SetToNone'];
if ($ScrubStatus == "true") {
mysql_query("UPDATE Users SET ProfileStatus='[ Content Deleted ]' WHERE ID='$ID'");
}

echo "
<font color='blue'><a href='user.php?ID=$ID&ScrubStatus=true'>Scrub Status</font></a> | <font color='blue'><a href='user.php?ID=$ID&SetToNone=true'>Delete Status</font></a>
";
}

echo "
<div class='w-row'><div class='w-col w-col-6'><h1>$gU->Username's Profile</h1>"; if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true") {
				if (!empty($gU->OriginalName)) {
				echo "<center><font color='blue' style='font-size:7pt;'><b>User's original name was ".$gU->OriginalName."</b></font> <a href='?ID=$ID&moderation=revertname' style='font-size:7pt;'>[Revert]</a>";
				}
				} echo" <div class='w-embed'><center>"; if ($now < $gU->expireTime) {
					$Status = "[ Online: Website ]";
					$Color = "green";
					
					}
					else {
					$Status = "[ Offline ]";
					$Color = "gray";
					
					}
					
					echo "
															<font color='$Color'>$Status</font><br /><br />"; 
															
															echo "<img src='https://brickplanet.gq/Avatar.php?ID=$gU->ID'> ";
															
								$Rap = 0;
					$getLItems = mysql_query("SELECT * FROM Inventory WHERE UserID='$ID' AND SerialNum >= 1");
	
					while ($gLI = mysql_fetch_object($getLItems)) {
						$checkRap = mysql_query("SELECT * FROM Items WHERE ID='$gLI->ItemID' AND saletype='limited'");
						$cR = mysql_fetch_object($checkRap);
						
						if ($cR->SalePrices <= '0') {
							$Rap = $Rap;
						}
						else {
							$Rap = $Rap + $cR->SalePrices;
						}
					}
					echo "
					<b><p align='center'>RAP: </b><font color='green'><b>";
					echo number_format("$Rap");
					echo " Bux</b></font><p>";

											
				echo "</center></div>"; 
					
					
					//check if user is still in main group
					if (!empty($gU->MainGroupID)) {
						$checkUser = mysql_query("SELECT * FROM GroupMembers WHERE GroupID='$gU->MainGroupID' AND UserID='$ID'");
						
						$numMember = mysql_num_rows($checkUser);
						
						if ($numMember == 0) {
						
							mysql_query("UPDATE Users SET MainGroupID='' WHERE ID='$ID'");
							header("Location: user.php?ID=$ID");
						
						}
					$getMain = mysql_query("SELECT * FROM Groups WHERE ID='$gU->MainGroupID'");
					$gM = mysql_fetch_object($getMain);
					echo "
					<center>
					<b style='font-size:8pt;'>Primary Group:</b>
					<br />
					<div style='height:50px;width:50px;'>
					<a href='../Groups/Group.php?ID=$gM->ID'><img src='https://brickplanet.gq/Groups/GL/".$gM->Logo."' width='50' height='50'>
					
					</div>
					<b><font style='font-size:11px;'>".$gM->Name."</font></a></b></center>
					";
					} echo "<div class='userblurb'><div class='userblurbtext'>$gU->Description</div></div>
					
					<center>
					<a class='button' href='SendMessage.php?ID=$ID' style='color:white; text-decoration:none; font-weight: 400;'>Send Message</a><a class='button' href='?ID=$ID&SendFR=send' style='color:white; text-decoration:none; font-weight: 400;'>Send Friend Request</a>		<a class='button' href='SendMessage.php?ID=$ID' style='color:white; text-decoration:none; font-weight: 400;'>Send Message</a><a class='button' href='/Trade/?tradeWith=$ID' style='color:white; text-decoration:none; font-weight: 400;'>Trade</a>
					";
					if ($myU->Premium == '1') {
						echo "<a class='button' href='https://brickplanet.gq/Trades/?tradeWith=$ID' style='color:white; text-decoration:none; font-weight: 400;'>Send Trade Request</a>";
					}
					echo "
					</center>
					";
					if ($gU->OldUsername) {
						echo "
						<center>
						<br>
						This user has changed usernames.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='https://brickplanet.gq/images/helping.png' title='Previous Username: $gU->OldUsername'></center></fieldset>";
						}
						echo "
					
					<h1>Statistics</h1><p>Profile Views: ".number_format($gU->pviews)."<br>
					
					"; 	$Threads = mysql_num_rows($Threads = mysql_query("SELECT * FROM Threads WHERE PosterID='$ID'"));
								$Replies = mysql_num_rows($Replies = mysql_query("SELECT * FROM Replies WHERE PosterID='$ID'"));
								$Posts123 = $Threads + $Replies;
								
								echo "
								Forum&nbsp;Posts:&nbsp;".number_format($Posts123)."
								
								";
								$NumFriends = mysql_query("SELECT * FROM FRs WHERE ReceiveID='$ID' AND Active='1'");
								$NumFriends = mysql_num_rows($NumFriends);
								echo "
								
								<br>Friends: $NumFriends<br>
								
								";
								if (!$gU->expireTime) {
								$SS = "Error";
								}
								else {
								if ($now < $gU->expireTime) {
								$SS = "<font color='green'>Online</font>";
								}
								else {
								$SS = date("F j, Y g:iA", $gU->expireTime);
								
								
								
							
								}
								}
								$gL = 0;
					$getLimiteds = mysql_query("SELECT * FROM Inventory WHERE UserID='$ID' AND SerialNum >= 1");
					$gL = mysql_num_rows($getLimiteds);
	
					
								echo "
								
								Number of Limiteds: $gL<br />
								
								Last Seen: $SS
								
								
								";
								
								echo "
								<h1>Badges</h1>
					
					";
					$numBadges = mysql_num_rows($Badges = mysql_query("SELECT * FROM Badges WHERE UserID='$ID'"));
					
					if ($numBadges <= 0) {
					echo " <b>This user has not earned any website badges.</b> ";
					}
					
					if ($numBadges > 0) {
					
						echo "<center><table><tr>";
						$Badges = mysql_query("SELECT * FROM Badges WHERE UserID='$ID' ORDER BY ID");
						$badge = 0;
						while ($Row = mysql_fetch_object($Badges)) {
							$badge++;
							echo "
							<td width='100'><center>
								<img src='/Badgess/".$Row->Position.".png' height='50' width='50'>

								<br />
								<b>".$Row->Position."</b>

							</td>
							";
							if ($badge >= 5) {
							echo "</tr><tr>					
";
							$badge = 0;
							}
						
						}
						
						
						echo "</tr></table>
			</td>";
					
					}
					
					
					
						$Setting = array(
						"PerPag1e" => 8
					);
					$Page1 = mysql_real_escape_string(strip_tags(stripslashes($_GET['FRPage'])));
					if ($Page1 < 1) { $Page1=1; }
					if (!is_numeric($Page1)) { $Page1=1; }
					$Minimum1 = ($Page1 - 1) * $Setting["PerPag1e"];
					$allusers1 = mysql_query("SELECT * FROM FRs WHERE ReceiveID='$ID' AND Active='1'");
					$num1 = mysql_num_rows($allusers1);
					$getFRs = mysql_query("SELECT * FROM FRs WHERE ReceiveID='$ID' AND Active='1' LIMIT {$Minimum1},  ". $Setting["PerPag1e"]);
					$RFriends = mysql_query("SELECT * FROM FRs WHERE ReceiveID='$ID' AND Active='1'");
					$NumFriends = mysql_num_rows($getFRs);
					$KFriends = mysql_num_rows($RFriends);
					
					$NumInGroups1 = mysql_query("SELECT * FROM GroupMembers WHERE UserID='$ID'");
					$NumInGroups = mysql_num_rows($NumInGroups1);
					
					
					echo "</div><div class='w-col w-col-6'><h1>$gU->Username's Friends (".$KFriends.")</h1>
				<center>
					";
					echo "<table><tr>";
					
					if ($NumFriends == 0) {
					
						echo "<b>This user has added no friends yet.</b>";
					
					}
						$friends = 0;
						while ($gF = mysql_fetch_object($getFRs)) {
						$friends++;
						$getFriend = mysql_query("SELECT * FROM Users WHERE ID='".$gF -> SenderID."'");
						$gFF = mysql_fetch_object($getFriend);
					echo "
					<td align='center' width='100'>
						<div style='height:100px;width:100px;overflow-y:hidden;'>
						<a href='../user.php?ID=".$gFF->ID."' style='color:black;font-weight:bold;'>
						<img src='https://brickplanet.gq/Avatar.php?ID=".$gFF->ID."'>
						</div>
						".$gFF -> Username."
						</a>
					</td>
					";
					if ($friends >= 4) {
					
						echo "</tr><tr>";
						$friends = 0;
					
					}
					}
					
					echo "</tr></table>";
						$amount=ceil($num1 / $Setting["PerPag1e"]);
						if ($Page1 > 1) {
						echo '<a href="user.php?ID='.$ID.'&FRPage='.($Page1-1).'">Prev</a> - ';
						}
						echo ''.$Page1.'/'.(ceil($num1 / $Setting["PerPag1e"]));
						if ($Page1 < ($amount)) {
						echo ' - <a href="user.php?ID='.$ID.'&FRPage='.($Page1+1).'">Next</a>';
						}
					$NumInGroups1 = mysql_query("SELECT * FROM GroupMembers WHERE UserID='$ID'");
					$NumInGroups = mysql_num_rows($NumInGroups1);
					
					echo "
					</center>
					";
				
					echo "
					
					
					";
				
					echo "
					
					
				<h1>$gU->Username's Groups (".$NumInGroups.")</h1>"; 
					
					echo "
					<div id='Gradient1'>
				<center>
				<table><tr>
					";
					$groups = 0;
					while ($gG = mysql_fetch_object($NumInGroups1)) {
					$groups++;
					$getGroupK = mysql_query("SELECT * FROM Groups WHERE ID='$gG->GroupID'");
					$gK = mysql_fetch_object($getGroupK);
					
						echo "
						<td width='100' valign='top'>
						<center>
						<a href='../Groups/Group.php?ID=".$gK->ID."'>
						<div style='width:50px;height:50px;padding:5px;border:1px solid #ddd;'>
						<img src='https://brickplanet.gq/Groups/GL/".$gK->Logo."' height='50' width='50'>
						</div>
						<b>".$gK->Name."</b>
						</a>
						</td>
						";
						if ($groups >= 4) {
						
							echo "</tr><tr>";
							$groups = 0;
						
						}
					
					}
					echo "
					</tr></table>
					</center>
				</div>
			</td>
		</tr>
	</table>
	";
					


					echo "</div></div><h1 class='inventoryclass'>$gU->Username's Inventory</h1><center><table><tr><a name='OwnedItems'></a>

";


					$counter = 0;
						$Setting = array(
							"PerPage1" => 8
						);
						$Item = mysql_real_escape_string(strip_tags(stripslashes($_GET['Item'])));
						if ($Item < 1) { $Item=1; }
						if (!is_numeric($Item)) { $Item=1; }
						$Minimum1 = ($Item - 1) * $Setting["PerPage1"];
						//query
						$allusers1 = mysql_query("SELECT * FROM Inventory WHERE UserID='".$ID."'");
						$num1 = mysql_num_rows($allusers1);
					$getOwnedItems = mysql_query("SELECT * FROM Inventory WHERE UserID='".$ID."' ORDER BY ID DESC LIMIT {$Minimum1},  ". $Setting["PerPage1"]);
						while ($gO = mysql_fetch_object($getOwnedItems)) {
						
							
						
							$getFromStore = mysql_query("SELECT * FROM Items WHERE File='".$gO->File."'");
							
							$if_store = mysql_num_rows($getFromStore);
							
							if ($if_store == "1") {
							
								$store = 1;
								
								$gF = mysql_fetch_object($getFromStore);
							
							}
							else {
							
								$store = 0;
								$getFromStore = mysql_query("SELECT * FROM UserStore WHERE File='".$gO->File."'");
								$gF = mysql_fetch_object($getFromStore);
								$DeleteItem = mysql_num_rows($getFromStore);
								
							}
							
								if ($DeleteItem == "0") {
								mysql_query("DELETE FROM Inventory WHERE ID='".$gO->ID."'");
								}
															
								$getCreator = mysql_query("SELECT * FROM Users WHERE ID='".$gF->CreatorID."'");
								$gC = mysql_fetch_object($getCreator);
								
								if ($if_store == 1) {
								
									$Link = "/Store/Item.php?ID=".$gF->ID."";
								
								}
								else {
								
									$Link = "/Store/UserItem.php?ID=".$gF->ID."";
								
								}
							$counter++;
							echo "
							<td style='font-size:11px;' align='left' width='100' valign='top'><a href='".$Link."' border='0' style='color:black;'>
								<div style='border:0px solid #ddd;padding:5px;' class='UserImg'>
									";
									if ($gF->saletype == "limited") {
									if (!($gF->Type == "Body")) {
									echo "													<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(../Store/Dir/Avatar.png);'>
									";
									}
									echo "

										<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(../Store/Dir/".$gF->File.");'>
										
										<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(/Imagess/LimitedWatermark.png);'>
										"; if ($gO->SerialNum != "0") { echo "<center><font style='color:#253138;font-weight:bold;'>#".$gO->SerialNum."/".$gF->numbersales."</font></font>"; }
										echo "</div></div>
									";
									}
									else {
									if (!($gF->Type == "Body")) {
									echo "
									<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(../Store/Dir/Avatar.png);'>
									";
									}
									echo "
										<img src='../Store/Dir/".$gF->File."' width='100' height='200'>";
									}
									echo "
								</div>
								<b>".$gF->Name."</b></a>
								<br />
								<font style='font-size:10px;'>Creator: <a href='/user.php?ID=".$gF->CreatorID."'>".$gC->Username."</a>
								<br />
								";
								if ($gF->sell == "yes") {
								if ($gF->saletype == "limited" && $gF->numberstock == "0") {
								 echo "
								<font color='green'><b>Was Bux: ".$gF->Price."</b></font>
								";
								}
								else {
								 echo "
								<font color='green'><b>Bux: ".$gF->Price."</b></font>
								";
								}
								}
								echo "
								
							</td>
							";
							
							if ($counter >= 8) {
							
								echo "</tr><tr>";
								
								$counter = 0;
							
							}
							
							
						
						}
									echo "</tr></table><center>";
									$amount=ceil($num1 / $Setting["PerPage1"]);
									if ($Item > 1) {
									echo '<a href="user.php?ID='.$ID.'&Item='.($Item-1).'#OwnedItems">Prev</a> - ';
									}
									echo 'Page '.$Item.'/'.(ceil($num1 / $Setting["PerPage1"]));
									if ($Item < ($amount)) {
									echo ' - <a href="user.php?ID='.$ID.'&Item='.($Item+1).'#OwnedItems">Next</a>';
									
									
									}
								
echo "
</div>

";

echo "
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>

<!--[if lte IE 9]><script src='//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js'></script><![endif]-->
</body></html>

";
if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true") {
	if ($moderation == "scrubdescription") {
			
				mysql_query("UPDATE Users SET Description='[ Content Deleted ]' WHERE ID='$ID'");
				header("Location: user.php?ID=$ID");
			
			}
		echo "
		<br />
		<center><div  style='width:90%;'>
			<a href='user.php?ID=$ID&moderation=resetavatar' class='btn'><b>Reset Avatar</b></a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='user.php?ID=$ID&moderation=scrubname' class='btn'><b>Scrub Name</b></a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='user.php?ID=$ID&moderation=scrubdescription' class='btn'><b>Scrub Description</b></a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='BanUser.php?ID=$ID' class='btn'><b>Ban User</b></a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='ViewOtherAccounts.php?ID=$ID' class='btn'><b>View Other Accounts</b></a>
			<br /><br />
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='user.php?ID=$ID&moderation=ipban' class='btn'><b>IP Ban</b></a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='iplogs.php?ID=$ID' class='btn'><b>IP Logs</b></a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='user.php?ID=$ID&moderation=removepremium' class='btn'><b>Remove Premium</b></a>
			";
			if ($myU->Username == "Sparkle"||$myU->Username == "johnny"||$myU->Username == "Joe"||$myU->Username == "GoobyCo"||$myU->Username == "Marvin"||$myU->Username == "DecryptedZ") {
			
				echo "
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='user.php?ID=$ID&moderation=fireuser' class='btn'><b>Fire User</b></a>
				";
			
			}
			echo "
		</div>
		</center>
		";
		$moderation = mysql_real_escape_string(strip_tags(stripslashes($_GET['moderation'])));
		
			
			if ($myU->Username == "Sparkle"||$myU->Username == "Joe"||$myU->Username == "johnny"||$myU->Username == "GoobyCo"||$myU->Username == "Marvin"||$myU->Username == "DecryptedZ") {
			
			
				if ($moderation == "fireuser") {
				
					mysql_query("UPDATE Users SET PowerImageModerator='false' WHERE ID='$ID'");
					mysql_query("UPDATE Users SET PowerForumModerator='false' WHERE ID='$ID'");
					mysql_query("UPDATE Users SET PowerBlogger='false' WHERE ID='$ID'");
					mysql_query("UPDATE Users SET PowerArtist='false' WHERE ID='$ID'");
					mysql_query("UPDATE Users SET PowerMegaModerator='false' WHERE ID='$ID'");
					mysql_query("UPDATE Users SET PowerAdmin='false' WHERE ID='$ID'");
					
					//badges
					
					mysql_query("DELETE FROM Badges WHERE Position='Image Moderator' AND UserID='$ID'");
					mysql_query("DELETE FROM Badges WHERE Position='Forum Moderator' AND UserID='$ID'");
					mysql_query("DELETE FROM Badges WHERE Position='Super Moderator' AND UserID='$ID'");
					mysql_query("DELETE FROM Badges WHERE Position='Administrator' AND UserID='$ID'");
					mysql_query("DELETE FROM Badges WHERE Position='Blogger' AND UserID='$ID'");
					mysql_query("DELETE FROM Badges WHERE Position='Artist' AND UserID='$ID'");
					mysql_query("DELETE FROM Badges WHERE Position='Developer' AND UserID='$ID'");
					
					header("Location: user.php?ID=$ID");
				
				}
			
			}
			
			if ($moderation == "resetavatar") {
				mysql_query("UPDATE Users SET Eyes='' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Mouth='' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Hair='' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Bottom='' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Top='' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Hat='' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Shoes='' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Accessory='' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Background='' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Body='/Avatars/Avatar.png' WHERE ID='$ID'");
				header("Location: user.php?ID=$ID");
			
			}
			
			if ($moderation == "scrubname") {
				mysql_query("UPDATE Users SET OriginalName='$gU->Username' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET Username='[ Content Deleted $ID ]' WHERE ID='$ID'");
				header("Location: user.php?ID=$ID");
			
			}
			
			if ($moderation == "revertname") {
				mysql_query("UPDATE Users SET Username='$gU->OriginalName' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET OriginalName='' WHERE ID='$ID'");
				header("Location: user.php?ID=$ID");
			
			}
			
			if ($moderation == "removepremium") {
				mysql_query("UPDATE Users SET Premium='0' WHERE ID='$ID'");
				mysql_query("UPDATE Users SET PremiumExpire='' WHERE ID='$ID'");
				mysql_query("DELETE FROM Badges WHERE UserID='$ID' AND Position='Premium'");
				mysql_query("INSERT INTO PMs (SenderID, ReceiveID, Title, Body, time) VALUES('1','$ID','Premium Suspended','Your premium membership has been suspended by a staff member. Refund is not available.','$now')");
				header("Location: user.php?ID=$ID");
			
			}
			
			if ($moderation == "ipban") {
			

				if ($Ban == 0) {
				
					mysql_query("INSERT INTO IPBans (IP) VALUES('".$gU->IP."')");
					mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','IP Banned $gU->Username','".$_SERVER['PHP_SELF']."')");
					header("Location: user.php?ID=$ID");
				
				}
				header("Location: user.php?ID=$ID");
			
			}
	
	}


if ($gU->Premium == 1) {
//echo "<style>body { background-image:url(../PremiumStripeBG.png); }</style>";

}
echo "</div>";


include "Footer.php";
?>