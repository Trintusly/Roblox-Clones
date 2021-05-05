<?php
include "Header.php";
$Setting = array(
	"PerPage" => 16
);
$PerPage = 12;
$Page = mysql_real_escape_string(strip_tags(stripslashes($_GET['Page'])));
if ($Page < 1) { $Page=1; }
if (!is_numeric($Page)) { $Page=1; }
$Minimum = ($Page - 1) * $Setting["PerPage"];
//query
$num = mysql_num_rows($allusers = mysql_query("SELECT * FROM Users WHERE $now < expireTime"));
$Num = ($Page+8);
			$OnlineNow = mysql_query("SELECT * FROM Users WHERE $now < expireTime  LIMIT {$Minimum},  ". $Setting["PerPage"]);
			$NumOnline = mysql_num_rows($OnlineNow);
	echo "
	<div id='SeeWrap'>
		<div id='LargeText'>
			Online ($num)
		</div>
	<table><tr>
		";
			$now = time();
			$counter = 0;

			while ($O = mysql_fetch_object($OnlineNow)) { 
				$counter++;
				echo "
				<td width='125'>
				<center>
				<a href='user.php?ID=$O->ID' style='border:0;' title='".$O->Username."'>
				<img src='/Avatar.php?ID=$O->ID'  style='border:0;' title='".$O->Username."'>
				<br />
				<smalltextlink>".$O->Username."</smalltextlink>
				</a>
				</td>
				";
				if ($counter >= 8) {
				
					echo "</tr><tr>";
					$counter = 0;
				
				}
			
			}
		
		echo "
		</tr></table><center>
	";
	
$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="online.php?Page='.($Page-1).'">Prev</a> - ';
}
echo 'Page '.$Page.' out of '.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="online.php?Page='.($Page+1).'">Next</a>';
}
	
	echo "
	</div>
	";


include "Footer.php";
?>