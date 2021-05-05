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
?>
<form action='' method="POST">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<font id='Text'>Banner Text:</font><Br /><br />
				<textarea name='BannerText' rows='5' cols='80'><?=$gB->Text?></textarea>
				<br />
				<input type='submit' name='Submit' value='Update Changes' />
				<?php
				$BannerText = mysql_real_escape_string(strip_tags(stripslashes($_POST['BannerText'])));
				$Submit = $_POST['Submit'];
				
					if ($Submit) {
					
						$BannerText = filter($BannerText);
						
						$BannerText = "$BannerText";
					
						mysql_query("UPDATE Banner SET Text='".$BannerText."'");
mail ("topbar@social-paradise.net", "Announcement Change :: $myU->Username", "$BannerText");
						header("Location: ?tab=$tab");
					
					}


				?>
			</td>
		</tr>
	</table>
</form>
<form action='' method="POST">
	<table cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<font id='Text'>Enabled Features:</font><Br /><br />
				<table>
					<tr>
						<td>
							<div id='Text'>Register</div>
						</td>
						<?php
						$Configuration = mysql_fetch_object($Configuration = mysql_query("SELECT * FROM Configuration"));
						$MaintenanceEnabled = mysql_real_escape_string(strip_tags(stripslashes($_POST['_MaintenanceEnabled'])));
						$RegisterEnabled = mysql_real_escape_string(strip_tags(stripslashes($_POST['_RegisterEnabled'])));
						$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['_Submit'])));
						
							if ($Submit) {
							
								if (!$RegisterEnabled) {
								
									$RegisterEnabled = "false";
								
								}
								if (!$MaintenanceEnabled) {
								
									$MaintenanceEnabled = "false";
								
								}
								
								
								mysql_query("UPDATE Configuration SET Register='$RegisterEnabled'");
								mysql_query("UPDATE Maintenance SET Status='$MaintenanceEnabled'");
								
								header("Location: ?tab=configuration");
							
							}
						?>
						<td style='padding-left:150px;'>
							<input type='checkbox' name='_RegisterEnabled' value='true' <?php if ($Configuration->Register == "true") { echo 'checked'; } ?>/>
						</td>
					</tr>
					<tr>
						<td>
							<div id='Text'>Maintenance</div>
						</td>
						<td style='padding-left:150px;'>
							<input type='checkbox' name='_MaintenanceEnabled' value='true' <?php if ($Maintenance->Status == "true") { echo 'checked'; } ?>/>
						</td>
					</tr>
				</table>
				<input type='submit' name='_Submit' value='Update Changes' />
		</tr>	
	</table>
</form>