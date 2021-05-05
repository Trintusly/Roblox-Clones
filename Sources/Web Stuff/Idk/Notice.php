<?php
	include "Header.php";
	
		if ($User) {
		
			echo "
			<div id='LargeText'>
				Notice
			</div>
			There is a new worldwide notice for all users to read. Please read:
			<br />
			<br />
			
			";
			
			$getNotice = mysql_query("SELECT * FROM Notice");
			$gN = mysql_fetch_object($getNotice);
			
			$getPoster = mysql_query("SELECT * FROM Users WHERE ID='$gN->UserID'");
			$gP = mysql_fetch_object($getPoster);
			
			echo "
			<center>
				<div id='Login' style='width:800px;'>
					<center>
						$gN->Text
					</center>
					<br />
					<div align='left'>
					Posted by <b>$gP->Username</b>
					</div>
				</div>
			</center>
			<br />
			<br />
			You may now browse the website.
			";
		
		}
	
	include "Footer.php";
?>