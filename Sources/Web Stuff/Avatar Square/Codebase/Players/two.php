<?php
include('../header.php');
echo "<div class='container'>";
$getUsers = mysql_query("SELECT * FROM Users ORDER BY RAND() LIMIT 0, 10");
$getUC = mysql_query("SELECT * FROM Users");
$gUC = mysql_num_rows($getUC);
echo "<div style='margin-bottom: 20px;'><font color='red'>USERS ARE ORDERED AT RANDOM</font><div style='float: right; display: inline-block;'><font color='green'>$gUC users are registered @ Vintrix! </font> <a href='staff.php'>Staff Members</a> | <a href='online.php'>Online Users</a></div></div>";
while($gU = mysql_fetch_object($getUsers)) {
	echo "
	<fieldset>"; 
	if($gUC->Username == "Trimetis") {
		echo"<font color='red'><a href='Profile.php?ID=$gU->ID'>$gU->Username</a></font><div class='line'></div><div style='padding-left:60px; display: inline-block;'>Status: <i>$gU->Status</i></div></fieldset><br />";
	}else{
		echo"<a href='Profile.php?ID=$gU->ID'>$gU->username</a><div class='line'></div><div style='padding-left:60px; display: inline-block;'>Status: <i>$gU->Status</i></div></fieldset><br />
	";
}
}
 echo "
 </div>
 ";
?>