<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header("Location /login/"); die();}
	
	/*if($userRow->{'power'} < 1) {
		header("Location: index");
	}*/
?>

<!DOCTYPE html>
	<head>
		<title>Donate - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="column" style="width:550px;float:left;">
				<div id="box" style="padding:10px;">
					<h3>Brick Hill</h3>
					<p>All donations are used for the development of Brick Hill and any excess fees required to host Brick Hill.</p>
					<h3>Donors</h3>
					<p>In return for your donation, you will recieve the following gift(s):</p>
					<ol>
						<li>An amount of Bits depending upon your donation.
						<br>i.e. a donation of $1.00 will result in 100 Bits, $3.50 results in 350 Bits.</li>
						<li>A virtual item from the Shop and a badge, using the following table:
						
						<table class="membership-table">
					        <tbody>
					          <tr>
					            <th>
					              Gifts
					            </th>
					            <th>
					              $0.99 - $4.99
					            </th>
					            <th>
					              $4.99 - $8.98
					            </th>
					            <th>
					              $8.99 - $12.98
					            </th>
					            <th>
					              Over $12.99
					            </th>
					          </tr>
					          <tr>
					            <td>
					              Virtual Items
					            </td>
					            <td>
					              1
					            </td>
					            <td>
					              2
					            </td>
					            <td>
					              3
					            </td>
					            <td>
					              4
					            </td>
					          </tr>
					          <tr>
					            <td>
					              Donator Badge
					            </td>
					            <td>
					              Yes
					            </td>
					            <td>
					              Yes
					            </td>
					            <td>
					              Yes
					            </td>
					            <td>
					              Yes
					            </td>
					          </tr>
					        </tbody>
					      </table>
						<br>
						For example, donating $8.98 will result in 898 Bits being added to your account, 2 virtual items (such as a hat or a tool), and your account receiving the donator badge.
						</li>
					</ol>
					<i>By donating, you agree that you are not purchasing or subscribing to a product from us and that all gifts are virtual.
					<br>
					"Bits" refers to in-game currency which holds no real-world value.
					<br>
					For more information visit the <a href="/forum/thread?id=168">FAQ</a> or email <a href="mailto:help@brick-hill.com">help@brick-hill.com</a>.</i>
				</div>
			</div>
			<div id="column" style="width:340px;float:right;">
				<div id="box" style="padding:10px;">
					<h3>Donate</h3>
					<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<!--Payments may go wrong if you edit this form, of which we are not responsible-->
						<input type="hidden" name="cmd" value="_donations">
						<input type="hidden" name="item_name" value="Brick Hill Donation">
						<input type="hidden" name="item_number" value="<?php echo $_SESSION['id']; ?>">
						<input type="hidden" name="business" value="andy.dunn0@gmail.com">
						<input type="hidden" name="currency_code" value="USD">
						<input type="hidden" name="notify_url" value="http://www.brick-hill.com/membership/notify">
						<input type="hidden" name="return" value="http://www.brick-hill.com/membership/thanks">
						Amount (USD):<br>
						<input type="number" name="amount" step="0.01" min="0.01" value="0.01">
						<br><br>
						<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/blue-rect-paypal-44px.png" name="submit" alt="PayPal">
					</form>
					<br>If a donation has been made without your consent, please email <a href="mailto:help@brick-hill.com">help@brick-hill.com<a>.
				</div>
			</div>
		</div>
		
		<?php
			include("../SiT_3/footer.php");
		?>
	</body>
</html>