<?php
	include "Header.php";
	
	if ($myU->PowerAdmin != "true" || !$User) {
	
		header("Location: /index.php");
	
	}
		if ($myU->PowerAdmin == "false"||$myU->PowerMegaModerator == "false") {
		header("Location: index.php");
		}
		else {
		
			$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
			
			if (!$ID) {
			
				echo "<b>Please include an ID!</b>";
			
			}
			else {
			
				$getIPs = mysql_query("SELECT * FROM UserIPs WHERE UserID='$ID' AND UserID='$ID'");
				$Exist = mysql_num_rows($getIPs);
				
					if ($Exist == 0) {
					
						echo "<b>User not found!</b>";
					
					}
					else {
					
						while ($gI = mysql_fetch_object($getIPs)) {
						
							$getAccount = mysql_query("SELECT * FROM Users WHERE IP='$gI->IP'");
							$gA = mysql_fetch_object($getAccount);
						
							echo "<a href='ViewOtherAccounts.php?ID=$gA->ID'>".$gI->IP."</a><br />";
						
						}
					
					}
			
			}
		
		}
	
	include "Footer.php";

?>