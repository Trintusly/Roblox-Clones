<?php
	include "../Header.php";
	if ($User) {
		$ID = SecurePost($_GET['ID']);
		
		if ($ID == 1) {
	
		echo "
		<div id='LargeText'>
			Pay for Premium
		</div>
		<b>You are ordering BrickPlanet Premium Monthly for $2.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Premium will be granted instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="VZ3GZKFKDUTL4">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

		';
		
		}
		
		else if ($ID == 2) {
		
		echo "
		<div id='LargeText'>
			Pay for Premium
		</div>
		<b>You are ordering BrickPlanet Premium 6-Months for $9.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Premium will be granted instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="J9Z2XX6CVVFKC">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
		else if ($ID == 3) {
		
		echo "
		<div id='LargeText'>
			Pay for Premium
		</div>
		<b>You are ordering BrickPlanet Premium 12-Months for $24.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Premium will be granted instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="QHTMFVX7GQZV8">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
		else if ($ID == 4) {
		
		echo "
		<div id='LargeText'>
			Pay for Premium
		</div>
		<b>You are ordering BrickPlanet Premium Lifetime for $49.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Premium will be granted instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="9YAHLRS6SX5SN">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}

				else if ($ID == 5) {
		
		echo "
		<div id='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering BrickPlanet 1,000 Bux for $4.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Your bux will be added to your account instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ZCGU29RS4AP74">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
				else if ($ID == 6) {
		
		echo "
		<div id='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering BrickPlanet 5,000 Bux for $14.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Your bux will be added to your account instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="8ZDS8HRQRB7JY">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
				else if ($ID == 7) {
		
		echo "
		<div id='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering BrickPlanet 10,000 Bux for $19.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Your bux will be added to your account instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="MHACXXFBDMJE8">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
				else if ($ID == 8) {
		
		echo "
		<div id='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering BrickPlanet 15,000 Bux for $29.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Your bux will be added to your account instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="HK4QZB8NZ4KJL">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
				else if ($ID == 9) {
		
		echo "
		<div id='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering BrickPlanet 30,000 Bux for $49.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Your bux will be added to your account instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="Q7KH6WPMZEPZC">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
				else if ($ID == 10) {
		
		echo "
		<div id='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering BrickPlanet 50,000 Bux for $59.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Your bux will be added to your account instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="YKB8ZNXC6YTUS">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
				else if ($ID == 11) {
		
		echo "
		<div id='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering BrickPlanet 100,000 Bux for $9.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Your bux will be added to your account instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7U78BKWY7PAJY">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
				else if ($ID == 12) {
		
		echo "
		<div id='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering BrickPlanet 200,000 Bux for $174.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Your bux will be added to your account instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="MHCVWSSWSACDW">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
				else if ($ID == 13) {
		
		echo "
		<div id='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering BrickPlanet 500,000 Bux for $299.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Your bux will be added to your account instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="DP8RVVQRMKPG6">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
		';
		
		}
		
		}
		
	
	include "../Footer.php";