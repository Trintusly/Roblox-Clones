?<?php
    include("../SiT_3/config.php");
    include("../SiT_3/header.php");
    include("../SiT_3/PHP/helper.php");
    
    if($power < 1) {header("Location: ../"); die();} // Will be changed to 5 later :^)
    $userID = mysqli_real_escape_string($conn,intval($_GET['id']));
    $userSQL = "SELECT * FROM `beta_users` WHERE `id`='$userID'";
    $user = $conn->query($userSQL);
    $userRow = $user->fetch_assoc();
    
    $emailSQL = "SELECT * FROM `emails` WHERE `user_id`='$userID' ORDER BY `id` DESC LIMIT 20";
    $email = $conn->query($emailSQL);
    
    $loginSQL = "SELECT * FROM `log` WHERE `action` LIKE '%User $userID %' ORDER BY `id` DESC LIMIT 20";
    $login = $conn->query($loginSQL);
    
    $bansSQL = "SELECT * FROM `moderation` WHERE `user_id`='$userID' ORDER BY `id` DESC LIMIT 10";
    $bans = $conn->query($bansSQL);
    
    $crateSQL = "SELECT * FROM `crate` WHERE `user_id`='$userID' ORDER BY `id` DESC LIMIT 10";
    $crate = $conn->query($crateSQL);
    
    $purchaseSQL = "SELECT * FROM `purchases` WHERE `user_id`='$userID' ORDER BY `id` DESC LIMIT 10";
    $purchase = $conn->query($purchaseSQL);
?>
<div id="body" >

	<div id="box" style="padding: 10px;">
		<div id="subsect">
			<h3><?php echo $userRow['username']; ?></h3>
		</div>
		<div id="subsect">
			<h4>Email(s):</h4>
			<?php
				while($emailRow = $email->fetch_assoc()) {
					echo '<p>'.$emailRow['email'].' | Verified: '.$emailRow['verified'].'</p>';
				}
			?>
		</div>
		<div id="subsect">
			<h4>Logins:</h4>
			<?php
				while($loginRow = $login->fetch_assoc()) {
					echo '<p>'.$loginRow['action'].' | Date: '.$loginRow['date'].'</p>';
				}
			?>
		</div>
		<div id="subsect">
			<h4>Bans:</h4>
			<?php
				while($banRow = $bans->fetch_assoc()) {
					echo '<p>'.$banRow['admin_id'].' | '.$banRow['admin_note'].' | Date: '.$banRow['issued'].', '.$banRow['length'].' minutes</p>';
				}
			?>
		</div>
		<div id="subsect">
			<h4>Crate:</h4>
			<?php
				while($crateRow = $crate->fetch_assoc()) {
					echo '<p>'.$crateRow['item_id'].' | '.$crateRow['price'].' '.$crateRow['payment'].' | Date: '.$crateRow['date'].'</p>';
				}
			?>
		</div>
		<?php if($power >= 4) { ?>
		<div id="subsect">
			<h4>Purchases:</h4>
			<?php
				while($purchaseRow = $purchase->fetch_assoc()) {
					echo '<p>$'.$purchaseRow['gross'].' | Date: '.$purchaseRow['timestamp'].' | Receipt: '.$purchaseRow['receipt'].'</p>';
				}
			?>
		</div>
		<?php } ?>
	</div>

</div>
<?php 
    include("../SiT_3/footer.php");
?>