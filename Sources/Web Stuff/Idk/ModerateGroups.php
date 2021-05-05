<?php

	include "Header.php";
	
		if (!$User) {
		
			header("Location: index.php");
		
		}
		
		if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true") {
		
		
			$getGroups = mysql_query("SELECT * FROM GroupsPending ORDER BY ID DESC");
			
			echo "<table><tr>";
			
			while ($gG = mysql_fetch_object($getGroups)) {
			
				$getCreator = mysql_query("SELECT * FROM Users WHERE ID='".$gG->OwnerID."'");
				$gC = mysql_fetch_object($getCreator);
			
				echo "
				<td>
					<center>
					<div style='border:1px solid #ddd;padding:5px;height:100px;width:100px;'>
						<img src='../Groups/GL/".$gG->Logo."' width='100' height='100'>
					</div>
					<b>".$gG->Name."</b>
					<br />
					<div align='left'>
					
						<b>Creator:</b> ".$gC->Username."
						
					</div>
					<br />
					<a href='?GroupID=$gG->ID&Action=Accept'><font color='green'><b>Accept</b></font></a> / <a href='?GroupID=$gG->ID&Action=Deny'><font color='red'><b>Deny</b></font></a>
				</td>
				";
				
				
			}
			
			$GroupID = mysql_real_escape_string(strip_tags(stripslashes($_GET['GroupID'])));
			$Action = mysql_real_escape_string(strip_tags(stripslashes($_GET['Action'])));
			
			if ($GroupID && $Action) {
			
				//check if group id is real
				$checkGroup = mysql_query("SELECT * FROM GroupsPending WHERE ID='$GroupID'");
				$GroupActive = mysql_num_rows($checkGroup);
				
				if ($GroupActive > 0) {
					$getGroup = mysql_query("SELECT * FROM GroupsPending WHERE ID='$GroupID'");
					$gG = mysql_fetch_object($getGroup);
					//success checking if group is found in database
					
					if ($Action == "Accept") {
					
						$Name = mysql_real_escape_string(strip_tags(stripslashes($gG->Name)));
					
						//insert into main group database, and insert member into group.
						
						//make real
						mysql_query("INSERT INTO Groups (Name, Description, OwnerID, Logo) VALUES('".mysql_real_escape_string(stripslashes(strip_tags($Name)))."','".$gG->Description."','".$gG->OwnerID."','".$gG->Logo."')");
						
						//delete temp
						mysql_query("DELETE FROM GroupsPending WHERE ID='$gG->ID'");
						
						$getNewGroup = mysql_query("SELECT * FROM Groups WHERE OwnerID='$gG->OwnerID' AND Name='".mysql_real_escape_string(stripslashes(strip_tags($Name)))."' AND Description='$gG->Description'");
						$gN = mysql_fetch_object($getNewGroup);
						
						//make first user
						mysql_query("INSERT INTO GroupMembers (GroupID, UserID) VALUES('".$gN->ID."','".$gG->OwnerID."')");
						
						//lol k
						header("Location: ModerateGroups.php");
					
					}
					elseif ($Action == "Deny") {
					
						//delete group and send pm saying group declined
						
						mysql_query("DELETE FROM GroupsPending WHERE Name='".$gG->Name."' AND Description='".$gG->Description."' AND OwnerID='".$gG->OwnerID."'");
						header("Location: ModerateGroups.php");
					
					}
				
				}
			
			}
			
			}
			else {
			header("Location: ../index.php");
			}
			
			echo "</tr></table>";
			
		
	
	include "Footer.php";

?>