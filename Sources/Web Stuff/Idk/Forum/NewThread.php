<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
if ($User) {
	$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
	$gT = mysql_num_rows($getTopic = mysql_query("SELECT * FROM Topics WHERE ID='$ID'"));
	
		if (!$ID) {
		
			echo "<b>Error";
		
		}
		elseif ($gT == "0") {
		
			echo "<b>This topic does not exist!</b>";
		
		}
		else {
		
			echo "
			<div id='LargeText'>
				Create a thread
			</div>
			<center>
			
			<form action='' method='POST'>
				<table>
					<tr>
						<td style='padding:5px;'>
							<b>Title</b>
						</td>
						<td style='padding:5px;'>
							<input type='text' name='Title' style='width:450px;'>
						</td>
					</tr>
					<tr>
						<td valign='top' style='padding:5px;'>
							<b>Body</b>
						</td>
						<td style='padding:5px;'>
							<textarea name='Body' style='width:450px;height:200px;'></textarea>
						</td>
					</tr>
					";
			if ($myU->PowerAdmin == "true"||$myU->PowerForumModerator == "true"||$myU->PowerMegaModerator == "true") {
			
				echo "
				<tr>
					<td style='padding:5px;'>
						<b>Type</b>
					</td>
					<td style='padding:5px;'>
						<select name='Type'>
							<option value='regular'>Regular</option>
							<option value='sticky'>Sticky</option>
						</select>
					</td>
				</tr>
				";
			
			}
					echo "
					<tr>
						<td>
							<input type='submit' name='Submit' value='Post'>
						</td>
					</tr>
				</table>
			
			";
			echo "</form>";
			
			$Title = mysql_real_escape_string(strip_tags(stripslashes($_POST['Title'])));
			$Body = mysql_real_escape_string(strip_tags(stripslashes($_POST['Body'])));
			$Type = mysql_real_escape_string(strip_tags(stripslashes($_POST['Type'])));
			$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
			
				if ($Submit) {
				
					if (!$Title||!$Body) {
					
						echo "<b>Your title or body is empty!</b>";
					
					}
					elseif (strlen($Title) < 4) {
					
						echo "<b>Your title is too short!</b>";
					
					}
					elseif (strlen($Title) > 249) {
					
						echo "<b>Your title is too long!</b";
					
					}
					elseif (strlen($Body) < 4) {
					
						echo "<b>Your body is too short!</b>";
					
					}
					elseif (strlen($Body) > 15000) {
					
						echo "<b>Your body is over 15,000 characters!</b";
					
					}
					else {
					
						$Title = filter($Title);
						$Body = filter($Body);
					
					
						if ($myU->PowerAdmin == "false"||$myU->PowerForumModerator == "false"||$myU->PowerAdmin == "false") {
						
						$Type = "regular";
						
						}
						if ($now < $myU->forumflood) {
						echo "You are posting too fast, please wait.";
						}
						else {
						$flood = $now + 10;
						mysql_query("UPDATE Users SET forumflood='$flood' WHERE ID='$myU->ID'");
						mysql_query("INSERT INTO Threads (Title, Body, PosterID, Type, tid, bump) VALUES('$Title','$Body','$myU->ID','$Type','$ID','$now')");
						$getNew = mysql_query("SELECT * FROM Threads WHERE Title='$Title' AND Body='$Body' AND PosterID='$myU->ID' AND tid='$ID' AND bump='$now'");
						$gN = mysql_fetch_object($getNew);
						header("Location: ViewThread.php?ID=$gN->ID");
						}
					
					}
				
				}
		
		}
		}

include($_SERVER['DOCUMENT_ROOT']."/Footer.php");