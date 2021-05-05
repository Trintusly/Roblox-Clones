<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	if ($SiteSettings->AllowTrades == 0) {
		
		echo '
		<h4>Temporarily unavailable</h4>
		<div class="container border-r md-padding">
			We\'re sorry, account trades are temporarily unavailable at this moment. Try again later.
		</div>
		';
		
		require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
		die;
		
	}
	
	$getTrade = $db->prepare("SELECT UserTrade.*, User.ID AS UserID, User.Username, User.CurrencyCredits FROM UserTrade JOIN User ON User.ID = (CASE WHEN UserTrade.RequesterID = ".$myU->ID." THEN UserTrade.ReceiverID ELSE UserTrade.RequesterID END) WHERE UserTrade.ID = ? AND (UserTrade.RequesterID = ".$myU->ID." OR UserTrade.ReceiverID = ".$myU->ID.")");
	$getTrade->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getTrade->execute();
	
	if ($getTrade->rowCount() == 0) {
		
		header("Location: ".$servername."/account/trades/");
		die;
		
	} else {
		
		$gT = $getTrade->fetch(PDO::FETCH_OBJ);
		
		$getGiving = $db->prepare("SELECT Item.ID, Item.Name, Item.ThumbnailImage, COUNT(Item.ID) AS ItemCount FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE (Item.IsCollectible = 1 OR Item.ItemType = 7) AND Item.TradeLock = 0 AND UserInventory.ID IN(".$gT->GivingOne.", ".$gT->GivingTwo.", ".$gT->GivingThree.", ".$gT->GivingFour.") GROUP BY Item.ID");
		$getGiving->execute();
		
		$getRequesting = $db->prepare("SELECT Item.ID, Item.Name, Item.ThumbnailImage, COUNT(Item.ID) AS ItemCount FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE (Item.IsCollectible = 1 OR Item.ItemType = 7) AND Item.TradeLock = 0 AND UserInventory.ID IN(".$gT->WantOne.", ".$gT->WantTwo.", ".$gT->WantThree.", ".$gT->WantFour.") GROUP BY Item.ID");
		$getRequesting->execute();
		
		if (!empty($_POST['accept']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gT->Expires > time() && $gT->ReceiverID == $myU->ID && $gT->Status == 0) {
			
			$GivingList = array($gT->GivingOne, $gT->GivingTwo, $gT->GivingThree, $gT->GivingFour);
			$GivingList = array_diff($GivingList, array('0'));
			$GivingList = implode(',', $GivingList);
			
			$WantList = array($gT->WantOne, $gT->WantTwo, $gT->WantThree, $gT->WantFour);
			$WantList = array_diff($WantList, array('0'));
			$WantList = implode(',', $WantList);
			
			$MyInventory = $db->prepare("SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE ((Item.IsCollectible = 1) OR (Item.ItemType = 7)) AND Item.TradeLock = 0 AND UserInventory.ID IN(".$WantList.") AND UserInventory.UserID = ".$myU->ID." AND UserInventory.CanTrade = 1");
			$MyInventory->execute();
			$MyInventory = $MyInventory->fetchColumn();
			
			$TheirInventory = $db->prepare("SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE ((Item.IsCollectible = 1) OR (Item.ItemType = 7)) AND Item.TradeLock = 0 AND UserInventory.ID IN(".$GivingList.") AND UserInventory.UserID = ".$gT->RequesterID." AND UserInventory.CanTrade = 1");
			$TheirInventory->execute();
			$TheirInventory = $TheirInventory->fetchColumn();
			
			if ($MyInventory == 0 || $TheirInventory == 0) {
				
				$errorMessage = 'We\'re sorry, something went wrong. The trade has been canceled.';
				
				$Update = $db->prepare("UPDATE UserTrade SET Status = 3 WHERE ID = ".$gT->ID."");
				$Update->execute();
				
				$Count = $db->prepare("SELECT COUNT(*) FROM UserLogs WHERE UserID = ".$myU->ID." AND Message = ? AND LogTime = ".time()." AND IP = '".$UserIP."'");
				$Count->bindValue(1, $myU->Username.' (User ID: '.$myU->ID.') attempted to accept a trade from '.$gT->Username.' (User ID: '.$gT->UserID.'), but was canceled by system for: User inventory change', PDO::PARAM_STR);
				$Count->execute();
				$Count = $Count->fetchColumn();
				
			} else if ($myU->CurrencyCredits < $gT->WantCredits) {
				
				$errorMessage = 'We\'re sorry, the requester of this trade has requested an amount of Credits from you that exceeds your balance.';
				
			} else if ($gT->CurrencyCredits < $gT->GivingCredits) {
				
				$errorMessage = 'We\'re sorry, something went wrong. The trade has been canceled.';
				
				$Update = $db->prepare("UPDATE UserTrade SET Status = 3 WHERE ID = ".$gT->ID."");
				$Update->execute();
				
				$Count = $db->prepare("SELECT COUNT(*) FROM UserLogs WHERE UserID = ".$myU->ID." AND Message = ? AND LogTime = ".time()." AND IP = '".$UserIP."'");
				$Count->bindValue(1, $myU->Username.' (User ID: '.$myU->ID.') attempted to accept a trade from '.$gT->Username.' (User ID: '.$gT->UserID.'), but was canceled by system for: Insufficient credits', PDO::PARAM_STR);
				$Count->execute();
				$Count = $Count->fetchColumn();
				
			} else {
				
				$db->beginTransaction();
				
				$Delete = $db->prepare("DELETE FROM ItemSeller WHERE InventoryID IN(".$GivingList.",".$WantList.")");
				$Delete->execute();
				
				$Delete = $db->prepare("DELETE FROM UserEquipped WHERE InventoryID IN(".$GivingList.",".$WantList.")");
				$Delete->execute();
				
				$Update = $db->prepare("UPDATE UserTrade SET Status = 3 WHERE ID != ".$gT->UserID." AND GivingOne IN(".$GivingList.",".$WantList.") OR GivingTwo IN(".$GivingList.",".$WantList.") OR GivingThree IN(".$GivingList.",".$WantList.") OR GivingFour IN(".$GivingList.",".$WantList.") OR WantOne IN(".$GivingList.",".$WantList.") OR WantTwo IN(".$GivingList.",".$WantList.") OR WantThree IN(".$GivingList.",".$WantList.") OR WantFour IN(".$GivingList.",".$WantList.")");
				$Update->execute();
				
				$Update = $db->prepare("UPDATE UserInventory SET UserID = ".$myU->ID.", TimeCreated = ".time()." WHERE UserInventory.ID IN(".$GivingList.")");
				$Update->execute();
				$UpdateOneSuccess = $Update->rowCount();
				
				$Update = $db->prepare("UPDATE UserInventory SET UserID = ".$gT->UserID.", TimeCreated = ".time()." WHERE UserInventory.ID IN(".$WantList.")");
				$Update->execute();
				$UpdateTwoSuccess = $Update->rowCount();
				
				$WithdrawCreditsOne = 1;
				$WithdrawCreditsTwo = 1;
				
				if ($gT->WantCredits > 0) {
					
					$Update = $db->prepare("UPDATE User SET CurrencyCredits = CurrencyCredits - ".$gT->WantCredits." WHERE ID = ".$myU->ID."");
					$Update->execute();
					$WithdrawCreditsOne = $Update->rowCount();
					
					$Update = $db->prepare("UPDATE User SET CurrencyCredits = CurrencyCredits + ".$gT->WantCredits." WHERE ID = ".$gT->UserID."");
					$Update->execute();
					
				}
				
				if ($gT->GivingCredits > 0) {
					
					$Update = $db->prepare("UPDATE User SET CurrencyCredits = CurrencyCredits - ".$gT->GivingCredits." WHERE ID = ".$gT->UserID."");
					$Update->execute();
					$WithdrawCreditsTwo = $Update->rowCount();
					
					$Update = $db->prepare("UPDATE User SET CurrencyCredits = CurrencyCredits + ".$gT->GivingCredits." WHERE ID = ".$myU->ID."");
					$Update->execute();
					
				}
				
				$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
				$InsertUserActionLog->bindValue(1, 'Accepted a trade (Trade ID: '.$gT->ID.')', PDO::PARAM_STR);
				$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
				$InsertUserActionLog->execute();
				
				$Count = $db->prepare("SELECT COUNT(*) FROM UserActionLog WHERE UserID = ".$myU->ID." AND Action = ? AND TimeLog = ".time()." AND IP = '".$UserIP."'");
				$Count->bindValue(1, 'Accepted a trade (Trade ID: '.$gT->ID.')', PDO::PARAM_STR);
				$Count->execute();
				$Count = $Count->fetchColumn();
				
				$Update = $db->prepare("UPDATE UserTrade SET Status = 1, UpdatedOn = ".time()." WHERE UserTrade.ID = ".$gT->ID."");
				$Update->execute();
				
				if ($UpdateOneSuccess == 0 || $UpdateTwoSuccess == 0 || $WithdrawCreditsOne == 0 || $WithdrawCreditsTwo == 0 || $Count > 1) {
					$db->rollBack();
					$Log = $db->prepare("INSERT INTO UserLogs (UserID, Message, LogTime, IP) VALUES(".$myU->ID.", ?, ".time().", '".$UserIP."')");
					$Log->bindValue(1, 'Error Log: '.$UpdateOneSuccess.' and '.$UpdateTwoSuccess.' and '.$WithdrawCreditsOne.' and '.$WithdrawCreditsTwo.' and '.$Count.'', PDO::PARAM_STR);
					$Log->execute();
				} else {
					$db->commit();
					redrawUserAvatarByUserInventoryId($GivingList.','.$WantList);
				}
				
				$cache->delete($myU->ID);
				$cache->delete($gT->UserID);
				
				header("Location: ".$serverName."/account/trades/");
				die;
				
			}
			
		} else if (!empty($_POST['decline']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gT->Expires > time() && $gT->ReceiverID == $myU->ID && $gT->Status == 0) {
			
			$Update = $db->prepare("UPDATE UserTrade SET Status = 2 WHERE ID = ".$gT->ID."");
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Declined a trade (Trade ID: '.$gT->ID.')', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($gT->UserID);
			
			header("Location: ".$serverName."/account/trades/");
			die;
			
		} else if (!empty($_POST['cancel']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gT->Expires > time() && $gT->RequesterID == $myU->ID && $gT->Status == 0) {
			
			$Update = $db->prepare("UPDATE UserTrade SET Status = 3 WHERE ID = ".$gT->ID."");
			$Update->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Canceled a trade (Trade ID: '.$gT->ID.')', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			$cache->delete($myU->ID);
			$cache->delete($gT->UserID);
			
			header("Location: ".$serverName."/account/trades/");
			die;
			
		}
		
		echo '
		<script>
			document.title = "View trade '; if ($gT->RequesterID == $myU->ID) { echo 'sent to'; } else { echo 'from'; } echo ' '.$gT->Username.' - Brick Create";
		</script>
		<div class="grid-x grid-margin-x align-middle">
			<div class="auto cell no-margin">
				<h4>View trade '; if ($gT->RequesterID == $myU->ID) { echo 'sent to'; } else { echo 'from'; } echo ' <strong>'.$gT->Username.'</strong> <span style="font-size:14px;"> - Expires '.date('m/d/Y g:iA', $gT->Expires).' CST</span></h4>
			</div>
			<div class="shrink cell right no-margin">
				<a href="'.$serverName.'/account/trades/" class="button button-grey" style="padding: 8px 15px;font-size:14px;line-height:1.25;">Return to Trades</a>
			</div>
		</div>
		<div class="push-10"></div>
		';
		
		if (isset($errorMessage)) {
			
			echo '<div class="error-message">'.$errorMessage.'</div>';
			
		}
		
		echo '
		<div class="container border-r md-padding">
			<div class="grid-x grid-margin-x">
				<div class="large-6 cell">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell">
							<h5>What you will give</h5>
						</div>
						<div class="shrink cell right">
						';
						
						if ($gT->ReceiverID == $myU->ID && $gT->WantCredits > 0) {
						
							echo '
							<div class="trade-credits text-left" style="padding:0;">You will give '.number_format($gT->WantCredits).' Credits</div>
							';
						
						} else if ($gT->RequesterID == $myU->ID && $gT->GivingCredits > 0) {
							
							echo '
							<div class="trade-credits text-left" style="padding:0;">You will give '.number_format($gT->GivingCredits).' Credits</div>
							';
							
						}
						
						echo '
						</div>
					</div>
					<div class="grid-x grid-margin-x">
					';
					
					if ($myU->ID == $gT->RequesterID) {
						//$RequestingList = $getGiving->fetch(PDO::FETCH_OBJ);
						$RequestType = $getGiving;
					} else {
						//$RequestingList = $getRequesting->fetch(PDO::FETCH_OBJ);
						$RequestType = $getRequesting;
					}
					
					while ($RList = $RequestType->fetch(PDO::FETCH_OBJ)) {
						
						echo '
						<div class="large-3 cell">
							<div class="store-item-card">
								<div class="card-image relative">
									<a href="'.$serverName.'/store/view/'.$RList->ID.'/" target="_blank" id="'.$RList->Name.'" title="'.$RList->Name.'"><img src="'.$cdnName . $RList->ThumbnailImage.'" style="margin:0 auto;display:block;"></a>
									<span id="number_copies" class="number-copies" title="'.$RList->ItemCount.' Copies">'.$RList->ItemCount.'</span>
								</div>
							</div>
						</div>
						';
						
					}
					
					echo '
					</div>
				</div>
				<div class="large-6 cell">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell">
							<h5>What you will receive</h5>
						</div>
						<div class="shrink cell right">
						';
						
						if ($gT->ReceiverID == $myU->ID && $gT->GivingCredits > 0) {
						
							echo '
							<div class="trade-credits text-left" style="padding:0;">You will receive '.number_format($gT->GivingCredits).' Credits</div>
							';
						
						} else if ($gT->RequesterID == $myU->OD && $gT->WantCredits > 0) {
							
							echo '
							<div class="trade-credits text-left" style="padding:0;">You will receive '.number_format($gT->WantCredits).' Credits</div>
							';
							
						}
						
						echo '
						</div>
					</div>
					<div class="grid-x grid-margin-x">
					';
					
					if ($myU->ID == $gT->RequesterID) {
						$RequestType = $getRequesting;
					} else {
						$RequestType = $getGiving;
					}
					
					while ($GList = $RequestType->fetch(PDO::FETCH_OBJ)) {
						
						echo '
						<div class="large-3 cell">
							<div class="store-item-card">
								<div class="card-image relative">
									<a href="'.$serverName.'/store/view/'.$GList->ID.'/" target="_blank" id="'.$GList->Name.'" title="'.$GList->Name.'"><img src="'.$cdnName . $GList->ThumbnailImage.'" style="margin:0 auto;display:block;"></a>
									<span id="number_copies" class="number-copies" title="'.$GList->ItemCount.' Copies">'.$GList->ItemCount.'</span>
								</div>
							</div>
						</div>
						';
						
					}

					echo '
					</div>
				</div>
			</div>
		</div>
		';
		
		if ($gT->Expires > time() && $gT->ReceiverID == $myU->ID && $gT->Status == 0) {
			
			echo '
			<div class="reveal item-modal" id="AcceptTrade" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
				<form action="" method="POST">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="modal-title">Accept Trade</div>
						</div>
						<div class="shrink cell no-margin">
							<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
					<div class="bc-modal-contentText">
						<p>Are you sure that you wish to <font color="#5AA843"><strong>accept</strong></font> this trade sent by <strong>'.$gT->Username.'</strong>?<br />This action can not be undone.</p>
					</div>
					<div class="push-15"></div>
					<div align="center">
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						<input type="submit" data-close class="button button-green store-button inline-block" name="accept" value="Yes, accept">
						<input type="button" data-close class="button button-grey store-button inline-block" value="No, go back">
					</div>
				</form>
			</div>
			<div class="reveal item-modal" id="DeclineTrade" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
				<form action="" method="POST">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="modal-title">Accept Trade</div>
						</div>
						<div class="shrink cell no-margin">
							<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
					<div class="bc-modal-contentText">
						<p>Are you sure that you wish to <font color="#C7021A"><strong>decline</strong></font> this trade sent by <strong>'.$gT->Username.'</strong>?<br />This action can not be undone.</p>
					</div>
					<div class="push-15"></div>
					<div align="center">
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						<input type="submit" data-close class="button button-red store-button inline-block" name="decline" value="Yes, decline">
						<input type="button" data-close class="button button-grey store-button inline-block" value="No, go back">
					</div>
				</form>
			</div>
			<div class="push-25"></div>
			<form action="" method="POST">
				<div class="grid-x grid-margin-x align-middle">
					<div class="auto cell no-margin">
						<input type="button" class="button button-green" value="Accept Trade" data-open="AcceptTrade">
					</div>
					<div class="shrink cell right no-margin">
						<input type="button" class="button button-red" value="Decline Trade" data-open="DeclineTrade">
					</div>
				</div>
			</form>
			';
			
		} else if ($gT->Expires > time() && $gT->RequesterID == $myU->ID && $gT->Status == 0) {
			
			echo '
			<div class="reveal item-modal" id="CancelTrade" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
				<form action="" method="POST">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="modal-title">Cancel Trade</div>
						</div>
						<div class="shrink cell no-margin">
							<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
					<div class="bc-modal-contentText">
						<p>Are you sure that you wish to <strong>cancel</strong> this trade?<br />This action can not be undone.</p>
					</div>
					<div class="push-15"></div>
					<div align="center">
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						<input type="submit" data-close class="button button-red store-button inline-block" name="cancel" value="Yes, cancel">
						<input type="button" data-close class="button button-grey store-button inline-block" value="No, go back">
					</div>
				</form>
			</div>
			<div class="push-25"></div>
			<form action="" method="POST">
				<div class="grid-x grid-margin-x align-middle">
					<div class="auto cell no-margin">
						<input type="button" class="button button-red" value="Cancel Trade" data-open="CancelTrade">
					</div>
				</div>
			</form>
			';
			
		} else if ($gT->Status == 1) {
			
			echo '<div class="push-15"></div><strong>This trade has been accepted.</strong>';
			
		} else if ($gT->Status == 2) {
			
			echo '<div class="push-15"></div><strong>This trade has been declined.</strong>';
			
		} else if ($gT->Status == 3) {
			
			echo '<div class="push-15"></div><strong>This trade has been canceled.</strong>';
			
		} else if ($gT->Expires < time()) {
			
			echo '<div class="push-15"></div><strong>This trade has expired.</strong>';
			
		}
		
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");