<?php
	include "Header.php";
	
		$getUsers = mysql_query("SELECT * FROM Users ORDER BY ID ASC");
		
		while ($gU = mysql_fetch_object($getUsers)) {
		
				$NumFriends = mysql_query("SELECT * FROM FRs WHERE ReceiveID='$gU->ID' AND Active='1'");
				$NumFriends = mysql_num_rows($NumFriends);
				
				if ($NumFriends >= 15) {
				
					echo "$gU->Username ($gU->ID) with $NumFriends friends<br />";
				
				}
		
		}
	
	include "Footer.php";
?>