<?php

	include "Header.php";
	
	$getRich = mysql_query("SELECT * FROM Users WHERE Bux > 300 ORDER BY Bux DESC");
	$counter = 0;
	while ($gR = mysql_fetch_object($getRich)) {
	$counter++;
		echo "
		<table>
			<tr>
				<td>
				".$counter.".	$gR->Username ($gR->ID) with $gR->Bux BUX
				</td>
			</tr>
		</table>
		";
	
	}
	
	$getusers = mysql_query("SELECT * FROM Users ORDER BY ID ASC");
	
	
	include "Footer.php";

?>