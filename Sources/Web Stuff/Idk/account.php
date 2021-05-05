<?php

	include "Header.php";
	echo "<title>Account | BrickPlanet</title>";

	if ($User) {
	
		//Description
		
		$Description 		= mysql_real_escape_string(strip_tags(stripslashes($_POST['Description'])));
		$Submit 			= mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
		$UpdateTheme 		= mysql_real_escape_string(strip_tags(stripslashes($_POST['UpdateTheme'])));
		$Submit1 			= mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit1'])));
		$Submit3 			= mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit3'])));
		$Xfire 				= mysql_real_escape_string(strip_tags(stripslashes($_POST['Xfire'])));
		$Twitter 			= mysql_real_escape_string(strip_tags(stripslashes($_POST['Twitter'])));
		$CurrentPassword 	= mysql_real_escape_string(strip_tags(stripslashes($_POST['CurrentPassword'])));
		$NewPassword 		= mysql_real_escape_string(strip_tags(stripslashes($_POST['NewPassword'])));
		$ConfirmNewPassword = mysql_real_escape_string(strip_tags(stripslashes($_POST['ConfirmNewPassword'])));
		$Submit2 			= mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit2'])));
		$Siggy				= mysql_real_escape_string(strip_tags(stripslashes($_POST['Signature'])));
		$ThemeSelect		= mysql_real_escape_string(strip_tags(stripslashes($_POST['ThemeSelect'])));



			if ($UpdateTheme) {
			
				mysql_query("UPDATE Users SET ThemeType='".$ThemeSelect."' WHERE ID='".$myU->ID."'");
				header("Location: /account.php");
			
			}
			if ($Submit) {
			
				$Description = filter($Description);
				
				mysql_query("UPDATE Users SET Description='".$Description."' WHERE Username='".$User."'") or die ("Error");
				
				header("Location: /account.php");
			
			}
			
			
			if ($Submit1) {
			
				mysql_query("UPDATE Users SET Xfire='".$Xfire."' WHERE ID='".$myU->ID."'");
				mysql_query("UPDATE Users SET Twitter='".$Twitter."' WHERE ID='".$myU->ID."'");
				
				header("Location: /account.php");
			
			}
			
			if ($Submit2) {
			
				$_OLDHASH = hash('sha512',''.$CurrentPassword.'');
				
				$_NEWHASH = hash('sha512',''.$NewPassword.'');
				$_CONFIRMNEWHASH = hash('sha512',''.$ConfirmNewPassword.'');
				
				if ($myU->Password == $_OLDHASH) {
				
					if ($_NEWHASH == $_CONFIRMNEWHASH) {
					
						mysql_query("UPDATE Users SET Password='".$_NEWHASH."' WHERE Username='".$User."'");
						
						session_destroy();
						
						header("Location: index.php");
					
					}
					else {
					
						echo "Your new password and new confirm password does not match!";
					
					}
				
				}
				else {
				
					echo "Your current password is not right!";
				
				}
			
			}
			
			if($Submit3)
			{
				
				if($Siggy)
				{
					mysql_query("UPDATE Users SET Signature='$Siggy' WHERE ID='$myU->ID'");
					header("Location: /account.php");
				}
			}
		echo "
		<table width='95%'>
			<tr>
				<td>
					<div id='LargeText'>
						My Account
					</div>
					<div id=''><div align='left'>
						<form action='' method='POST'>
							<table>
								<tr>
									<td>
										<div id='ProfileText'>My Description</div>
										<font id=''>Update your personal description here.</font>
										<br />
										<textarea name='Description' style='width:700px;height:100px;'>".$myU->Description."</textarea>
									</td>
								</tr>
								<tr>
									<td>
										<input type='submit' value='Update' name='Submit'>
									</td>
								</tr>
							</table>
							</form>
							<form action='' method='POST'>
							<br />
							<table>
								<tr>
									<td>
										<div id='ProfileText'>My Password</div>
										<font id='Small'>Update your password here.</font>
										<br />
										<table>
											<tr>
												<td>
													<b>Current Password:</b>
												</td>
												<td>
													<input type='password' name='CurrentPassword'>
												</td>
											</tr>
											<tr>
												<td>
													<b>New Password:</b>
												</td>
												<td>
													<input type='password' name='NewPassword'>
												</td>
											</tr>
											<tr>
												<td>
													<b>Confirm New Password:</b>
												</td>
												<td>
													<input type='password' name='ConfirmNewPassword'>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<input type='submit' value='Change' name='Submit2'>
							
									</td>
								</tr>
							</table>
						</form>
					</div>
				</td>
				<td>
				
				</td>
			</tr>
		</table>
		";
	
	}
	
	include "Footer.php";

?>
