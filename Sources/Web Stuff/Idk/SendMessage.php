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
		
			$getReceive = mysql_query("SELECT * FROM Users WHERE ID='$ID'");
			$gR = mysql_fetch_object($getReceive);
		
			echo "
			<div id='TopBar'>
				Send PM to ".$gR->Username."
 			</div>
			<div id='aB'>
			<center><form action='' method='POST'>
				<table>
					<tr>
						<td>
							<b>Title:</b>
							<br />
							<input type='text' style='width:500px;' name='Title'>
						</td>
					</tr>
					<tr>
						<td>
							<b>Body:</b>
							<br />
							<textarea name='Body' rows='5' cols='40' style='width:500px;'></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type='submit' name='Submit' value='Send'>
						</td>
					</tr>
				</table>
			</center></form>
			</div>
			";
			$Title = mysql_real_escape_string(strip_tags(stripslashes($_POST['Title'])));
			$Body = mysql_real_escape_string(strip_tags(stripslashes($_POST['Body'])));
			$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
			
				if ($Submit) {
				
					if (!$Title||!$Body) {
					
						echo "Please fill in all fields!";
					
					}
					elseif (strlen($Body) > 1000) {
					
						echo "Your body is too long!";
					
					}
					elseif (strlen($Title) > 250) {
					
						echo "Your title is too long!";
					
					}
					else {
					
						//block profanity
						
						$Title = filter($Title);
						$Body = filter($Body);
						
						mysql_query("INSERT INTO PMs (SenderID, ReceiveID, Title, Body, time) VALUES('".$myU->ID."','".$ID."','".$Title."','".$Body."','".$now."')");
						
						header("Location: user.php?ID=".$ID."");
					
					}
				
				}
		
		}

include "Footer.php";