<?php

	include "../Header.php";
	
		if ($User) {
		
			echo "
			<form action='' method='POST'>
				<input type='submit' name='CreateGroup' value='Create Group' id='buttonsmall'>
			</form>
			";
			$CreateGroup = mysql_real_escape_string(strip_tags(stripslashes($_POST['CreateGroup'])));
			
			if ($CreateGroup) {
			
				header("Location: CreateGroup.php");
			
			}
		
		}
		$Setting = array(
			"PerPage" => 10
		);
		$Page = $_GET['Page'];
		if ($Page < 1) { $Page=1; }
		if (!is_numeric($Page)) { $Page=1; }
		$Minimum = ($Page - 1) * $Setting["PerPage"];
		//for
		$getall = mysql_query("select * from Items");
		$all = mysql_num_rows($getall);
		//query
		$allusers = mysql_query("SELECT * FROM Groups");
		$num = mysql_num_rows($allusers);
		$i = 0;
		$Num = ($Page+8);
		$a = 1;
		$Log = 0;
		echo "
			<div id='LargeText'>
				Browse Groups
			</div>
			<br />
		";
		$getGroups = mysql_query("SELECT * FROM Groups ORDER BY GroupMembers DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
		
		while ($gG = mysql_fetch_object($getGroups)) {
		
			$getGroupMembers = mysql_query("SELECT * FROM GroupMembers WHERE GroupID='$gG->ID'");
			$gM = mysql_num_rows($getGroupMembers);
			$gK = mysql_fetch_object($getGroupMembers);
			
			$getGroup = mysql_query("SELECT * FROM Groups WHERE ID='$gK->GroupID'");
			$getG = mysql_fetch_object($getGroup);
			
			$groupOwner = mysql_query("SELECT * FROM Users WHERE ID='$getG->OwnerID'");
			$gO = mysql_fetch_object($groupOwner);
			
			echo "
			<style>
			#group:hover {
			background:#eee;
			}
			</style>
			<table id='group'>
				<tr>
					<td valign='top'>
						<a href='Group.php?ID=".$getG->ID."'>
						<div style='width:75px;height:75px;border:1px solid #ddd;'>
							<img src='https://brickplanet.gq/Groups/GL/".$getG->Logo."' height='75' width='75'>
						</div>
						</a>
					</td>
					<td valign='top' width='600'>
						<a href='Group.php?ID=".$getG->ID."' style='text-decoration:none;'>
						<font style='font-size:12px;'>".$getG->Name."</font>
						<br />
						<font style='color:#555;font-size:10px;'>
						".$getG->Description."
						</font>
						</a>
					</td>
					<td valign='top' style='font-size:12px;padding-left:100px;'>
						Group Owner: ".$gO->Username."
						<br />
						Members: ".$gM."
					</td>
				</tr>
			</table>
			<br />
			";
		
		}
		echo "<center>";
$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="index.php?Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="index.php?Page='.($Page+1).'">Next</a>';
}
	include "../Footer.php";
	
?>