<?php
	include "../Header.php";
	
		if ($User) {
		
			echo "
			<table>
				<tr>
					<td width='90%' valign='top'>
						<div id='LargeText'>
							Buy Bux
						</div>
						BrickPlanet has available offers for BUX.
					</td>
					<td>
						<div id='Login'>
							<b>Why purchase BUX?</b>
							<br />
							<br />
							Here at BrickPlanet, BUX is used as a virtual currency to purchase items from the shop, user store, create groups, and more.
						</div>
					</td>
				</tr>
			</table>
			<br />
			<table>
				<tr>
					<td>
						<b>Our Plans</b>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<a href='https://brickplanet.gq/UpgradePay.php?ID=5'><img src='https://brickplanet.gq/Images/1K_Bux.png' title='1,000 BUX' style='border-radius:5px;'></a>
					</td>
					<td>
						<a href='https://brickplanet.gq/UpgradePay.php?ID=6'><img src='https://brickplanet.gq/Images/5K_Bux.png' title='5,000 BUX' style='border-radius:5px;'>
					</td>
					<td>
					        <a href='https://brickplanet.gq/UpgradePay.php?ID=7'><img src='https://brickplanet.gq/Images/10K_Bux.png' title='10,000 BUX' style='border-radius:5px;'>
					</td>
				</tr>
				<tr>
					<td>
						<a href='https://brickplanet.gq/UpgradePay.php?ID=8'><img src='https://brickplanet.gq/Images/15K_Bux.png' title='15,000 BUX' style='border-radius:5px;'>
					</td>
					<td>
						<a href='https://brickplanet.gq/UpgradePay.php?ID=9'><img src='https://brickplanet.gq/Images/30K_Bux.png' title='30,000 BUX' style='border-radius:5px;'>
					</td>
					<td>
						<a href='https://brickplanet.gq/UpgradePay.php?ID=10'><img src='https://brickplanet.gq/Images/50K_Bux.png' title='50,000 BUX' style='border-radius:5px;'>
					</td>
				</tr>
				<tr>
					<td>
						<a href='https://brickplanet.gq/UpgradePay.php?ID=11'><img src='https://brickplanet.gq/Images/100K_Bux.png' title='100,000 BUX' style='border-radius:5px;'>
					</td>
					<td>
						<a href='https://brickplanet.gq/UpgradePay.php?ID=12'><img src='https://brickplanet.gq/Images/200K_Bux.png' title='200,000 BUX' style='border-radius:5px;'>
					</td>
					<td>
						<a href='https://brickplanet.gq/UpgradePay.php?ID=13'><img src='https://brickplanet.gq/Images/500K_Bux.png' title='500,000 BUX' style='border-radius:5px;'>
					</td>
				</tr>
			</table>
			";
		
		}
		
		else {
		
			header("Location: https://brickplanet.gq/");
		
		}
	
	include "../Footer.php";
?>