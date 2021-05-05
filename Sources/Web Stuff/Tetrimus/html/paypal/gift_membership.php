<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if($power <= 1) {header("Location: \index"); die();}
?>

<form action="notify" method="POST">
	<input type="hidden" name="payment_status" value="Completed">
	<input type="text" name="payment_gross" placeholder="Payment Gross">
	<input type="text" name="item_number" placeholder="User ID">
	<input type="text" name="item_name" placeholder="Package">
	<input type="text" name="payer_email" placeholder="Payer Email">
	<input type="text" name="txn_id" placeholder="Receipt">
	<input type="submit">
</form>