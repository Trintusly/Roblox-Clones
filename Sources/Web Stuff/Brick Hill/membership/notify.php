<?php
include("../SiT_3/config.php");
if (!isset($_POST["payment_status"])) {header("Location: index"); die();}
if ($_POST["payment_status"] == "Completed") {
    	$USDvalue = mysqli_real_escape_string($conn,$_POST['payment_gross']);
    	$userID = mysqli_real_escape_string($conn,intval($_POST['item_number']));
    	$package = mysqli_real_escape_string($conn,$_POST['item_name']);
    	$senderEmail = mysqli_real_escape_string($conn,$_POST['payer_email']);
    	$receiptID = mysqli_real_escape_string($conn,$_POST['txn_id']);
    	
    	$userSQL = "SELECT * FROM `beta_users` WHERE `id`='$userID'";
    	$user = $conn->query($userSQL);
    	$userRow = $user->fetch_assoc();
    	
    	$purchaseSQL = "INSERT INTO `purchases` (`id`,`user_id`,`gross`,`timestamp`,`email`,`receipt`,`product`) VALUES (NULL,'$userID','$USDvalue',CURRENT_TIMESTAMP,'$senderEmail','$receiptID','$package')";
    	$purchase = $conn->query($purchaseSQL);
    	
    $price = array("Mint-Monthly" => 4.99,"Mint-6Months" => 26.99,"Mint-12Months" => 48.99,"Mint-Lifetime" => 174.99,
	   "Ace-Monthly" => 8.99,"Ace-6Months" => 48.99,"Ace-12Months" => 86.99,"Ace-Lifetime" => 284.99,
	   "Royal-Monthly" => 12.99,"Royal-6Months" => 68.99,"Royal-12Months" => 126.99,"Royal-Lifetime" => 408.99);
	   
    $length = array("Mint-Monthly" => 43200,"Mint-6Months" => 259200,"Mint-12Months" => 518400,"Mint-Lifetime" => 2147483647,
	   "Ace-Monthly" => 43200,"Ace-6Months" => 259200,"Ace-12Months" => 518400,"Ace-Lifetime" => 2147483647,
	   "Royal-Monthly" => 43200,"Royal-6Months" => 259200,"Royal-12Months" => 518400,"Royal-Lifetime" => 2147483647);
    $value = array("Mint-Monthly" => 1,"Mint-6Months" => 1,"Mint-12Months" => 1,"Mint-Lifetime" => 1,
	   "Ace-Monthly" => 2,"Ace-6Months" => 2,"Ace-12Months" => 2,"Ace-Lifetime" => 2,
	   "Royal-Monthly" => 3,"Royal-6Months" => 3,"Royal-12Months" => 3,"Royal-Lifetime" => 3);
    $items = array("Mint-Monthly" => array(522),"Mint-6Months" => array(522),"Mint-12Months" => array(522),"Mint-Lifetime" => array(522),
	   "Ace-Monthly" => array(523,526),"Ace-6Months" => array(523,526),"Ace-12Months" => array(523,526),"Ace-Lifetime" => array(523,526),
	   "Royal-Monthly" => array(524,527),"Royal-6Months" => array(524,527),"Royal-12Months" => array(524,527),"Royal-Lifetime" => array(524,527));
	   
	if(array_key_exists($package,$price)) {
		if($USDvalue >= $price[$package]) {
			$value = $value[$package];
			$length = $length[$package];
			$membershipSQL = "INSERT INTO `membership` (`id`,`user_id`,`membership`,`date`,`length`,`active`) VALUES (NULL, '$userID', '$value', CURRENT_TIMESTAMP, '$length', 'yes')";
			$membership = $conn->query($membershipSQL);
			
			foreach ($items[$package] as $gift) {
				$itemID = $gift;
				$crateSQL = "SELECT * FROM `crate` WHERE `user_id`='$userID' AND `item_id`='$itemID'";
				$crate = $conn->query($crateSQL);
				if($crate->num_rows == 0) {
					$serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC";
					$serialQ = $conn->query($serialSQL);
					$serialRow = $serialQ->fetch_assoc();
					$serial = $serialRow['serial']+1;
					
					$addSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$userID','$itemID','$serial')";
					$add = $conn->query($addSQL);
				}
			}
		}
	} else {
	    	$newBits = $userRow['bits']+(int)($USDvalue*100);
	    	$updateBitsSQL = "UPDATE `beta_users` SET `bits`='$newBits' WHERE `id`='$userID'";
	    	$updateBits = $conn->query($updateBitsSQL);
    	
	    	$awardSQL = "SELECT * FROM `user_rewards` WHERE `user_id`='$userID' AND `reward_id`='4'";
	    	$award = $conn->query($awardSQL);
	    	if($award->num_rows == 0) {
	    		$rewardSQL = "INSERT INTO `user_rewards` (`id`,`user_id`,`reward_id`) VALUES (NULL,'$userID','4')";
	    		$reward = $conn->query($rewardSQL);
	    	}
	    	
	    	if($USDvalue >= 0.99) {
			$itemID = 83;
			$serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC";
			$serialQ = $conn->query($serialSQL);
			$serialRow = $serialQ->fetch_assoc();
			$serial = $serialRow['serial']+1;
			
			$addSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$userID','$itemID','$serial')";
			$add = $conn->query($addSQL);
	    	}
	    	if($USDvalue >= 4.99) {
			$itemID = 79;
			$serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC";
			$serialQ = $conn->query($serialSQL);
			$serialRow = $serialQ->fetch_assoc();
			$serial = $serialRow['serial']+1;
			
			$addSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$userID','$itemID','$serial')";
			$add = $conn->query($addSQL);
	    	}
	    	if($USDvalue >= 8.99) {
	    		$itemID = 244;
			$serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC";
			$serialQ = $conn->query($serialSQL);
			$serialRow = $serialQ->fetch_assoc();
			$serial = $serialRow['serial']+1;
			
			$addSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$userID','$itemID','$serial')";
			$add = $conn->query($addSQL);
	    	}
	    	if($USDvalue >= 12.99) {
	    		$itemID = 82;
			$serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC";
			$serialQ = $conn->query($serialSQL);
			$serialRow = $serialQ->fetch_assoc();
			$serial = $serialRow['serial']+1;
			
			$addSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$userID','$itemID','$serial')";
			$add = $conn->query($addSQL);
	    	}
	    }
	}
// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
header("HTTP/1.1 200 OK");