<?php

require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	if (isset($_POST['redemption-button'])) {
		
		if (empty($_POST['redemption-code'])) {
			
			$errormessage = "<b>Oh no!</b> Please provide a redemption code to redeem.";
			
		} else {
									  //discord code      //twitter code
			$redemptionarray = array("@BrickPlanetGame", "NITROBOOSTER939943XX03372728X9LDXJ");
			
			if (in_array($_POST['redemption-code'], $redemptionarray)) {

				if ($_POST['redemption-code'] == "@NITROBOOSTER939943XX03372728X9LDXJ") {
					
					//https://www.brickplanet.com/store/view/18669/
					
					$itemID = 3;
					
				} else if ($_POST['redemption-code'] == "BPDISCORDHAT") {
					
					//https://www.brickplanet.com/store/view/18665/
					
					$itemID = 18665;
					
				}
				
				$checkOwnership = $db->prepare("
				SELECT 
					*
				FROM 
					UserInventory 
				WHERE 
					UserID = ".$myU->ID." 
				AND 
					ItemID = ".$itemID."
				");
				
				$checkOwnership->execute();
				
				if ($checkOwnership->rowCount() > 0) {
					
					$errormessage = "<b>Oh no!</b> This code has already been redeemed on your account.";
					
				} else {
					
					$cO = $checkOwnership->fetch(PDO::FETCH_OBJ);
					
					$getLast = $db->prepare("SELECT CollectionNumber FROM UserInventory WHERE ItemID = ".$itemID." AND CollectionNumber != 0 ORDER BY ID DESC LIMIT 1");
					$getLast->execute();
					
					if ($getLast->rowCount() == 0) {
				
						$serial = 1;
						
					}
					
					else {
						
						$gL = $getLast->fetch(PDO::FETCH_OBJ);
						$serial = $gL->CollectionNumber + 1;
						
					}
					
					$db->beginTransaction();
					
					$insert = $db->prepare("INSERT INTO UserInventory (UserID, ItemID, TimeCreated, CollectionNumber) VALUES(?, ?, ?, ?)");
					$insert->bindValue(1, $myU->ID, PDO::PARAM_INT);
					$insert->bindValue(2, $itemID, PDO::PARAM_INT);
					$insert->bindValue(3, time(), PDO::PARAM_INT);
					$insert->bindValue(4, $serial, PDO::PARAM_INT);
					$insert->execute();
					
					$lastInsert = $db->lastInsertId();
			
					$insertHistory = $db->prepare("INSERT INTO ItemSalesHistory (BuyerID, CreatorID, ItemID, Price, Time, PaymentType, InventoryID) VALUES(?, ?, ?, ?, ?, ?, ?)");
					$insertHistory->bindValue(1, $myU->ID, PDO::PARAM_INT);
					$insertHistory->bindValue(2, -1, PDO::PARAM_INT);
					$insertHistory->bindValue(3, $itemID, PDO::PARAM_INT);
					$insertHistory->bindValue(4, 0, PDO::PARAM_INT);
					$insertHistory->bindValue(5, time(), PDO::PARAM_INT);
					$insertHistory->bindValue(6, 'Code Redeem', PDO::PARAM_STR);
					$insertHistory->bindValue(7, $db->lastInsertId(), PDO::PARAM_INT);
					$insertHistory->execute();
					
					$count = $db->prepare("SELECT COUNT(*) FROM UserInventory WHERE UserID = ".$myU->ID." AND ItemID = ".$itemID." AND TimeCreated = (SELECT TimeCreated FROM UserInventory WHERE ID = ".$lastInsert.")");
					$count->execute();
					
					if ($count->fetchColumn() > 1) {
						
						$db->rollBack();
						
						$errormessage = "<b>Oh no!</b> There was a problem with this redemption. Please try again.";
						
					} else {
						
						$db->commit();
						
						$successmessage = '<b>Success!</b> This code has been successfully redeemed and the item provided has been added to your backpack.';
						
					}
					
				}
				
			} else {
				
				$errormessage = "<b>Oh no!</b> Invalid redemption code. This code doesn't exist or has expired.";
				
			}
			
		}
		
	}
	
	echo '
	<div class="push-25"></div>
	<div class="container border-wh md-padding code-redeem-page-borderRadius">
		<div class="grid-x grid-margin-x">
			<div class="large-3 medium-3 small-6 cell show-for-large">
				<div class="code-redeem-inf-img"></div>
				<div class="code-redeem-info">
					<div style="padding:10px;">
						<center>
							<font class="cri-title">HOW DOES IT WORK?</font>
							<div class="cri-divider"></div>
							<font class="cri-subtext">Enter special redemption codes in the text box and press the button for unique and special items!</font>
						</center>
					</div>
				</div>
			</div>
			<div class="large-9 medium-12 small-12 cell">
				<h4>Code Redemption</h4>
				<form method="post">
					<div class="grid-x grid-margin-x">
						<div class="large-10 cell">
							<label for="redemption-code">Enter Redemption Code</label>
							<input type="text" class="normal-input" name="redemption-code">
							';
				
							if (isset($errormessage)) {
								
								echo '
								<div style="height: 10px;"></div>
								<font style="color:red;">'.$errormessage.'</font>
								';
								
							}
							
							if (isset($successmessage)) {
								
								echo '
								<div style="height: 10px;"></div>
								<font style="color:green;">'.$successmessage.'</font>
								';
								
							}
							
							echo '
						</div>
						<div class="large-2 cell">
							<label for="redemption-button">&nbsp;</label>
							<button type="submit" class="button button-green" name="redemption-button" style="padding: 10px 20px">Redeem</button>
						</div>
						<div class="large-12 cell" style="margin-top:20px;">
							Current Code Items:
						</div>
						<div class="grid-x grid-margin-x" style="margin-top:25px;text-align:center;">
							<div class="large-2 medium-3 small-4 cell">
								<img src="https://cdn.brickplanet.com/5bb7c485-0265-4329-bb3c-2759b72bedd9.png" class="responsive-img">
								<br />
								<font style="font-size:11px;" title="Not currently available">Twitter Staff</font>
							</div>
							<div class="large-2 medium-3 small-4 cell">
								<img src="https://cdn.brickplanet.com/8fc89424-ee58-43d2-811f-0d263e025e68.png" class="responsive-img">
								<br />
								<font style="font-size:11px;" title="Not currently available">Discord Headset</font>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");