<?php
include '../func/connect.php';
if (!isset($_POST["payment_status"])) {header("Location: failed.php"); die();}
if ($_POST["payment_status"] == "Completed") {
    	$USDvalue = mysqli_real_escape_string($conn,$_POST['payment_gross']);
    	$userID = mysqli_real_escape_string($conn,intval($_POST['item_number']));
    	$package = mysqli_real_escape_string($conn,$_POST['item_name']);
    	$senderEmail = mysqli_real_escape_string($conn,$_POST['payer_email']);
    	$receiptID = mysqli_real_escape_string($conn,$_POST['txn_id']);
    	
    	$userSQL = "SELECT * FROM `users` WHERE `id`='$userID'";
    	$user = $conn->query($userSQL);
    	$userRow = $user->fetch_assoc();
    	
    	$purchaseSQL = "INSERT INTO `purchases` (`id`,`user_id`,`gross`,`timestamp`,`email`,`receipt`,`product`) VALUES (NULL,'$userID','$USDvalue',CURRENT_TIMESTAMP,'$senderEmail','$receiptID','$package')";
    	$purchase = $conn->query($purchaseSQL);
		}
// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
header("HTTP/1.1 200 OK");