<?php 
  include("../SiT_3/config.php");
  include("../SiT_3/header.php");
  
  if(!$loggedIn) {header("Location: /login/"); die();}
?>
<head>
	<title>Memberships - Brick Hill</title>
</head>
<div id="body">
	<div style="width:76%;float:left;">
  <div id="box">
  
    <?php 
    $price = array("Mint-Monthly" => 4.99,"Mint-6Months" => 26.99,"Mint-12Months" => 48.99,"Mint-Lifetime" => 174.99,
    		   "Ace-Monthly" => 8.99,"Ace-6Months" => 48.99,"Ace-12Months" => 86.99,"Ace-Lifetime" => 284.99,
    		   "Royal-Monthly" => 12.99,"Royal-6Months" => 68.99,"Royal-12Months" => 126.99,"Royal-Lifetime" => 408.99);
    
    $membershipArray = array(
    "Mint",
    "Ace",
    "Royal"
    );
    foreach ($membershipArray as $membership){
      $membershipLower = strtolower($membership);
    ?>
    <h2>
      <span class="<?php echo $membershipLower ?>-text"><?php echo $membership; ?></span> Membership
    </h2>
    <div style="height: 5px;">
    </div>
    <div id="mint-images">
      <?php 
      $membershipTypes = array(
      "Monthly",
      "6Months",
      "12Months",
      "Lifetime"
      );
      foreach ($membershipTypes as $type) {
	echo '<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<!--Payments may go wrong if you edit this form, of which we are not responsible-->
	<input type="hidden" name="cmd" value="_donations">
	<input type="hidden" name="business" value="andy.dunn0@gmail.com">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="amount" value="'.$price[$membership.'-'.$type].'">
	<input type="hidden" name="notify_url" value="http://www.brick-hill.com/membership/notify">
	<input type="hidden" name="return" value="http://www.brick-hill.com/membership/thanks">
	<input type="hidden" name="item_number" value="'.$_SESSION['id'].'">
	<input type="hidden" name="item_name" value="'.$membership.'-'.$type.'">
	<div class="membership-image">
		<input style="height:105px;" type="image" src="'.$membership.'-'.$type.'.png" name="submit" alt="PayPal">
	</div>
	</form>';
      }
      ?>
    </div>
    <?php 
    }
    ?>
    <em style="margin-left:10px;">By donating, you agree that you have read and adhere to the <a href="/terms/">Terms of Service</a></em>
    </div>
    <div style="height:10px;"></div>
    <div id="box" style="padding: 10px;">
      <h2>
        Guide
      </h2>
      <table class="membership-table">
        <tbody>
          <tr>
            <th>
              Benefits
            </th>
            <th>
              Free
            </th>
            <th>
              Mint
            </th>
            <th>
              Ace
            </th>
            <th>
              Royal
            </th>
          </tr>
          <tr>
            <td>
              Sets
            </td>
            <td>
              1
            </td>
            <td>
              5
            </td>
            <td>
              10
            </td>
            <td>
              20
            </td>
          </tr>
          <tr>
            <td>
              Daily Bucks
            </td>
            <td>
              0
            </td>
            <td>
              10
            </td>
            <td>
              40
            </td>
            <td>
              70
            </td>
          </tr>
          <tr>
            <td>
              Exclusive Item
            </td>
            <td>
              No
            </td>
            <td>
              Yes (1) <? // 1 ?>
            </td>
            <td>
              Yes (2) <? // 2 ?>
            </td>
            <td>
              Yes (2) <? // 3 ?>
            </td>
          </tr>
          <tr>
            <td>
              Create Clans
            </td>
            <td>
              Yes (1)
            </td>
            <td>
              Yes (5)
            </td>
            <td>
              Yes (10)
            </td>
            <td>
              Yes (20)
            </td>
          </tr>
          <tr>
            <td>
              Join Clans
            </td>
            <td>
              Yes (5)
            </td>
            <td>
              Yes (10)
            </td>
            <td>
              Yes (20)
            </td>
            <td>
              Yes (50)
            </td>
          </tr>
          <tr>
            <td>
              Advertisements
            </td>
            <td>
              No
            </td>
            <td>
              No
            </td>
            <td>
              No
            </td>
            <td>
              No
            </td>
          </tr>
          <tr>
            <td>
              Badge
            </td>
            <td>
              No
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
      <i>All items, sets, currency, and anything else listed above are all virtual.<br>For more information visit the FAQ.</i>
    </div>
	</div>
	<div style="width:23%;float:right;">
		<div id="box" style="padding-left:10px;padding-right:10px;">
		<h2 style="color:#03c600;">Donate</h2>
		  <div style="height: 5px;"></div>
		  <div id="mint-images" style="overflow: auto;width: 100%;display: block;">
			  <div class="membership-image">
				<a href="donate">
					<img src="Donate.png" height="105">
				</a>
			  </div> 
		  </div>
		  <i>
			Click here to find out how you can earn in-game goods by supporting Brick Hill!
		  </i>
		</div>
		<div style="height:10px;"></div>
		<div id="box" style="padding: 10px;">
		<?php 
			$fundsSQL = "SELECT SUM(`gross`) FROM `purchases`";
			$fundsQuery = $conn->query($fundsSQL);
			while ($fundsRow = $fundsQuery->fetch_assoc()) {
		?>
			<div style="border-bottom: 1px solid #000;margin-bottom:5px;">
			<h4>Funds Raised</h4>
			</div>
			$<?php  echo $fundsRow["SUM(`gross`)"]; ?>
		<?php 
		}
		?>
		</div>
		<div style="height:10px;"></div>
		<div id="box" style="padding: 10px;">
		<div style="border-bottom: 1px solid #000;margin-bottom:5px;">
			<h4>Top Donors</h4>
		</div>
			<?php
				$purchasesSQL = "SELECT `user_id`, SUM(`gross`) AS 'gross' FROM `purchases` GROUP BY `user_id` ORDER BY SUM(`gross`) DESC LIMIT 5";
				$purchasesQuery = $conn->query($purchasesSQL);
				
				if ($purchasesQuery->num_rows > 0) {
				
					while($purchasesRow = $purchasesQuery->fetch_assoc()) {
						$userRow = $conn->query("SELECT * FROM `beta_users` WHERE `id` = '" . $purchasesRow['user_id'] . "'"); 
						$userRow = $userRow->fetch_assoc();
						
						$username = $userRow['username'];
						if (strlen($username) > 10) {
							$username = substr($username, 0, 9) . '...';
						}
						
						?>
						<div style="padding:2px;">
							<div style="width:90%;background-color:rgba(0,0,0,0.1);padding:3px;">
							$<?php 
							echo $purchasesRow['gross'];
							?>
							</div>
							<div style="margin-top:2px;">
							~ <a href="/user?id=<?php echo $purchasesRow['user_id']; ?>">
								<?php echo $username; ?>
							</a>
							</div>
						</div>
						<?php
					}
					
				} else {
					echo '<div class="text-center">No donors!</div>';
				}
				
			?>
		</div>
	</div>
</div>

<?php
  include("../SiT_3/footer.php");
?>