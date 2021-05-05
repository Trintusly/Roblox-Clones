<?php
include "Header.php";
$Setting = array(
	"PerPage" => 15
);
$PerPage = 12;
$Page = mysql_real_escape_string(strip_tags(stripslashes($_GET['Page'])));
if ($Page < 1) { $Page=1; }
if (!is_numeric($Page)) { $Page=1; }
$Minimum = ($Page - 1) * $Setting["PerPage"];
//query
$num = mysql_num_rows($allusers = mysql_query("SELECT * FROM PMs WHERE ReceiveID='$myU->ID' ORDER BY ID"));
$Num = ($Page+8);

	if (!$User) {
	
		header("Location: index.php");
		exit;
	
	}
	
	echo "
	<div id='LargeText'>
		My PMs (".$PMs.")
	</div>
	<center>
";
$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="inbox.php?Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="inbox.php?Page='.($Page+1).'">Next</a>';
}
echo "	</center>
		<table cellspacing='0' cellpadding='0'>
			<tr>
				<td style='width:50px;'>
					<b>Action</b>
				</td>
				<td style='width:200px;'>
					<b>Sender</b>
				</td>
				<td style='width:600px;'>
					<b>Title</b>
				</td>
				<td>
					<b>Date Sent</b>
				</td>
			</tr>
		</table>
		";

		echo "
		<div style='border-bottom:1px solid #ddd;width:99%;'></div>
		";
		
			
			//while loop
			$getPMs1 = mysql_query("SELECT * FROM PMs WHERE ReceiveID='$myU->ID' ORDER BY ID DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
			while ($gP = mysql_fetch_object($getPMs1)) {
			
				echo "
		<table cellspacing='0' cellpadding='0' id='aBForum' style='border-top:0;font-size:10pt;padding:10px;' width='99%'>
			<tr>
				<td style='width:50px;'>
					<input type='checkbox' name='Test' value='$gP->ID'>
				</td>
				<td style='width:200px;'>
					";
					$getSender = mysql_query("SELECT * FROM Users WHERE ID='".$gP->SenderID."'");
					$gS = mysql_fetch_object($getSender);
					echo "
					<a href='../user.php?ID=$gS->ID'>".$gS->Username."</a>
				</td>
				<td style='width:600px;'>
				";
				if ($gP->LookMessage == "0") {
				$Title = "<a href='/ViewMessage.php?ID=$gP->ID' style=''>$gP->Title</a>";
				}
				else {
				$Title = "<a style='font-weight:normal;' href='/ViewMessage.php?ID=$gP->ID' style=''>$gP->Title</a>";
				}
				echo "
				$Title
				</td>
				<td>
					";
					$Display1 = date("F j, Y",$gP->time);
					$Display2 = date("g:iA",$gP->time);
					echo "
					$Display1 $Display2
				</td>
			</tr>
		</table>
				";
			
			}
		
		echo "
		<center>
		";
$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="inbox.php?Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="inbox.php?Page='.($Page+1).'">Next</a>';
}
		echo "
	</center>
	";
include "Footer.php";