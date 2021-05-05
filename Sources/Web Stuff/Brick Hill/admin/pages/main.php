<?php 

	require("adminOnly.php");
    include("../../SiT_3/config.php");
	
    if($power < 1) {header("Location: ../");die(); }

$econSQL = "SELECT SUM(`bits`) AS 'totalBits' FROM `beta_users`";
$econQ = $conn->query($econSQL);
$econRow = $econQ->fetch_assoc();
$totalBits = $econRow['totalBits'];

$econSQL = "SELECT SUM(`bucks`) AS 'totalBucks' FROM `beta_users`";
$econQ = $conn->query($econSQL);
$econRow = $econQ->fetch_assoc();
$totalBucks = $econRow['totalBucks'];

$econ = $totalBits+($totalBucks*10);
?>
<div id="box" style="margin-bottom:10px">
				<div id="subsect">
					<h3>Admin Panel</h3>
					<h4>Economy (Bits): <?php echo $econ; ?></h4>
				</div>
				<i>Abuse of this feature will result in indefinite suspension of your administrative privileges.<br>Logs are kept.</i>
				<h4>Item</h4>
				<form action="" method="POST" style="margin:10px;">
					User ID: <input type="text" name="user"><br>
					Item ID: <input type="text" name="item"><br>
					<input type="submit" name="grant" value="Grant Item">
				</form><br>
				<h4>Currency</h4>
				<form action="" method="POST" style="margin:10px;">
					User ID: <input type="text" name="user"><br>
					Bits: <input type="text" name="bits"><br>
					Bucks: <input type="text" name="bucks"><br>
					<input type="submit" name="money" value="Add Currency">
				</form><br>
				<h4>Membership</h4>
				<form action="" method="POST" style="margin:10px;">
					User ID: <input type="text" name="user"><br>
					Membership: <select name="value">
						<option value="1">Ace</option>
						<option value="2">Mint</option>
						<option value="3">Royal</option>
					</select><br>
					Length (Minutes): <input type="number" name="length"><br>
					<input type="submit" name="membership" value="Set Membership">
				</form><br>
				<h4>Password</h4>
				<form action="" method="POST" style="margin:10px;">
					User ID: <input type="text" name="user"><br>
					<input type="submit" name="password" value="Reset Password">
				</form>
			</div>
		</div>