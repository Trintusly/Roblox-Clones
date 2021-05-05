<?php
	include "../Header.php";
	if ($User) {
		$Type = SecurePost($_GET['Type']);
		
		if ($Type == "Monthly") {
	
		echo "
		<div Type='LargeText'>
			Pay for Premium
		</div>
		<b>You are ordering M2B Premium Monthly for $2.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Premium will be granted instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="R9MEJZCY2XFC8">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>

		';
		
		}
		
		else if ($Type == 2) {
		
		echo "
		<div Type='LargeText'>
			Pay for Premium
		</div>
		<b>You are ordering M2B Premium 6-Months for $9.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Premium will be granted instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="K3D3NE84E7N2J">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
		else if ($Type == 3) {
		
		echo "
		<div Type='LargeText'>
			Pay for Premium
		</div>
		<b>You are ordering M2B Premium 12-Months for $24.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Premium will be granted instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="XBJ42Z8QRXMWE">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
		else if ($Type == 4) {
		
		echo "
		<div Type='LargeText'>
			Pay for Premium
		</div>
		<b>You are ordering M2B Premium Lifetime for $49.95 USD.</b>
		<br />
		<br />
		Use the PayPal button to process your order. Premium will be granted instantly.
		<br />
		";
		echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="6MCK5UWGRF9Z6">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}

				else if ($Type == 5) {
		
		echo "
		<div Type='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering M2B 1,000 Bux for $4.95 USD.</b>
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
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
				else if ($Type == 6) {
		
		echo "
		<div Type='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering M2B 5,000 Bux for $14.95 USD.</b>
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
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
				else if ($Type == 7) {
		
		echo "
		<div Type='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering M2B 10,000 Bux for $19.95 USD.</b>
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
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
				else if ($Type == 8) {
		
		echo "
		<div Type='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering M2B 15,000 Bux for $29.95 USD.</b>
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
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
				else if ($Type == 9) {
		
		echo "
		<div Type='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering M2B 30,000 Bux for $49.95 USD.</b>
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
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
				else if ($Type == 10) {
		
		echo "
		<div Type='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering M2B 50,000 Bux for $59.95 USD.</b>
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
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
				else if ($Type == 11) {
		
		echo "
		<div Type='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering M2B 100,000 Bux for $9.95 USD.</b>
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
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
				else if ($Type == 12) {
		
		echo "
		<div Type='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering M2B 200,000 Bux for $174.95 USD.</b>
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
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
				else if ($Type == 13) {
		
		echo "
		<div Type='LargeText'>
			Pay for Bux
		</div>
		<b>You are ordering M2B 500,000 Bux for $299.95 USD.</b>
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
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" wTypeth="1" height="1">
</form>
		';
		
		}
		
		}
		
	
	include "../Footer.php";