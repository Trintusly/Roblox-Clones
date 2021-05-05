<?php
include "../Header.php";

	if ($User) {

	echo "
	<form action='' method='POST'>
		<table>
			<tr>
				<td>
					<b>Create New Wall Post:</b>
				</td>
			</tr>
			<tr>
				<Td>
					<textarea rows='2' cols='40' name='WallPost'></textarea>
				</td>
			</tr>
			<tr>
				<Td>
					<input type='submit' name='Submit'>
				</td>
			</tr>
		</table>
	</form>
	";
	
	$WallPost = SecureString($_POST['WallPost']);
	$Submit = SecureString($_POST['Submit']);
	
	if ($Submit) {
	
		if (!$WallPost) {
		die("<b>Wall post required.</b>");
		}
	
		$WallPost = filter($WallPost);
		$now = time();
		if ($now > $myU->WallFlood) {
		mysql_query("INSERT INTO Wall (PosterID, Body, time) VALUES('".$myU->ID."','".$WallPost."','".$now."')");
		header("Location: /user.php?ID=$myU->ID");
		
		$BlockFlood = 30;
		$BlockFlood = $now + $BlockFlood;
		
		mysql_query("UPDATE Users SET WallFlood='$BlockFlood' WHERE Username='$User'");
			
		
		}
		else {
		$PostAgain = $myU->WallFlood - $now;
		echo "Please wait <b>$PostAgain</b> more seconds until you can post again.";
		}
		
	
	}
	
	}
	else {
	header("Location: index.php");
	}
	
	$getWallPosts = mysql_query("SELECT * FROM Wall WHERE PosterID='".$myU->ID."' ORDER BY ID DESC");
	
		while ($gWP = mysql_fetch_object($getWallPosts)) {
		
			echo "
			<center>
			<table id='WallPost' style='width:900px;'>
				<tr>
					<td>
						<a href='../user.php?ID=".$myU->ID."'><b>".$myU->Username."</b></a>:
						".$gWP->Body."
					</td>
				</tr>
			</table>
			<br />
			";
		
		}

include "../Footer.php";