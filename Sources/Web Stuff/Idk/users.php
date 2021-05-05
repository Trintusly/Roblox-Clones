<?php
include "Header.php";
$Setting = array(
	"PerPage" => 12
);
$PerPage = 12;
$Page = mysql_real_escape_string(strip_tags(stripslashes($_GET['Page'])));
if ($Page < 1) { $Page=1; }
if (!is_numeric($Page)) { $Page=1; }
$Minimum = ($Page - 1) * $Setting["PerPage"];
$allusers = mysql_query("SELECT * FROM Users");
$num = mysql_num_rows($allusers);
//query


	//search
	$q = mysql_real_escape_string(strip_tags(stripslashes($_POST['q'])));
	$s = mysql_real_escape_string(strip_tags(stripslashes($_POST['s'])));
	echo "
	<form action='' method='POST'>
		<center><div id='aB' style='width:90%;border-top-left-radius:5px;border-top-right-radius:5px;'>
			<center>
				<table>
					<tr>
						<td style='padding-right:90px;'>
							<b>Users: </b>"; $Users = mysql_num_rows($Users = mysql_query("SELECT * FROM Users")); echo "".number_format($Users)."
						</td>
						<td>
							<b>Search:</b>
						</td>
						<td>
							<input type='text' name='q'> <input type='submit' name='s' value='Search'/>
						</td>
						<td style='padding-left:90px;'>
						<a href='online.php'><b>Online (".$NumOnline = mysql_num_rows($NumOnline = mysql_query("SELECT * FROM Users WHERE $now < expireTime")).")</b></a>
						</td>
					</tr>
				</table>
			</center>
		</div>
	</form>
	<Br />
	";
	echo "<center>
	
	<table width='95%'><tr>";
	if (!$s) {
	$getMembers = mysql_query("SELECT * FROM Users WHERE Ban='0' ORDER BY ID ASC LIMIT {$Minimum},  ". $Setting["PerPage"]);
	}
	else {
	$getMembers = mysql_query("SELECT * FROM Users WHERE Username LIKE '%$q%' ORDER BY ID");
	}
		$counter = 0;
		if (!$s) {
		while ($gM = mysql_fetch_object($getMembers)) {
			$counter++;
			echo "<td width='125'><center><a href='user.php?ID=$gM->ID' border='0'><img src='Avatar.php?ID=$gM->ID' border='0'><br /><smalltextlink>$gM->Username</smalltextlink></a></td>";
			if ($counter>= 6) {
				echo "</tr><tr>";
				$counter = 0;
			}
		}
		}
		else {
		
				while ($gM = mysql_fetch_object($getMembers)) {
			$counter++;
			echo "<td width='125'><center><a href='user.php?ID=$gM->ID' border='0'><img src='Avatar.php?ID=$gM->ID' border='0'><br />$gM->Username</a></td>";
			if ($counter>= 6) {
				echo "</tr><tr>";
				$counter = 0;
			}
			}
		
		}
	echo "</tr></table><center>";
$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="users.php?Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="users.php?Page='.($Page+1).'">Next</a>';
}


include "Footer.php";