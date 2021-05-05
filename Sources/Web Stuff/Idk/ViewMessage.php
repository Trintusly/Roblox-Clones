<?php
include "Header.php";

	$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
	
		if (!$User) {
		
			header("Location: index.php");
		
		}
		if (!$ID) {
		
			echo "<b>Please include an ID!</b>";
			exit;
		
		}
		else {
		
			$getMessage = mysql_query("SELECT * FROM PMs WHERE ID='$ID'");
			$gM = mysql_fetch_object($getMessage);
			
				if ($gM->ReceiveID != $myU->ID) {
				
					echo "<b>Error.</b>";
					exit;
					
				}
				if ($gM->LookMessage == "0") {
				mysql_query("UPDATE PMs SET LookMessage='1' WHERE ID='$ID'");
				header("Location: ViewMessage.php?ID=$ID");
				}
				//sender id
				
				$getSender = mysql_query("SELECT * FROM Users WHERE ID='$gM->SenderID'");
				$gS = mysql_fetch_object($getSender);
				$Method = mysql_real_escape_string(strip_tags(stripslashes($_GET['Method'])));
				if (!$Method) {
				echo "
				<div id='LargeText'>
					".$gM->Title."
				</div>
				<div id=''>
					<table>
						<tr>
							<td width='125' valign='top'><center>
								<a href='user.php?ID=".$gS->ID."' style='color:black;'>
								<img src='Avatar.php?ID=".$gS->ID."'>
								<br />
								<b>".$gS->Username."</b>
								</a>
							</td>
							<td valign='top'>
								".nl2br($gM->Body)."
								<br />
								<br />
								<a href='ViewMessage.php?ID=$ID&Method=Reply' style='color:blue;font-weight:bold;'>Reply</a> | <a href='ViewMessage.php?ID=$ID&Method=Delete' style='color:blue;font-weight:bold;'>Delete</a>
							</td>
						</tr>
					</table>
				</div>
				";
				}
				
					if ($Method == "Reply") {
					
						echo "
						
						<div id='ProfileText'>
							Reply to ".$gS->Username."
						</div>
						<center>
						<div id='aB'>
						<form action='' method='POST'>
							<table>
								<tr>
									<td>
<textarea name='Body' rows='6' cols='40' style='width:500px;'>


_________________________________________
Sent by ".$gS->Username."
".$gM->Body."
</textarea>
									</td>
								</tr>
								<tr>
									<td>
										<input type='submit' name='SubmitReply' value='Send'>
									</td>
								</tr>
							</table>
						</form>
						</div>
						";
						$Body = mysql_real_escape_string(strip_tags(stripslashes($_POST['Body'])));
						$SubmitReply = mysql_real_escape_string(strip_tags(stripslashes($_POST['SubmitReply'])));
						
							if ($SubmitReply) {
							
								$Body = filter($Body);
								mysql_query("INSERT INTO PMs (SenderID, ReceiveID, Title, Body, time) VALUES('$myU->ID','$gM->SenderID','RE: $gM->Title','".$Body."','".$now."')");
								header("Location: user.php?ID=".$gS->ID."");
							
							}
					
					}
					elseif ($Method == "Delete") {
					
						mysql_query("DELETE FROM PMs WHERE ID='$ID'");
						header("Location: inbox.php");
					
					}
		
		}

include "Footer.php";