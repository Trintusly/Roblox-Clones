<?php 	
	require("adminOnly.php");
    include("../../SiT_3/config.php");
	
    if($power < 1) {header("Location: ../");die(); } 

?>
<div id="box" style="padding: 5px;">
				<div id="subsect">
					<h3>Funds</h3>
				</div>
				<?php
					$grossSQL = "SELECT * FROM `beta_buy`";
					$gross = $conn->query($grossSQL);
					$money = 0;
					while($balance = $gross->fetch_assoc()) {
						$money += max(($balance['gross']*0.971)-0.30,0);
					}
					echo 'Beta Key Funds: $'.round($money,2).'<br>';
					
					$grossSQL = "SELECT * FROM `purchases`";
					$gross = $conn->query($grossSQL);
					$money1 = 0;
					while($balance = $gross->fetch_assoc()) {
						$money1 += max(($balance['gross']*0.971)-0.30,0);
					}
					echo 'Donation Funds: $'.round($money1,2).'<br>';
					echo 'Total Funds: $'.round(($money+$money1),2).'<br>';
				?>
</div>