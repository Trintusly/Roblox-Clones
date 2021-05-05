<?php

	include "../Header.php";
	
	$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
	
	if (!$ID) {
	header("Location: ../index.php");
	die;
	}
	$getGroup = mysql_query("SELECT * FROM Groups WHERE ID='$ID'");
	$gG = mysql_fetch_object($getGroup);
	
	$GroupExist = mysql_num_rows($getGroup);
	
	if ($GroupExist == 0) {
	
		header("Location: ../index.php");
		die;
	
	}
	
	if ($myU->ID != $gG->OwnerID) {
	
		header("Location: Group.php?ID=$ID");
		die;
	
	}
	
	echo "
	<form enctype='multipart/form-data' action='' method='POST'>
	<table width='100%'>
		<tr>
			<td valign='top'>
				<div id='TopBar'>
					Logo
				</div>
				<div style='width:375px;height:100px;border:1px solid #ddd;'>
					<center><img src='../Groups/GL/".$gG->Logo."' height='100' width='100'>
				</div>
			</td>
			<td valign='top' width='600'>
				<div id='TopBar'>
					Description
				</div>
				<textarea style='width:600px;height:100px;' name='Description'>".$gG->Description."</textarea>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<input type='file' name='uploaded'>
			</td>
		</tr>
	</table>
	<br />
	<table width='100%'>
		<tr>
			<td>
				<div id='TopBar'>
					Allies
				</div>
				<div id='aB'>
					";
					$getAllies = mysql_query("SELECT * FROM GroupAllies WHERE GroupID='$ID' AND Status='1'");
						while ($gA = mysql_fetch_object($getAllies)) {
						
							$getGroup = mysql_query("SELECT * FROM Groups WHERE ID='$gA->OtherGroupID'");
							$gG = mysql_fetch_object($getGroup);
						
							echo "
								<table>
									<tr>
										<td valign='top'>
											<div style='width:50px;height:50px;border:1px solid #ddd;padding:5px;'>
												<img src='../Groups/GL/".$gG->Logo."' height='50' width='50'>
											</div>
										</td>
										<td valign='top' width='175'>
											<font style='font-size:11px;'><b>".$gG->Name."</b></font>
										</td>
										<td width='10'>
											<a href='?ID=$ID&Remove=Ally&AllyID=$gG->ID'><font color='purple'><b>Remove</b></font></a>
										</td>
									</tr>
								</table>
							";
						
						}
						
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$AllyID = mysql_real_escape_string(strip_tags(stripslashes($_GET['AllyID'])));
							
								if ($Remove == "Ally" && $AllyID) {
								
									$checkAllyExist = mysql_query("SELECT * FROM GroupAllies WHERE GroupID='$ID' AND OtherGroupID='$AllyID'");
									$AllyExist = mysql_num_rows($checkAllyExist);
									
									if ($AllyExist == 1) {
									
										mysql_query("DELETE FROM GroupAllies WHERE GroupID='$ID' AND OtherGroupID='$AllyID'");
										mysql_query("DELETE FROM GroupAllies WHERE OtherGroupID='$AllyID' AND GroupID='$ID'");
										header("Location: EditGroup.php?ID=$ID");
									
									}
								
								}
					echo "
				</div>
				<br />
				<div id='TopBar'>
					Ally Requests
				</div>
				<div id='aB'>
					";
					$getRequests = mysql_query("SELECT * FROM GroupAllies WHERE GroupID='$ID' AND Status='0'");
					while ($gR = mysql_fetch_object($getRequests)) {
					
						$getOther = mysql_query("SELECT * FROM Groups WHERE ID='$gR->OtherGroupID'");
						$gO = mysql_fetch_object($getOther);
					
						echo "
						<table>
							<tr>
								<td valign='top'>
									<a href='Group.php?ID=".$gO->ID."'>
									<div style='width:50px;height:50px;border:1px solid #ddd;padding:5px;'>
										<img src='../Groups/GL/".$gO->Logo."' height='50' width='50'>
									</div>
									</a>
								</td>
								<td valign='top'>
									<a href='Group.php?ID=".$gO->ID."'>
									<font style='font-size:11px;'><b>".$gO->Name."</b></font>
									</a>
									<br /><br />
									<a href='?ID=$ID&Action=Accept&GroupID=".$gO->ID."'><font color='green'><b>Accept</b></font></a> / <a href='?ID=$ID&Action=Deny&GroupID=".$gO->ID."&OtherGroupID=".$gR->OtherGroupID."'><font color='red'><b>Deny</b></font></a>
								</td>
							</tr>
						</table>
						";
						
					
					}
					$Action = mysql_real_escape_string(strip_tags(stripslashes($_GET['Action'])));
					$GroupID = mysql_real_escape_string(strip_tags(stripslashes($_GET['GroupID'])));
					$OtherGroupID = mysql_real_escape_string(strip_tags(stripslashes($_GET['OtherGroupID'])));
					
					if ($GroupID) {
					
						if ($Action == "Accept") {
						
							
							mysql_query("UPDATE GroupAllies SET Status='1' WHERE GroupID='$ID' AND OtherGroupID='$GroupID'");
							mysql_query("INSERT INTO GroupAllies (GroupID, OtherGroupID, Status) VALUES('".$GroupID."','".$ID."','1')");
							header("Location: Group.php?ID=$ID");
						
						}
						elseif ($Action == "Deny") {
						
							mysql_query("DELETE FROM GroupAllies WHERE GroupID='$ID' AND OtherGroupID='$OtherGroupID'");
							header("Location: Group.php?ID=$ID");
						
						}
					
					}
					echo "
				</div>
				<br />

				<div id='TopBar'>
					Send Ally Request
				</div>
				<div id='aB'>
				<form action='' method='POST'>
					<table>
						<tr>
							<td>
								<b>Group ID:</b>
							</td>
							<td>
								<input type='text' name='SendAllyRequestID'>
							</td>
							<td>
								<input type='submit' name='SubmitAllyRequest' value='Add'>
							</td>
						</tr>
					</table>
				</form>
				</div>
				<br />
				<div id='TopBar'>
					Enemies
				</div>
				<div id='Ab'>
					";
					$getEnemies = mysql_query("SELECT * FROM GroupEnemies WHERE GroupID='$ID'");
					while ($gE = mysql_fetch_object($getEnemies)) {
					
						$getOther = mysql_query("SELECT * FROM Groups WHERE ID='$gE->OtherGroupID'");
						$gO = mysql_fetch_object($getOther);
					
						echo "
								<table>
									<tr>
										<td valign='top'>
											<div style='width:50px;height:50px;border:1px solid #ddd;padding:5px;'>
												<img src='../Groups/GL/".$gO->Logo."' height='50' width='50'>
											</div>
										</td>
										<td valign='top' width='175'>
											<font style='font-size:11px;'><b>".$gO->Name."</b></font>
										</td>
										<td width='10'>
											<a href='?ID=$ID&Remove=Enemy&EnemyID=$gO->ID'><font color='purple'><b>Remove</b></font></a>
										</td>
									</tr>
								</table>
						";
					
					}
					$EnemyID = mysql_real_escape_string(strip_tags(stripslashes($_GET['EnemyID'])));
					
					if ($Remove == "Enemy" && $EnemyID) {
					
						$checkExist = mysql_query("SELECT * FROM GroupEnemies WHERE GroupID='$ID' AND OtherGroupID='$EnemyID'");
						$Exist = mysql_num_rows($checkExist);
						
						if ($Exist == 1) {
						
							//success
							mysql_query("DELETE FROM GroupEnemies WHERE GroupID='$ID' AND OtherGroupID='$EnemyID'");
							header("Location: EditGroup.php?ID=$ID");
						
						}
						else {
						
							//die
						
						}
					
					}
					echo "
				</div>
				<br />
				<div id='TopBar'>
					Send Enemy Request
				</div>
				<div id='aB'>
					<form action='' method='POST'>
					<table>
						<tr>
							<td>
								<b>Group ID:</b>
							</td>
							<td>
								<input type='text' name='SendEnemyRequestID'>
							</td>
							<td>
								<input type='submit' name='SubmitEnemyRequest' value='Add'>
							</td>
						</tr>
					</table>
				</form>
				</div>
				";
				echo "
				
			</td>
			<td valign='top' style='width:500px;'>
				<div id='TopBar'>
					Users
				</div>
				<div id='aB'>
				<center>
				<table><tr>
					";
					$members = 0;
					
					$Setting = array(
						"PerPage" => 24
					);
					$PerPage = 12;
					$Page = mysql_real_escape_string(strip_tags(stripslashes($_GET['Page'])));
					if ($Page < 1) { $Page=1; }
					if (!is_numeric($Page)) { $Page=1; }
					$Minimum = ($Page - 1) * $Setting["PerPage"];
					//query
					$num = mysql_num_rows($allusers = mysql_query("SELECT * FROM GroupMembers WHERE GroupID='$ID'"));
					$Num = ($Page+8);
					
					$getMembers = mysql_query("SELECT * FROM GroupMembers WHERE GroupID='$ID' ORDER BY ID DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
					while ($gM = mysql_fetch_object($getMembers)) {
						$members++;
						$getPerson = mysql_query("SELECT * FROM Users WHERE ID='$gM->UserID'");
						$gP = mysql_fetch_object($getPerson);
						echo "
						<td><center>
							<a href='../user.php?ID=$gP->ID'>
							<div style='height:50px;width:100px;overflow-y:hidden;'>
								<img src='../Avatar.php?ID=".$gM->UserID."' height='100'>
							</div>
							<b>$gP->Username</b>
							<br />
							</a>
							";
							$getGroup = mysql_query("SELECT * FROM Groups WHERE ID='$ID'");
							$gG = mysql_fetch_object($getGroup);
							$getCreator = mysql_query("SELECT * FROM Users WHERE ID='$gG->OwnerID'");
							$gC = mysql_fetch_object($getCreator);
							if ($myU->ID != $gP->ID) {
							echo "
							<a href='?ID=$ID&ExileUser=True&ExileID=$gP->ID'><font style='font-size:10px;'><font color='red'><b>Exile</b></font></a>
							";
							}
							
						echo "</td>
						";
						if ($members >= 6) {
						echo "</tr><tr>";
						$members = 0;
						}
					
					}
					$ExileUser = mysql_real_escape_string(strip_tags(stripslashes($_GET['ExileUser'])));
					$ExileID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ExileID'])));
					if ($myU->ID != $ExileID) {
					if ($ExileID) {
					
						$checkUser = mysql_query("SELECT * FROM Users WHERE ID='$ExileID'");
						$cU = mysql_num_rows($checkUser);
						
						if ($cU == 0) {
						
							echo "<br />Error.";
						
						}
						else {
						 
							mysql_query("DELETE FROM GroupMembers WHERE GroupID='$ID' AND UserID='$ExileID'");
							header("Location: EditGroup.php?ID=".$ID."&Page=".$Page."");
						
						}
					
					}
					
					}
					echo "
					</tr></table>
					";
$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="EditGroup.php?ID='.$ID.'&Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="EditGroup.php?ID='.$ID.'&Page='.($Page+1).'">Next</a>';
}
					echo "
				</div>
			</td>
		</tr>
	</table>
	<br />
	<br />
	<center><input type='submit' name='Submit' value='Update'>
	</form>
	";
	$SendAllyRequestID = mysql_real_escape_string(strip_tags(stripslashes($_POST['SendAllyRequestID'])));
	$SubmitAllyRequest = mysql_real_escape_string(strip_tags(stripslashes($_POST['SubmitAllyRequest'])));
	$SendEnemyRequestID = mysql_real_escape_string(strip_tags(stripslashes($_POST['SendEnemyRequestID'])));
	$SubmitEnemyRequest = mysql_real_escape_string(strip_tags(stripslashes($_POST['SubmitEnemyRequest'])));
	
	if ($SubmitAllyRequest) {
	
		if (!$SendAllyRequestID) {
		
			echo "<br />Please include an ID.";
		
		}
		elseif (is_numeric($SendAllyRequestID)) {
		
			$checkReal = mysql_query("SELECT * FROM GroupAllies WHERE GroupID='$ID' AND OtherGroupID='$SendAllyRequestID'");
			$checkReal = mysql_num_rows($checkReal);
			
			if ($checkReal == 0) {
			
			$checkAlly = mysql_query("SELECT * FROM GroupAllies WHERE GroupID='$ID' AND OtherGroupID='$SendEnemyRequestID'");
			$Ally = mysql_num_rows($checkAlly);
			
			if ($Ally >= 1) {
			
				mysql_query("DELETE FROM GroupAllies WHERE GroupID='$ID' AND OtherGroupID='$SendEnemyRequestID'");
				mysql_query("DELETE FROM GroupAllies WHERE GroupID='$SendEnemyRequestID' AND OtherGroupID='$ID'");
			
			}
		
			mysql_query("INSERT INTO GroupAllies (GroupID, OtherGroupID, Status) VALUES('$SendAllyRequestID','$ID','0')");
			echo "<br />Ally request pending.</b>";
			}
			else {
			echo "<br />You already have a pending/active ally request with that group.";
			}
		
		}
		else {
		
			echo "<br />Please include an integer format ID.";
		
		}
	
	}
	
	if ($SubmitEnemyRequest) {
	
		if (!$SendEnemyRequestID) {
		
			echo "<br />Please include an ID.";
		
		}
		elseif ($ID == $SendEnemyRequestID) {
		
			echo "<br />You can not declare war on yourself.";
		
		}
		elseif (is_numeric($SendEnemyRequestID)) {
		
			$checkReal = mysql_query("SELECT * FROM GroupEnemies WHERE GroupID='$ID' AND OtherGroupID='$SendAllyRequestID'");
			$checkReal = mysql_num_rows($checkReal);
			
			if ($checkReal == 0) {
		
			mysql_query("INSERT INTO GroupEnemies (GroupID, OtherGroupID) VALUES('$ID','$SendEnemyRequestID')");
			header("Location: EditGroup.php?ID=$ID");
			}
			else {
			echo "<br />You are already enemies with that group.";
			}
		
		}
		else {
		
			echo "<br />Please include an integer format ID.";
		
		}
	
	}
	
	$Description = mysql_real_escape_string(strip_tags(stripslashes($_POST['Description'])));
	$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
	
		if ($Submit) {
			
			 $FileName = "".$_FILES['uploaded']['name']."";
			 $_FILES['uploaded']['name'] = sha1("".$FileName."".time().".png"); 
			 $target = "GL/";
			 $target = $target . basename( $_FILES['uploaded']['name']) ; 
			 $ok=1; 
			if (($_FILES["uploaded"]["type"] == "image/png")
			&& ($_FILES["uploaded"]["size"] < 1000000000000000))
			{
			
				 if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
				 {
				 
					mysql_query("INSERT INTO GroupsLogo (GroupID, Logo) VALUES('$ID','".$_FILES['uploaded']['name']."')");
					echo "<br /><b>Your new logo is being moderated.</b>";
				 
				 }
				 else {
				 
					echo "ERORR";
				 
				 }
			
			}
			else {
			header("Location: Group.php?ID=$ID");
			}
			
			
			
			$Description = filter($Description);
		
			mysql_query("UPDATE Groups SET Description='$Description' WHERE ID='$ID'");
			//header("Location: Group.php?ID=$ID");
		
		}
	
	include "../Footer.php";

?>