<?php
	include "../Header.php";
	if ($myU->PowerMegaModerator == "true"||$myU->PowerAdmin == "true") {
	echo "
	<div id='ProfileText'>
		Manage Users
	</div>
	Manage Avatar Network users.
	<br />
	<br />
	<form action='' method='POST'>
		<table>
			<tr>
				<td>
					<b>Username</b>
				</td>
				<td>
					<input type='text' name='Username'>
				</td>
			</tr>
			<tr>
				<td>
					<input type='submit' name='Submit' value='Search'>
				</td>
			</tr>
		</table>
	</form>
	";
	}
	//sort
	if ($myU->PowerMegaModerator == "true"||$myU->PowerAdmin == "true") {
	echo "
	<table style='padding:10px;'>
		<tr>
			<td width='200'>
				<b>Username</b>
			</td>
			<td width='350'>
				<b>Description</b>
			</td>
			<td width='75'>
				<b>Status</b>
			</td>
			<td width='200'>
				<b>Email</b>
			</td>
			<td width='200'>
				<b>Logs</b>
			</td>
			<td width='75'>
				<b>Bux</b>
			</td>
		</tr>
	</table>
	";
	
	$Username = SecurePost($_POST['Username']);
	$Submit = SecurePost($_POST['Submit']);
	
		if ($Submit) {
		
			$getUsers = mysql_query("SELECT * FROM Users WHERE Username LIKE '%$Username%' ORDER BY ID ASC");
			
				while ($gU = mysql_fetch_object($getUsers)) {
				
					if ($now < $gU->expireTime) {
					$Status = "Online";
					$Color = "green";
					}
					else {
					$Status = "Offline";
					$Color = "red";
					}
				
					echo "
					<table style='padding:10px;border:1px solid #DDD;'>
						<tr>
							<td width='200'>
								<a href='ManageUser.php?ID=$gU->ID'>$gU->Username</a>
							</td>
							<td width='350'>
								<font style='font-size:9px;'>$gU->Description</font>
							</td>
							<td width='75'><center>
								<font color='$Color'>$Status</font>
							</td>
							<td width='200'>
								$gU->Email
							</td>
							<td width='200'>
								<a href='#'>View Logs</a>
								or
								<a href='#'>Moderate User</a>
							</td>
							<td width='75'>
							";
							$gU->Bux = round($gU->Bux);
								$Bux = $gU->Bux;
							
								if ($Bux >= 100000&&$Bux <= 999999) {
								
									$BuxShort = substr($Bux, 0,3);
									
									$Bux = "".$BuxShort."K+";
								
								}
								else if ($Bux >= 1000000&&$Bux <= 9999999) {
								
									$BuxShort = substr($Bux, 0,1);
									
									$Bux = "".$BuxShort."M+";
								
								}
								else if ($Bux >= 10000000&&$Bux <= 99999999) {
								
									$BuxShort = substr($Bux, 0,2);
									
									$Bux = "".$BuxShort."M+";
								
								}
								else if ($Bux >= 100000000&&$Bux <= 999999999) {
								
									$BuxShort = substr($Bux, 0,3);
									
									$Bux = "".$BuxShort."M+";
								
								}
								else if ($Bux >= 1000000000&&$Bux <= 9999999999) {
								
									$BuxShort = substr($Bux, 0,1);
									
									$Bux = "".$BuxShort."B+";
								
								}
								else if ($Bux >= 10000000000&&$Bux <= 99999999999) {
								
									$BuxShort = substr($Bux, 0,2);
									
									$Bux = "".$BuxShort."B+";
								
								}
								else if ($Bux >= 100000000000&&$Bux <= 999999999999) {
								
									$BuxShort = substr($Bux, 0,3);
									
									$Bux = "".$BuxShort."B+";
								
								}
								else if ($Bux >= 1000000000000&&$Bux <= 9999999999999) {
								
									$BuxShort = substr($Bux, 0,1);
									
									$Bux = "".$BuxShort."T+";
								
								}
								else if ($Bux >= 10000000000000&&$Bux <= 99999999999999) {
								
									$BuxShort = substr($Bux, 0,2);
									
									$Bux = "".$BuxShort."T+";
								
								}
								else if ($Bux >= 1000000000) {
								
									$Bux = "&#8734;";
								
								}
								else if ($Bux >= 100&&$Bux <= 99999) {
								
									$Bux = number_format($Bux);
								
								}
							echo "
								<font color='green' title='$gU->Bux'><b>$Bux BUX</b></font>
							</td>
						</tr>
					</table>
					<br/ >
					";
				}
				}
		
		}
	
	include "../Footer.php";
?>