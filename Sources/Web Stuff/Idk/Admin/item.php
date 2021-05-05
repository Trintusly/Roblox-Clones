<?php
session_id();
session_start();
ob_start();
date_default_timezone_set('America/Chicago');
$connection = mysql_connect("localhost","socialis_user","tylercameron?!123");
mysql_select_db("socialis_db");

	/* Session */
	
	$User = $_SESSION['Username'];
	
	if ($User) {
	
		$MyUser = mysql_query("SELECT * FROM Users WHERE Username='".$User."'");
		$myU = mysql_fetch_object($MyUser);
	
	}
	
	if ($myU->PowerAdmin != "true") {
	header("Location: /index.php");
	}
	if ($myU->PowerAdmin != "true") {
	header("Location: /index.php");
	}
	else {
	
	}
?>
<form action='' method='POST'>
	<table cellspacing='0' cellpadding='0'>
		<tr>
			<td>
				<font id='Text'>Give Item to User</font><br /><br />
					<table>
						<tr>
							<td>
								User ID:
							</td>
							<td>
								<input type='text' name='UserID' />
							</td>
						</tr>
						<tr>
							<td>
								Item ID:
							</td>
							<td>
								<input type='text' name='ItemID'>
								<input type='submit' name='Submit' />
								<?php
									$UserID = mysql_real_escape_string(strip_tags(stripslashes($_POST['UserID'])));
									$ItemID = mysql_real_escape_string(strip_tags(stripslashes($_POST['ItemID'])));
									$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
									
										if ($Submit) {
										
											$getItem = mysql_query("SELECT * FROM Items WHERE ID='$ItemID'");
											$gI = mysql_fetch_object($getItem);
											$getGet = mysql_query("SELECT * FROM Users WHERE ID='$ItemID'");
											$gG = mysql_fetch_object($getGet);
										
											$code1 = sha1($gI->File);
											$code2 = sha1($myU->ID);
										
											mysql_query("INSERT INTO Inventory (UserID, ItemID, File, Type, code1, code2, SerialNum)
											VALUES ('".$UserID."','".$ItemID."','".$gI->File."','".$gI->Type."','".$code1."','".$code2."','".$Output."')");
mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','gave the item ".$gI->Name." to ".$gG->Username."','".$_SERVER['PHP_SELF']."')");
											header("Location: /Admin/?tab=item");
										
										}
								?>
							</td>
						</tr>
					</table>
			</td>
		</tr>
	</table>
</form>