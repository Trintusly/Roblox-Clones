<?php
	include "../Header.php";
		if (!$User) {
		
			header("Location: ../index.php");
		
		}
		echo "
		<table>
			<tr>
				<td>
					<div id='LargeText'>
						Upgrade
					</div>
					BrickPlanet is free. However, premium packages and additional BUX purchases are available.
				</td>
				<td style='padding-left:15px;'>
				<center>	<a href='PurchaseBux.php' style='border:0;'><img src='https://brickplanet.gq/Images/BuyBux.png' width='175' style='margin:15px;border:0;'></a>
				</td>
			</tr>
		</table>
		<br/ >
		<br />
		<table>
			<tr>
				<td>
					<b>Premium Plans</b>
				</td>
			</tr>
		</table>
		<table><tr><td valign='top'>
		<table>
			<tr>
				<td>
					<a href='UpgradePay.php?ID=1'><img src='https://brickplanet.gq/Images/Monthly.png' style='border-radius:5px;'></a>
				</td>
				<td>
					<a href='UpgradePay.php?ID=2'><img src='https://brickplanet.gq/Images/6_Months.png' style='border-radius:5px;'></a>
				</td>
			</tr>
			<tr>
				<td>
					<a href='UpgradePay.php?ID=3'><img src='https://brickplanet.gq/Images/1_Year.png' style='border-radius:5px;'></a>
				</td>
				<td>
					<a href='UpgradePay.php?ID=4'><img src='https://brickplanet.gq/Images/Lifetime.png' style='border-radius:5px;'></a>
				</td>
			</tr>
		</table>
		</td><td valign='top'>
			<div id='Login' style='width:475px;'>
				<b>Compare</b>
				<table width='100%'>
					<tr>
						<td width='65'>
							<b>Feature
						</td>
						<td width='60'>
							<b>Free User
						</td>
						<td width='60'>
							<b>Premium User
						</td>
					</tr>
				</table>
				<table width='100%'>
					<tr>
						<td width='65'>
							<b>Daily Bux
						</td>
						<td width='60'>
							<font color='green'><b>100 BUX</b></font>
						</td>
						<td width='60'>
							<font color='green'><b>250 BUX</b></font>
						</td>
					</tr>
					<tr>
						<td width='65'>
							<b>Trade System
						</td>
						<td width='60'>
							<font color='red'>No</font>
						</td>
						<td width='60'>
							<font color='green'>Yes</font>
						</td>
					</tr>
					<tr>
						<td width='65'>
							<b>Premium Theme
						</td>
						<td width='60'>
							<font color='red'>No</font>
						</td>
						<td width='60'>
							<font color='green'>Yes</font>
						</td>
					</tr>
					<tr>
						<td width='65'>
							<b>User Store Privileges
						</td>
						<td width='60'>
							Shirts & Pants
						</td>
						<td>
							All
						</td>
					</tr>
					<tr>
						<td width='60'>
							<b>Create Groups
						</td>
						<td width='60'>
							<font color='green'><b>Yes, <b>1,000 BUX</b>
						</td>
						<td width='60'>
							<font color='green'><b>FREE</b></font>
						</td>
					</tr>
				</table>
			</div>
			<br />
			<div id='Login' style='width:475px;'>
				<b>About</b>
				<br />
				BrickPlanet offers premium packages to those that want to extend to the max on our website. We let users share their artistic skills, profit on items, and make friends.
			</div>
		</td></tr></table>
		";
	
	include "../Footer.php";
?>