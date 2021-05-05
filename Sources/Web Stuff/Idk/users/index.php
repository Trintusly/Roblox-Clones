<?php
include "../Header.php";
$Setting = array(
	"PerPage" => 14
);
$PerPage = 12;
$Page = $_GET['Page'];
if ($Page < 1) { $Page=1; }
if (!is_numeric($Page)) { $Page=1; }
$Minimum = ($Page - 1) * $Setting["PerPage"];
//for
$getall = mysql_query("select * from Users");
$all = mysql_num_rows($getall);
//query
$allusers = mysql_query("SELECT * FROM Users ORDER BY ID");
$num = mysql_num_rows($allusers);
$i = 0;
$Num = ($Page+8);
$a = 1;
$Log = 0;
	
	$Online = mysql_query("SELECT * FROM Users WHERE  $now < expireTime");
	$Online = mysql_num_rows($Online);

echo "
<center>
<table width='95%'>
	<tr>
		<td style='padding-left:50px;' width='850' valign='top'>
			<div id='LargeText'>
				Browse Users (".$all.")
			</div>
			<div id=''><center>
			<form action='' method='POST'>
				<table cellspacing='0' cellpadding='0'>
					<tr>
						<td>
							<b>Search:</b> <input type='text' name='Q' value='".$Q."'> <input type='submit' name='S' value='Search'>
						</td>
						<td style='padding-left:50px;'>
							<a href='/online.php'><b>Online (".$Online.")</b></a>
						</td>
					</tr>
				</table>
			</form>
			</div>
		</td>

	</tr>
</table>
<table>
	<tr>

";

	$Q = mysql_real_escape_string(strip_tags(stripslashes($_POST['Q'])));
	$S = mysql_real_escape_string(strip_tags(stripslashes($_POST['S'])));

		if ($S) {
		
			$getMembers = mysql_query("SELECT * FROM Users WHERE Username LIKE '%$Q%' ORDER BY ID ASC LIMIT {$Minimum},  ". $Setting["PerPage"]);
			
		while ($gM = mysql_fetch_object($getMembers)) {
		
			$counter++;

			echo "<td align='center' width='125'><a href='../user.php?ID=".$gM->ID."' border='0'>";
		
			echo "<img src='https://brickplanet.gq/Avatar.php?ID=$gM->ID'><br />";
			echo "<b><font color='black' style='font-size:8pt;'>" . $gM->Username . "</font></b>";
			echo "</a></td>";
			
			if ($counter >= 7) {
			
				echo "</tr><tr>";
				$counter = 0;
			
			}
		
		}
		
		}
		else {
	
			$getMembers = mysql_query("SELECT * FROM Users ORDER BY ID ASC LIMIT {$Minimum},  ". $Setting["PerPage"]);
	
	}
	
		$counter = 0;
		if (!$S) {
		while ($gM = mysql_fetch_object($getMembers)) {
		
			$counter++;
		
			echo "<td align='center' width='125'><a href='../user.php?ID=".$gM->ID."' border='0'>";
		
			echo "<img src='https://brickplanet.gq/Avatar.php?ID=$gM->ID'><br />";
			echo "<b><font color='black' style='font-size:8pt;'>" . $gM->Username . "</font></b>";
			echo "</a></td>";
			
			if ($counter >= 7) {
			
				echo "</tr><tr>";
				$counter = 0;
			
			}
		
		}
		}
		
		echo "</tr></table>";
		
		$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="/users/?Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="/users/?Page='.($Page+1).'">Next</a>';
}

include "../Footer.php";
?>