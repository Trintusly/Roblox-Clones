<?php
include "Header.php";

	if (!$User) {
	header("Location: index.php");
	}
	
		echo "
		<div id='TextWrap'>
		My Referrals
		</div>
		<div id=''>
			Hi $myU->Username, here is a list of your successful referrals.
			<br />
			<br />
			";
			$getReferrals = mysql_query("SELECT * FROM Referrals WHERE ReferredID='".$myU->ID."'");
			echo "<table><tr>";
			while ($gR = mysql_fetch_object($getReferrals)) {
			
				$getUser = mysql_query("SELECT * FROM Users WHERE ID='".$gR->UserID."'");
				$gU = mysql_fetch_object($getUser);
			
				echo "
				<td>
					<center>
					<a href='../user.php?ID=".$gU->ID."'>
					<img src='../Avatar.php?ID=".$gR->UserID."'>
					<br />
					<b>".$gU->Username."</b>
					</a>
				</td>
				";
				echo "</tr></table>";
			
			}
			$getS = mysql_query("SELECT * FROM Referrals WHERE ReferredID='$myU->ID'");
			$Num = mysql_num_rows($getS);
			
				if ($Num == 0) {
				echo "<b>No referrals found.</b>";
				}
			echo "
		</div>
		";
	