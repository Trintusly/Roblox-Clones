<?php

	include "Header.php";
	
		if (!$User) {
		
			header("Location: index.php");
		
		}
		
		if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true") {
		
		
		
			$getLogos = mysql_query("SELECT * FROM GroupsLogo");
			
			while ($gL = mysql_fetch_object($getLogos)) {
			
				echo "
				<table>
					<tr>
						<td><center>
							<div style='width:100px;height:100px;border:1px solid #ddd;padding:5px;'>
								<img src='../Groups/GL/".$gL->Logo."' height='100' width='100'>
							</div>
							";
							$getGroup = mysql_query("SELECT * FROM Groups WHERE ID='$gL->GroupID'");
							$gG = mysql_fetch_object($getGroup);
							
							echo "
							".$gG->Name."
							<br />
							<a href='?GroupID=$gG->ID&Action=Accept'><font color='green'><b>Accept</b></font></a> / <a href='?GroupID=$gG->ID&Action=Deny'><font color='red'><b>Deny</b></font></a>
						</td>
					</tr>
				</table>
				";
			
			}
			
			$GroupID = mysql_real_escape_string(strip_tags(stripslashes($_GET['GroupID'])));
			$Action = mysql_real_escape_string(strip_tags(stripslashes($_GET['Action'])));
			
			if ($GroupID) {
			
				
			
				$checkGroup = mysql_query("SELECT * FROM Groups WHERE ID='$GroupID'");
				$GroupExist = mysql_num_rows($checkGroup);
				
				$getLogos = mysql_query("SELECT * FROM GroupsLogo WHERE GroupID='$GroupID'");
				$gL = mysql_fetch_object($getLogos);
				
				if ($GroupExist == 0) {
				
					die("Error with ID.");
				
				}
				$cG = mysql_fetch_object($checkGroup);
				if ($Action == "Accept") {
				mysql_query("UPDATE Groups SET Logo='".$gL->Logo."' WHERE ID='$GroupID'");
				mysql_query("DELETE FROM GroupsLogo WHERE GroupID='$GroupID'");
				header("Location: ModerateLogos.php");
				}
				else {
				
				mysql_query("DELETE FROM GroupsLogo WHERE GroupID='$GroupID'");
				header("Location: ModerateLogos.php");	
				
				}
			
			}
		
		}
		else {
		header("Location: ../index.php");
		}
		
		include "Footer.php";