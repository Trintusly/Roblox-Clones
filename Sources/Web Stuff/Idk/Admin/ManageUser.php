<?php
	include "../Header.php";
	
		$ID = SecurePost($_GET['ID']);
		
		if (!$ID) {
		
			echo "<b>Invalid ID.</b>";
			die;
		}
		
		$getUser = mysql_query("SELECT * FROM Users WHERE ID='$ID'");
		$numUser = mysql_num_rows($getUser);
		
		if ($numUser == 0) {
		
			echo "<b>Invalid ID.";
			die;
		
		}
		
		//start
		
		$gU = mysql_fetch_object($getUser);
		
		echo "
		<table>
			<tr>
				<td>
					<div id='ProfileText'>
						".$gU->Username."
					</div>
					View and modify things for the user ".$gU->Username.".
				</td>
			</tr>
		</table>
		<br />
		<table>
			<tr>
				<td valign='top'>
					<div style='width:100px;height:200px;border:1px solid #DDD;'>
						<img src='https://socialisland.gq/Avatar.php?ID=$gU->ID'>
					</div>
				</td>
				<td valign='top'>
					<b>Statistics:</b>
					<br />
					<br />
					<table style='padding:4px;'>
						<tr>
							<td width='150'>
								<b>Bux:</b>
							</td>
							<td>
								<font color='green'><b>".number_format($gU->Bux)." BUX</b></font>
							</td>
						</tr>
						<tr>
							<td>
								<b>Status:</b>
							</td>
							<td>
							";
							
								if ($now < $gU->expireTime) {
								$Status = "Online";
								$Color = "green";
								}
								else {
								$Status = "Offline";
								$Color = "red";
								}
								
							echo "
								<font color='$Color'>$Status</font>
							</td>
						</tr>
						<tr>
							<td>
								<b>Last Seen:</b>
							</td>
							<td>
								";
								echo date("F j, Y g:iA","".$gU->visitTick."");
								echo "
							</td>
						</tr>
						<tr>
							<td>
								<b>Purge Avatar:</b>
							</td>
							<td>
								<a href='?purge=yes'>Purge Avatar</a>
							</td>
						</tr>
						<tr>
							<td>
								<b>Premium Expire:</b>
							</td>
							<td>
								";
								if ($gU->Premium == 0) {
								
									echo "User does not have premium.";
								
								}
								else {
								
									if ($gU->PremiumExpire == "unlimited") {
									
										echo "Lifetime Premium";
									
									}
									else {
								
										echo date("F j, Y g:iA","".$gU->PremiumExpire."");
									
									}
								
								}
								echo "
							</td>
						</tr>
					</table>
				</td>
				<td valign='top'>
					<b>Give Premium:</b>
					<br />
					<br />
					<form action='' method='POST'>
						<table>
							<tr>
								<td>
									<b>Length:</b>
								</td>
								<td>
									";
									$time = time();
									$Month = 86400*30;
									$SixMonth = 86400*30*6;
									$Year = 86400*30*12;
									$Lifetime = "unlimited";
									echo "
									<select name='Length'>
										<option value='".$Month."'>One Month</option>
										<option value='".$SixMonth."'>Six Months</option>
										<option value='".$Year."'>One Year</option>
										<option value='".$Lifetime."'>Lifetime</option>
									</select>
								</td>
								<td>
									<input type='checkbox' name='BonusBux' value='1' checked>
									<label for='BonusBux' id='BonusBux'><font color='green'><b>5,000 BUX</b></font> Bonus</label>
								</td>
							</tr>
							<tr>
								<td>
									<input type='submit' name='Submit' value='Submit'>
								</td>
							</tr>
						</table>
						";
						
							$Length = SecurePost($_POST['Length']);
							$BonusBux = SecurePost($_POST['BonusBux']);
							$Submit = SecurePost($_POST['Submit']);
							
								if ($Submit) {
								
									mysql_query("UPDATE Users SET Premium='1' WHERE ID='$gU->ID'");
									
									if ($gU->PremiumExpire == "unlimited") {
									
										echo "<b>You can not add premium to a lifetime premium account.</b>";
									
									}
									
									else {
								
									if (!empty($gU->PremiumExpire)) {
									
										if ($Length != "unlimited") {
									
										$Length = $gU->PremiumExpire + $Length;
										
										}
									
										mysql_query("UPDATE Users SET PremiumExpire=PremiumExpire + $Length WHERE ID='$gU->ID'");
									
									}
									else {
										
										if ($Length != "unlimited") {
										
										$Length = time() + $Length;
										
										}
										
										mysql_query("UPDATE Users SET PremiumExpire='$Length' WHERE ID='$gU->ID'");
									
									}
									
									if ($BonusBux) {
									
										mysql_query("UPDATE Users SET Bux=Bux + 5000 WHERE ID='$gU->ID'");
									
									}
									
									header("Location: ManageUser.php?ID=$gU->ID");
									
									}
								
								}
						
						echo "
					</form>
				</td>
			</tr>
		</table>
		<br />
		<table>
			<tr>
				<td>
					<div id='ProfileText'>
						Ban History
					</div>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td width='100'>
					<b>Who Banned</b>
				</td>
				<td width='100'>
					<b>Ban Type</b>
				</td>
				<td width='100'>
					<b>Ban Length</b>
				</td>
				<td width='300'>
					<b>Ban Description</b>
				</td>
				<td width='200'>
					<b>Ban Content</b>
				</td>
			</tr>
		</table>
		";
		
		$getHistory = mysql_query("SELECT * FROM BanHistory WHERE UserID='$ID' ORDER BY ID DESC");
		
		while ($gH = mysql_fetch_object($getHistory)) {
		
			echo "
			<table>
				<tr>
					<td width='100'>
						";
						
							$getMod = mysql_query("SELECT * FROM Users WHERE ID='$gH->WhoBanned'");
							$gM = mysql_fetch_object($getMod);
						
						echo "
						$gM->Username
					</td>
					<td width='100'>
						$gH->BanType
					</td>
					<td width='100'>
						$gH->BanLength days
					</td>
					<td width='300'>
						$gH->BanDescription
					</td>
					<td width='200'>
						$gH->BanContent
					</td>
				</tr>
			</table>
			";
		
		}
	
	include "../Footer.php";