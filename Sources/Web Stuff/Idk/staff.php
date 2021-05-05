<?php

	include "Header.php";
	
	$getStaff = mysql_query("SELECT * FROM Users WHERE PowerAdmin='true' OR PowerMegaModerator='true' OR PowerForumModerator='true' OR PowerArtist='true'");
	
	while ($gS = mysql_fetch_object($getStaff)) {
	echo $gS->Username . "<br />";
	}

?>