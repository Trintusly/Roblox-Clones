<?php
include "Header.php";
$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));

if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true") {
$badcontent = mysql_real_escape_string(strip_tags(stripslashes($_GET['badcontent'])));

					echo "
<div id='ProfileText'>Ban User</div><div id='aB'>
							<form action='' method='POST'>
							<table>
								<tr>
									<td>
										<b>Ban Type</b>
									</td>
									<td>
										<select name='BanType'>
											<option value='Spamming'>Spamming</option>
											<option
value='Alt Buying'>Alt Buying</option>
											<option
value='Alt Donating'>Alt Donating</option>
											<option
value='Bribery'>Bribery</option>
											<option value='Spamming'>Hacking</option>
											<option value='Copying Items'>Copying Items</option>
											<option value='Personal Attacking'>Personal Attacking</option>
											<option value='Online Dating'>Online Dating</option>
											<option value='Profanity'>Profanity</option>
											<option value='Offsite link(s)'>Offsite link(s)</option>
											<option value='Threatening'>Threatening</option>
											<option value='Other'>Other</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<b>Ban Time</b>
									</td>
									<td>
											<input type='radio' name='BanTime' value='0' checked>Reminder/Warning 
											<input type='radio' name='BanTime' value='1'>1 day
											<input type='radio' name='BanTime' value='3'>3 days
											<input type='radio' name='BanTime' value='7'>7 days
											<input type='radio' name='BanTime' value='14'>14 days
											<input type='radio' name='BanTime' value='forever'>Life
									</td>
								</tr>
								<tr>
									<td><b>Ban Content</b></td>
									<td>
										<input type='text' name='BanContent' placeholder='Leave empty if user didnt violate filter.' style='width:250px;' value='".$badcontent."'>
									</td>
								</tr>
								<tr>
									<td>
										<b>Ban Description</b>
									</td>
									<td>
										<input name='BanDescription' type='text' style='width:250px;'>
									</td>
								</tr>
							</table>
							<br />
							<form action='' method='POST'><input type='submit' name='BanAction' value='Submit'>
							</form>
					<br />
					or you can <a href='BanUser.php?ID=".$ID."&Unban=True'><b>unban</b></a>
					
					";
					$Unban = mysql_real_escape_string(strip_tags(stripslashes($_GET['Unban'])));
						$getUser = mysql_query("SELECT * FROM Users WHERE ID='".$ID."'");
						$gU = mysql_fetch_object($getUser);
						if ($Unban == "True") {
						mysql_query("UPDATE Users SET Ban='0' WHERE ID='".$ID."'");
						mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','unbanned $gU->Username','".$_SERVER['PHP_SELF']."')");
						header("Location: user.php?ID=$ID");
						}
					
					$BanType = mysql_real_escape_string(strip_tags(stripslashes($_POST['BanType'])));
					$BanTime = mysql_real_escape_string(strip_tags(stripslashes($_POST['BanTime'])));
					$BanDescription = mysql_real_escape_string(strip_tags(stripslashes($_POST['BanDescription'])));
					$BanAction = mysql_real_escape_string(strip_tags(stripslashes($_POST['BanAction'])));
					$BanContent = mysql_real_escape_string(strip_tags(stripslashes($_POST['BanContent'])));
					
						if ($BanAction) {
						
							if ($BanTime == "0") {
							
								$BanTime1 = time();
							
							}
							if ($BanTime == "1") {
							
								$BanTime1 = time() + 86400;
							
							}
							if ($BanTime == "3") {
							
								$BanTime1 = time() + 86400*3;
							
							}
							if ($BanTime == "7") {
							
								$BanTime1 = time() + 86400*7;
							
							}
							if ($BanTime == "14") {
							
								$BanTime1 = time() + 86400*14;
							
							}
							if ($BanTime == "forever") {
							
								$BanTime1 = "forever";
							
							}
							
							//ok, insert
								$getUser = mysql_query("SELECT * FROM Users WHERE ID='".$ID."'");
								$gU = mysql_fetch_object($getUser);
							mysql_query("UPDATE Users SET Ban='1' WHERE ID='".$ID."'");
							mysql_query("UPDATE Users SET BanType='".$BanType."' WHERE ID='".$ID."'");
							mysql_query("UPDATE Users SET BanTime='".$BanTime1."' WHERE ID='".$ID."'");
							mysql_query("UPDATE Users SET BanDescription='".$BanDescription."' WHERE ID='".$ID."'");
							mysql_query("UPDATE Users SET BanLength='".$BanTime."' WHERE ID='".$ID."'");
							mysql_query("UPDATE Users SET BanContent='".$BanContent."' WHERE ID='".$ID."'");
							mysql_query("UPDATE Users SET TimeBanned='".time()."' WHERE ID='".$ID."'");
							$now = time();
							
							mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','banned $gU->Username for $BanTime days','".$_SERVER['PHP_SELF']."')");
							
							mysql_query("INSERT INTO BanHistory (UserID, BanType, BanTime, BanDescription, BanLength, BanContent, WhoBanned)
							VALUES('".$ID."','".$BanType."','".$BanTime1."','".$BanDescription."','".$BanTime."','".$BanContent."','$myU->ID')
							");
							
							header("Location: index.php");
						
						}
						
						}
						else {
						header("Location: index.php");
						}
?>