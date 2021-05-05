<?php
include "Header.php";
if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true"||$myU->PowerImageModerator == "true")
{

$getPending = mysql_query("SELECT * FROM UserStore WHERE active='0'");
$num_pending = mysql_num_rows($getPending);
if($num_pending == "0")
{
	echo "<b>No items to be moderated.</b>";
}

else
{
echo "

";
echo "<table style='font-size:10pt;'><tr>";
while ($gP = mysql_fetch_object($getPending))
{
$counter++;
$gcreator = mysql_query("SELECT * FROM Users WHERE ID='".$gP->CreatorID."'");
$gc = mysql_fetch_object($gcreator);

	echo "
	
	<td id='unApproveditem' width='400' style='padding:5px;'>
	<center>
	<img src='/Store/Dir/".$gP->File."' width='100' height='200'>
	<br>
	<div align='left'>
	<br>
	<table width='100%'>
		<tr>
			<td>
				<b>
					Name:
				</b>
			</td>
			<td>
				$gP->Name
			</td>
		</tr>
			<td>
				<font color='green'>
					<b>
						BUX:
					</b>
				</font>
			</td>
			<td>
				<font color='green'>
					<b>
						".$gP->Price."
					</b>
				</font>
			</td>
		</tr>
		<tr>
			<td>
				<b>
					Creator:
				</b>
			</td>
			<td>
				".$gc->Username."
			</td>
		</tr>
		<tr>
			<td>
				<b>Type:</b>
			</td>
			<td>
				".$gP->Type."
			</td>
		</tr>
		<tr>
			<td>
				
			</td>
		</tr>
	</table>
<a href='?Accept=Yes&ID=".$gP->ID."'><font color='green'>Accept</font></a> / <a href='?Accept=No&ID=".$gP->ID."'><font color='red'>Deny</font></a>
<br /><br />
	</div>
	</td>";
if ($counter >= 4) {

	echo "</tr><tr>";
	$counter = 0;

}

}

$Accept = mysql_real_escape_string(strip_tags(stripslashes($_GET['Accept'])));
$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));

if($Accept == "Yes" && $ID)
{

	mysql_query("UPDATE UserStore SET active='1' WHERE ID='$ID'");
	$Uploader = "".$gP->Username."";
	header("Location: /ItemModeration.php");

}

if($Accept == "No" && $ID)
{
	$File = "Dir/".$gP->File."";
	unlink($File);
	mysql_query("DELETE FROM UserStore WHERE ID='$ID'");
	header("Location: /ItemModeration.php");

}
}


}
echo "</tr></table>";
include "Footer.php";