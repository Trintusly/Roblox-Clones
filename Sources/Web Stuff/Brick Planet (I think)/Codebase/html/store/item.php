<?php
$page = 'store';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	if (!$AUTH) { $myU = new stdClass(); $myU->ID = -1; $myU->CurrencyCoins = 0;  }
	if ($SiteSettings->CatalogPurchases == 0) {
		$STOREAUTH = false;
	} else {
		$STOREAUTH = true;
	}

	if ($myU->Admin > 0) {
		$STOREAUTH = true;
	}

	$getItem = $db->prepare("
	SELECT
		Item.ID, Item.ItemType, Item.Name, Item.Description, Item.CreatorType, Item.TimeCreated, Item.TimeUpdated, Item.Cost, Item.CostCredits, Item.SaleActive, Item.PreviewImage, Item.IsCollectible, Item.InitialStock, Item.RemainingStock, Item.NumberCopies, Item.NumberFavorites, Item.PublicView, Item.TimeOffSale, Item.ItemSellerCount, Item.TradeLock,
		(CASE WHEN Item.CreatorType = 0 THEN User.ID END) AS UserID,
        (CASE WHEN Item.CreatorType = 0 THEN User.Username END) AS Username,
		(CASE WHEN Item.CreatorType = 0 THEN User.AvatarURL END) AS AvatarURL,
        (CASE WHEN Item.CreatorType = 0 THEN User.VIP END) AS VIP,
        (CASE WHEN Item.CreatorType = 1 THEN UserGroup.ID END) AS GroupID,
        (CASE WHEN Item.CreatorType = 1 THEN UserGroup.Name END) AS GroupName,
        (CASE WHEN Item.CreatorType = 1 THEN UserGroup.SEOName END) AS GroupSEOName,
        (CASE WHEN Item.CreatorType = 1 THEN UserGroup.LogoImage END) AS GroupLogo,
        COUNT(UserInventory.ID) AS CheckOwnership,
        (CASE WHEN UserInventory.CanTrade IS NULL THEN '0' ELSE UserInventory.CanTrade END) AS CanTrade,
		GROUP_CONCAT(UserInventory.ID, ':', UserInventory.CrateOpened, ':', UserInventory.CanTrade, ':', (SELECT COUNT(*) FROM ItemSeller WHERE ItemID = Item.ID AND InventoryID = UserInventory.ID) SEPARATOR ';') AS CrateIDs,
		(CASE WHEN Item.ItemType = 7 THEN (SELECT GROUP_CONCAT(ItemCrateContent.ContentRarity, ':', ItemCrateContent.ContentType, ':', ItemCrateContent.ContentValue, ':', I.ID, ':', I.Name, ':', I.ThumbnailImage ORDER BY ItemCrateContent.ContentRarity DESC SEPARATOR ';') FROM ItemCrateContent JOIN Item I ON I.ID = (CASE WHEN ItemCrateContent.ContentType = 1 THEN ItemCrateContent.ContentID ELSE 1 END) WHERE ItemCrateContent.ItemID = Item.ID) ELSE NULL END) AS CrateContents
	FROM
		Item
		LEFT JOIN User ON User.ID = Item.CreatorID
        LEFT JOIN UserInventory ON UserInventory.ItemID = Item.ID
		LEFT JOIN UserGroup ON UserGroup.ID = (CASE WHEN Item.CreatorType = 0 THEN '1' ELSE Item.CreatorID END)
	WHERE
		Item.ID = ?
        AND UserInventory.UserID = ".$myU->ID."
	");
	$getItem->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getItem->execute();

	if ($getItem->rowCount() == 0) {

		header("Location: ".$serverName."/store/");
		die;

	}

	$gI = $getItem->fetch(PDO::FETCH_OBJ);

	if ($gI->PublicView == 0 && $myU->Admin < 1 || $gI->PublicView == 0 && !$AUTH || empty($gI->ID)) {

		header("Location: ".$serverName."/store/");
		die;

	}

	//if ($AUTH && $gI->CheckImpression == 0) {

		//$Insert = $db->prepare("INSERT INTO ItemImpression (ItemID, UserID) VALUES(".$gI->ID.", ".$myU->ID.")");
		//$Insert->execute();

	//}

	if ($gI->PreviewImage == 'pending.png' || $gI->PreviewImage == 'rejected.png') {
		$gI->SaleActive = 0;
	}

	$NumCheckOwnership = $gI->CheckOwnership;

	echo '
	<script>document.title = "'.htmlentities($gI->Name).' - Brick Planet";</script>
	';

	if ($AUTH) {
		if (isset($_SESSION['Search_RecordNextPage'])) {
			$logSearchHistory = $db->prepare("INSERT INTO UserSearchHistory (UserID, ContentType, ContentID, TimeSearch) VALUES(".$myU->ID.", 2, ".$gI->ID.", ".time().")");
			$logSearchHistory->execute();
			if ($logSearchHistory->rowCount() == 0) {
				$update = $db->prepare("UPDATE UserSearchHistory SET TimeSearch = ".time()." WHERE UserID = ".$myU->ID." AND ContentType = 2 AND ContentID = ".$gI->ID."");
				$update->execute();
			}
			unset($_SESSION['Search_RecordNextPage']);
			header("Location: ".$serverName . $_SERVER['REQUEST_URI']."");
			die;
		}
	}

	if (isset($_POST['favorite']) && isset($myU->Username) && $myU->UserFlood < time()) {

		$_POST['csrf_favorite'] = str_replace(' ', '+', $_POST['csrf_favorite']);
		$_POST['csrf_unfavorite'] = str_replace(' ', '+', $_POST['csrf_unfavorite']);

		if (isset($_POST['favorite']) && $_POST['csrf_favorite'] == $_SESSION['csrf_token']) {

			$checkFavoritedUser = $db->prepare("SELECT COUNT(*) FROM `ItemFavorite` WHERE `UserID` = ".$myU->ID." AND `ItemID` = ".$gI->ID."");
			$checkFavoritedUser->execute();

			$checkFavoritedIP = $db->prepare("SELECT COUNT(*) FROM `ItemFavorite` WHERE `IP` = '".$_SERVER['REMOTE_ADDR']."' AND `ItemID` = ".$gI->ID."");
			$checkFavoritedIP->execute();

			if ($checkFavoritedUser->fetchColumn() == 0 && $checkFavoritedIP->fetchColumn() == 0) {

				$favorite = $db->prepare("INSERT INTO `ItemFavorite` (UserID, ItemID, Time, IP) VALUES(?, ?, ?, ?)");
				$favorite->bindValue(1, $myU->ID, PDO::PARAM_INT);
				$favorite->bindValue(2, $gI->ID, PDO::PARAM_INT);
				$favorite->bindValue(3, time(), PDO::PARAM_INT);
				$favorite->bindValue(4, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
				$favorite->execute();

				$updateFlood = $db->prepare("UPDATE User SET UserFlood = ".(time() + 10)." WHERE ID = ".$myU->ID."");
				$updateFlood->execute();

			}

			header("Location: ".$serverName."/store/view/".$gI->ID."/");
			die;

		}

	}

	else if (isset($_POST['favorite']) && isset($myU->Username) && $myU->UserFlood > time()) {
		$errorItemFavoriteMsg = "null";
	}

	else if (isset($_POST['favorite']) && !isset($myU->Username)) {
		$_SESSION['ReturnLocation'] = "/store/view/".$gI->ID."/";
		header("Location: /log-in/");
		die;
	}

	if (isset($_POST['unfavorite']) && isset($myU->Username) && $myU->UserFlood < time()) {

		if (isset($_POST['unfavorite']) && $_POST['csrf_unfavorite'] == $_SESSION['csrf_token']) {

			$checkFavoritedUser = $db->prepare("SELECT COUNT(*) FROM `ItemFavorite` WHERE `UserID` = ".$myU->ID." AND `ItemID` = ".$gI->ID."");
			$checkFavoritedUser->execute();

			if ($checkFavoritedUser->fetchColumn() == 1) {

				$remove = $db->prepare("DELETE FROM `ItemFavorite` WHERE `UserID` = ".$myU->ID." AND `ItemID` = ".$gI->ID."");
				$remove->execute();

				$updateFlood = $db->prepare("UPDATE User SET UserFlood = ".(time() + 10)." WHERE ID = ".$myU->ID."");
				$updateFlood->execute();

			}

			header("Location: ".$serverName."/store/view/".$gI->ID."/");
			die;

		}

	}

	else if (isset($_POST['unfavorite']) && isset($myU->Username) && $myU->UserFlood > time()) {
		$errorItemFavoriteMsg = "null";
	}

	else if (isset($_POST['unfavorite']) && !isset($myU->Username)) {
		$_SESSION['ReturnLocation'] = "/store/view/".$gI->ID."/";
		header("Location: /log-in/");
		die;
	}

	if (isset($_POST['Payment']) && isset($_POST['ConfirmYes']) && $gI->SaleActive == 1 && $_SESSION['csrf_token'] == $_POST['csrf_token'] && isset($myU->Username) && $STOREAUTH == true && time() > $_SESSION['NextBuyItem'] && $AUTH && ($gI->IsCollectible == 0 || $gI->IsCollectible == 1 && $gI->ItemType == 7) && $myU->AccountVerified == 1) {

		if ($gI->Cost < 1) {
			$_POST['Payment'] = "Free";
		}

		$_SESSION['NextBuyItem'] = time() + 5;

		if ($_POST['Payment'] != 'Free' && $_POST['Payment'] != 'Bits') {
			$returnError = '1';
		}

		else if ($_POST['Payment'] == 'Free' && $gI->Cost > 0 && $gI->ItemType != 7){
			$returnError = '2';
		}

		else if ($_POST['Payment'] == 'Bits' && $gI->Cost == null) {
			$returnError = '3';
		}

		else if ($NumCheckOwnership > 0 && $gI->ItemType != 7) {
			$returnError = 'You already own this item.';
		}

		else if ($myU->CurrencyCoins < $gI->Cost && $gI->ItemType != 7 || $myU->CurrencyCredits < $gI->CostCredits && $gI->ItemType == 7) {
			$returnError = 'You do not have enough currency to purchase this item.';
		}

		else if ($gI->IsCollectible == 1 && $gI->RemainingStock > 0 && $myU->Admin > 0) {
			$returnError = 'You can not buy this item.';
		}

		else {

			$lastInsert = $db->lastInsertId();

			if ($gI->Cost == -1 || $gI->Cost == 'free') {
				$gI->Cost = 0;
			}

			$Price = $gI->Cost;

			if ($gI->VIP == 0) {

				$Tax = 0.85; // Put back as 0.50 later

			}

			else {

				$Tax = 0.85;

			}

			$TaxSeller = floor($Price*$Tax);

			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Purchased item for '.$Price.' Bits (Item ID: '.$gI->ID.')', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();

			$db->beginTransaction();

			//possible vuln
			if ($gI->ItemType != 7) {
				$removeCurrency = $db->prepare("UPDATE User SET CurrencyCoins = CurrencyCoins - '".$Price."' WHERE ID = ".$myU->ID."");
				$removeCurrency->execute();
			} else {
				$removeCurrency = $db->prepare("UPDATE User SET CurrencyCredits = CurrencyCredits - ".$gI->CostCredits." WHERE ID = ".$myU->ID."");
				$removeCurrency->execute();
			}

			$insert = $db->prepare("INSERT INTO UserInventory (UserID, ItemID, TimeCreated) VALUES(".$myU->ID.", ".$gI->ID.", ".time().")");
			$insert->execute();

			$insertHistory = $db->prepare("INSERT INTO ItemSalesHistory (BuyerID, CreatorID, ItemID, Price, Time, PaymentType, InventoryID) VALUES(?, ?, ?, ?, ?, ?, ?)");
			$insertHistory->bindValue(1, $myU->ID, PDO::PARAM_INT);
			$insertHistory->bindValue(2, $gI->UserID, PDO::PARAM_INT);
			$insertHistory->bindValue(3, $gI->ID, PDO::PARAM_INT);
			$insertHistory->bindValue(4, $Price, PDO::PARAM_INT);
			$insertHistory->bindValue(5, time(), PDO::PARAM_INT);
			$insertHistory->bindValue(6, 0, PDO::PARAM_STR);
			$insertHistory->bindValue(7, $db->lastInsertId(), PDO::PARAM_INT);
			$insertHistory->execute();

			if ($gI->CreatorType == 0) {

				$log = $db->prepare("INSERT INTO UserTransactionLog (UserID, EventID, ReferenceID, PreviousBalance, NewBalance, TimeTransaction) VALUES(".$myU->ID.", 1, ".$gI->ID.", ".$myU->CurrencyCoins.", ".($myU->CurrencyCoins-$Price).", ".time().")");
				$log->execute();

			} else {

				$log = $db->prepare("INSERT INTO UserTransactionLog (UserID, EventID, ReferenceID, PreviousBalance, NewBalance, TimeTransaction) VALUES(".$myU->ID.", 2, ".$gI->ID.", ".$myU->CurrencyCoins.", ".($myU->CurrencyCoins-$Price).", ".time().")");
				$log->execute();

			}

			$count = $db->prepare("SELECT COUNT(*) FROM UserInventory WHERE UserID = ".$myU->ID." AND ItemID = ".$gI->ID." AND (TimeCreated = ".(time() - 1)." OR TimeCreated = ".time().")");
			$count->execute();

			$checkCash = $removeCurrency->rowCount();

			if ($count->fetchColumn() > 1) {

				$db->rollBack();
				//sendExecutiveEmail("Duplicate purchase catched", "".$myU->Username." attempted to duplicate purchase item ".$gI->Name." (Item ID: ".$gI->ID.") for ".$Price." ".$PaymentType." on ".date('m/d/Y g:iA')." CST");

			}

			else {

				if ($Price >= 50000 && $PaymentType == 'Bits') {

					sendExecutiveEmail("Large purchase", "".$myU->Username." purchased item ".$gI->Name." (Item ID: ".$gI->ID.") for ".$Price." ".$PaymentType." on ".date('m/d/Y g:iA')." CST");

				}

				$db->commit();

			}

			$cache->delete($myU->ID);

			$_SESSION['Notification_Item'] = 'Success';
			header("Location: ".$serverName."/store/view/".$gI->ID."/");
			die;
		}

	}

	if (isset($_POST['report_item'])) {

		$_SESSION['Report_ReferenceType'] = 8 + $gI->CreatorType;
		$_SESSION['Report_ReferenceID'] = $gI->ID;

		header("Location: ".$serverName."/report/");
		die;

	}

	$CrateIDs = explode(';', $gI->CrateIDs);

	if ($gI->ItemType == 7) {

		if (!empty($_POST['open_crate_inventory_id']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && !empty($gI->CrateIDs)) {

			$Check = $db->prepare("SELECT ID FROM UserInventory WHERE ID = ? AND UserID = ".$myU->ID." AND CrateOpened = 0");
			$Check->bindValue(1, $_POST['open_crate_inventory_id'], PDO::PARAM_INT);
			$Check->execute();

			if ($Check->rowCount() == 1) {

				$InventoryID = $Check->fetchColumn();

				function determineCrateRarity(array $weightedValues) {
					$rand = mt_rand(1, (int) array_sum($weightedValues));

					foreach ($weightedValues as $key => $value) {
						$rand -= $value;
						if ($rand <= 0) {
							return $key;
						}
					}
				}

				function determineWinningCrateItem($CrateID, $InventoryID) {

					global $db;
					global $myU;
					$Rarity = array(0 => 74, 1 => 16, 2 => 8, 3 => 1.8, 4 => 0.2);
					$WinningRarity = determineCrateRarity($Rarity);

					//possible vuln
					$Count = $db->prepare("SELECT COUNT(*) FROM ItemCrateContent WHERE ItemID = ".$CrateID." AND ContentRarity = ".$WinningRarity."");
					$Count->execute();

					if ($Count->fetchColumn() == 0) {
						determineWinningCrateItem($CrateID);
					} else {
						$Update = $db->prepare("UPDATE UserInventory SET CrateOpened = 0, CrateItemID = (SELECT ID FROM ItemCrateContent WHERE ItemID = ".$CrateID." AND ContentRarity = ".$WinningRarity." ORDER BY RAND() LIMIT 1) WHERE ID = ".$InventoryID." AND UserID = ".$myU->ID."");
						$Update->execute();
					}

				}

				$db->beginTransaction();

				determineWinningCrateItem($gI->ID, $InventoryID);
				$CrateIDs[array_search($InventoryID.':0', $CrateIDs)] = $InventoryID.':1';
				$getWinningInfo = $db->prepare("SELECT ItemCrateContent.ID AS CrateContentID, Item.ID, Item.Name, Item.PreviewImage, Item.ThumbnailImage, ItemCrateContent.ContentValue FROM ItemCrateContent LEFT JOIN Item ON Item.ID = (CASE WHEN ItemCrateContent.ContentType = 1 THEN ItemCrateContent.ContentID ELSE 0 END) WHERE ItemCrateContent.ID = (SELECT CrateItemID FROM UserInventory WHERE ID = ".$InventoryID." AND UserID = ".$myU->ID.") AND ItemCrateContent.ItemID = ".$gI->ID."");
				$getWinningInfo->execute();
				$gWI = $getWinningInfo->fetch(PDO::FETCH_OBJ);
				$WinningItemPic = (empty($gWI->ID)) ? $serverName.'/assets/images/bits-125.png' : $cdnName . $gWI->PreviewImage;
				$WinningItemDiv = (empty($gWI->ID)) ? 'crate-winner-coins' : 'crate-winner-item';
				$WinningItemName = (empty($gWI->ID)) ? number_format($gWI->ContentValue).' Bits' : $gWI->Name;

				if ($WinningItemName == '0 Bits') {

					$db->rollBack();

					$_SESSION['returnError'] = 'An unexpected has occurred opening the crate. Your crate has been preserved, please try again. We apologize.';

					header("Location: ".$serverName."/store/view/".$gI->ID."/");
					die;

				} else {

					if (empty($gWI->ID)) {

						$Update = $db->prepare("UPDATE User SET CurrencyCoins = CurrencyCoins + ".$gWI->ContentValue." WHERE ID = ".$myU->ID."");
						$Update->execute();

					} else {

						$Insert = $db->prepare("INSERT INTO UserInventory (UserID, ItemID, TimeCreated) VALUES(".$myU->ID.", ".$gWI->ID.", ".time().")");
						$Insert->execute();

					}

					$cache->delete($myU->ID);

					$PrizesArray = array();
					$PrizesRarity = array();
					$getPrizes = $db->prepare("SELECT ItemCrateContent.ID AS CrateContentID, ItemCrateContent.ContentRarity, Item.ThumbnailImage FROM ItemCrateContent LEFT JOIN Item ON Item.ID = (CASE WHEN ItemCrateContent.ContentType = 1 THEN ItemCrateContent.ContentID ELSE 0 END) WHERE ItemCrateContent.ItemID = ".$gI->ID."");
					$getPrizes->execute();

					while ($gP = $getPrizes->fetch(PDO::FETCH_OBJ)) {

						switch ($gP->ContentRarity) {
							case 0:
								$HexCode = '4F953B';
								break;
							case 1:
								$HexCode = '0598E8';
								break;
							case 2:
								$HexCode = '9A2EFE';
								break;
							case 3:
								$HexCode = 'B40404';
								break;
							case 4:
								$HexCode = 'F0BE1D';
								break;
						}

						if (empty($gP->ThumbnailImage)) {
							array_push($PrizesArray, '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>');
							$PrizesRarity[$gP->CrateContentID] = $HexCode;
						} else {
							array_push($PrizesArray, '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>', '<div class="crate-item" style="border-bottom:2px solid #'.$HexCode.';"><div class="crate-item-image" style="background:url('.$cdnName . $gP->ThumbnailImage.');background-size:cover;"></div></div>');
							$PrizesRarity[$gP->CrateContentID] = $HexCode;
						}

					}

					shuffle($PrizesArray);
					$WinningIndex = floor(count($PrizesArray)*0.5)+1;
					$PrizesArray[$WinningIndex] = (empty($gWI->ID)) ? '<div class="crate-item" style="border-bottom:2px solid #'.$PrizesRarity[$gWI->CrateContentID].';"><div class="crate-item-image" style="background:url('.$serverName.'/assets/images/bits-75.png);background-size:cover;"></div></div>' : '<div class="crate-item" style="border-bottom:2px solid #'.$PrizesRarity[$gWI->CrateContentID].';"><div class="crate-item-image" style="background:url('.$cdnName . $gWI->ThumbnailImage.');background-size:cover;"></div></div>';

					$Delete = $db->prepare("DELETE FROM UserInventory WHERE ID = ".$InventoryID."");
					$Delete->execute();

					$Insert = $db->prepare("INSERT INTO ItemCrateLog (ItemID, UserID, Text, TimeLog) VALUES(".$gI->ID.", ".$myU->ID.", ?, ".time().")");
					$Insert->bindValue(1, "".$myU->Username." (User ID: ".$myU->ID.") has opened crate ".$gI->Name." (Item ID: ".$gI->ID.") and won: ".$WinningItemName."", PDO::PARAM_STR);
					$Insert->execute();

					$Count = $db->prepare("SELECT COUNT(*) FROM ItemCrateLog WHERE ItemID = ".$gI->ID." AND UserID = ".$myU->ID." AND TimeLog = ".time()."");
					$Count->execute();

					if ($Count->fetchColumn() > 1) {
						$db->rollBack();
					} else {
						$db->commit();
					}

					echo '
					<script src="'.$serverName.'/assets/js/jquery-ui.min.js"></script>
					<div class="reveal item-modal" id="CrateAnimation" data-reveal data-animation-in="fade-in" data-animation-out="fade-out" style="width:705px;margin:0 auto;">
						<div class="container border-r md-padding" style="width:100%;overflow:hidden;">
							<div class="crate-contents">
							';

							foreach ($PrizesArray as $Prize) {

								echo $Prize;

							}

							echo '
							</div>
							<div class="push-25"></div>
							<div class="crate-bottom-divider">
								<div class="crate-arrow-up"><span><i class="material-icons">arrow_upward</i></span></div>
							</div>
						</div>
					</div>
					<div class="reveal item-modal" id="WinningCrateItemModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
						<div class="'.$WinningItemDiv.'" style="background:url('.$WinningItemPic.');background-size:cover;"></div>
						<div class="crate-winner-name">Congratulations, you won <strong>'.$WinningItemName.'</strong>!</div>
						<div class="push-15"></div>
						<div class="text-center" align="center">
							';

							if (!empty($gWI->ID)) {

								echo '
								<input type="button" class="button button-blue store-button inline-block" onclick="window.location.href = \''.$serverName.'/account/character/\'" value="Edit Character">
								';

							}

							echo '
							<input type="button" data-close class="button button-grey store-button inline-block" value="Close">
						</div>
					</div>
					<script>
						window.onload = function() {
							$("#CrateAnimation").foundation("open");
							setTimeout(RunCrateSpinner, 500);
						}

						function RunCrateSpinner() {
							var $item = $(".crate-item");
							$item.animate({"left":"-='.(($WinningIndex-2)*125).'px"}, 3000, "easeOutQuad");
							setTimeout(OpenWinningDiv, 3100);
						}

						function OpenWinningDiv() {
							$("#WinningCrateItemModal").foundation("open");
							$("#CrateAnimation").foundation("close");
						}
					</script>
					';

				}

			}

		}

		$SelectHTML = '';
		$UnopenedCount = 0;
		$i = 0;
		$seller_i = 0;

		foreach ($CrateIDs as $CrateID) {

			$CrateID = explode(':', $CrateID);
			$i++;

			if ($CrateID[1] == 0) {
				$SelectHTML .= '<option value="'.$CrateID[0].'">Copy #'.$i.'</option>';
				$UnopenedCount++;
			}

		}

	}

	$seller_i = 0;
	foreach ($CrateIDs as $CrateID) {
		$CrateID = explode(':', $CrateID);
		if ($CrateID[2] == 1) {
			$seller_i++;
		}
	}

	if (!empty($_POST['SellInventoryID']) && !empty($_POST['SellPrice']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gI->ItemType != 7 && $gI->TradeLock == 0) {

		$Count = $db->prepare("SELECT COUNT(*) FROM UserInventory WHERE ID = ? AND UserID = ".$myU->ID." AND CanTrade = 1");
		$Count->bindValue(1, $_POST['SellInventoryID'], PDO::PARAM_INT);
		$Count->execute();

		if ($Count->fetchColumn() == 0) {

			$returnError = 'An unexpected error has occurred.';

		} else if (!is_numeric($_POST['SellPrice']) || $_POST['SellPrice'] < 2) {

			$returnError = 'Invalid price, must be at least 2 Bits.';

		} else {

			$Insert = $db->prepare("INSERT INTO ItemSeller (ItemID, InventoryID, UserID, Price, TimeCreated) VALUES(".$gI->ID.", ?, ".$myU->ID.", ?, ".time().")");
			$Insert->bindValue(1, $_POST['SellInventoryID'], PDO::PARAM_INT);
			$Insert->bindValue(2, $_POST['SellPrice'], PDO::PARAM_INT);
			$Insert->execute();

			header("Location: ".$serverName."/store/view/".$gI->ID."/");
			die;

		}

	}

	if (!empty($_POST['RemoveItemSaleID']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gI->ItemType != 7 && $gI->TradeLock == 0) {

		$Delete = $db->prepare("DELETE FROM ItemSeller WHERE ID = ? AND ItemID = ".$gI->ID." AND UserID = ".$myU->ID."");
		$Delete->bindValue(1, $_POST['RemoveItemSaleID'], PDO::PARAM_INT);
		$Delete->execute();

		header("Location: ".$serverName."/store/view/".$gI->ID."/");
		die;

	}

	if (!empty($_POST['PrivateSaleID']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gI->ItemType != 7 && $gI->TradeLock == 0) {

		$Get = $db->prepare("SELECT InventoryID, UserID, Price FROM ItemSeller WHERE ID = ? AND UserID != ".$myU->ID."");
		$Get->bindValue(1, $_POST['PrivateSaleID'], PDO::PARAM_INT);
		$Get->execute();

		if ($Get->rowCount() > 0) {

			$G = $Get->fetch(PDO::FETCH_OBJ);

			if ($G->Price > $myU->CurrencyCoins) {

				$returnError = 'An unexpected error has occurred.';

			} else {

				$db->beginTransaction();

				$Remove = $db->prepare("UPDATE User SET CurrencyCoins = CurrencyCoins - ".$G->Price." WHERE ID = ".$myU->ID."");
				$Remove->execute();

				if ($Remove->rowCount() > 0) {

					$Update = $db->prepare("UPDATE UserInventory SET UserID = ".$myU->ID." WHERE ID = ".$G->InventoryID."");
					$Update->execute();

					$log = $db->prepare("INSERT INTO UserTransactionLog (UserID, EventID, ReferenceID, PreviousBalance, NewBalance, TimeTransaction) VALUES(".$myU->ID.", 3, ".$gI->ID.", ".$myU->CurrencyCoins.", ".($myU->CurrencyCoins-$G->Price).", ".time().")");
					$log->execute();

					$UTLID = $db->lastInsertId();

					$Delete = $db->prepare("DELETE FROM ItemSeller WHERE ID = ?");
					$Delete->bindValue(1, $_POST['PrivateSaleID'], PDO::PARAM_INT);
					$Delete->execute();

					$Insert = $db->prepare("INSERT INTO ItemSellerHistory (UTLID, ItemID, SellerID, BuyerID, Price, TimeSale) VALUES(".$UTLID.", ".$gI->ID.", ".$G->UserID.", ".$myU->ID.", ".$G->Price.", ".time().")");
					$Insert->execute();

					$Count = $db->prepare("SELECT COUNT(*) FROM ItemSellerHistory WHERE UTLID = ".$UTLID." AND ItemID = ".$gI->ID." AND SellerID = ".$G->UserID." AND BuyerID = ".$myU->ID." AND Price = ".$G->Price." AND TimeSale = ".time()."");
					$Count->execute();

					$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
					$InsertUserActionLog->bindValue(1, 'Purchased item for '.$G->Price.' Bits from (User ID: '.$G->UserID.') (Inventory ID: '.$G->InventoryID.') (Item ID: '.$gI->ID.')', PDO::PARAM_STR);
					$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
					$InsertUserActionLog->execute();

					redrawUserAvatarByUserInventoryItemId($G->UserID, $gI->ID, 0);

					if ($Count->fetchColumn() > 1) {
						$db->rollBack();
					} else {
						$db->commit();
					}

				} else {
					$db->rollBack();
				}

				$cache->delete($myU->ID);

				header("Location: ".$serverName."/store/view/".$gI->ID."/");
				die;

			}

		} else {

			$returnError = 'An unexpected error has occurred.';

		}

	}

	if (isset($_SESSION['Notification_Item'])=="Success") {
		echo '
		<div class="pure-alert pure-alert-success">
			<strong>Purchase successful!</strong>
			We have added '.$gI->Name.' to your backpack. Would you like to <a href="/account/character/" style="color:#ffffff;font-weight:bold;">customize your character</a>?
        </div>
		';
		unset($_SESSION['Notification_Item']);
	}

	/* correct this later (show "favoriting too fast" error message)
	if (isset($errorItemFavoriteMsg)) {
		echo '
		<div class="pure-alert pure-alert-warning">
			<strong>Failed to update!</strong>
			You are favoriting too fast! Please try favoriting/unfavoriting this item again later.
        </div>
		';
	}
	*/

	if ($STOREAUTH == false) {

		echo '
		<div class="error-message">
			<span><i class="material-icons" style="vertical-align:middle;margin-right:5px;font-size:20px;">report_problem</i></span><span><strong>Oops!</strong> Store purchases are currently down. We will have them back up soon!</span>
		</div>
		';
	}

	if (isset($returnError)) {

		echo '<div class="error-message">'.$returnError.'</div>';

	}

	if (isset($_SESSION['returnError'])) {

		echo '<div class="error-message">'.$_SESSION['returnError'].'</div>';
		unset($_SESSION['returnError']);

	}

	echo '
	<meta property="og:title" content="'.htmlentities($gI->Name).'">
	<meta property="og:type" content="website">
	<meta property="og:url" content="'.$serverName.'/store/view/'.$gI->ID.'/">
	<meta property="og:image" content="https://cdn.brickplanet.com/'.$gI->PreviewImage.'">
	<meta property="og:site_name" content="Brick Planet">
	<meta property="og:description" content="\''.htmlentities(strip_tags($gI->Name)).'\' is an item on Brick Planet, a user generated content sandbox game with tens of thousands of active players. Play today!">
	<style>
		.crate-button-contents {
			padding: 3px 15px;
			font-size: 14px;
			position: absolute;
			bottom: 0;
			right: 0;
			margin: 10px 10px;
		}

		.crate-button-contents-view {
			padding: 3px 15px;
			font-size: 14px;
		}

		.crate-contents-image-coins {
			background:url('.$serverName.'/assets/images/bits-125.png);
			background-size: cover;
			width: 75px;
			height: 75px;
			margin: 0 auto;
			border-radius: 50%;
		}

		.crate-contents-image-item {
			width: 75px;
			height: 75px;
			margin: 0 auto;
			border-radius: 50%;
		}

		.crate-contents-image-item img {
			padding: 10px;
		}

		.crate-contents-divider {
			margin: 15px 0;
			height: 1px;
			width: 100%;
			background: #676978;
		}

		.crate-rarity-color {
			width: 10px;
			height: 10px;
			border-radius: 50%;
			margin-right: 8px;
		}

		.crate-rarity-name {
			font-weight: 600;
			margin-right: 20px;
		}
	</style>
	';

	if ($gI->ItemType == 7) {

		$CrateContents = explode(';', $gI->CrateContents);

		echo '
		<div class="reveal item-modal" id="ViewCrateContents" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
			<h5>Crate Contents</h5>
			<div class="push-15"></div>
			<div class="grid-x grid-margin-x align-middle">
				<div class="shrink cell no-margin">
					<div class="crate-rarity-color" style="background:#4F953B;"></div>
				</div>
				<div class="shrink cell no-margin">
					<div class="crate-rarity-name">Common</div>
				</div>
				<div class="shrink cell no-margin">
					<div class="crate-rarity-color" style="background:#0598E8;"></div>
				</div>
				<div class="shrink cell no-margin">
					<div class="crate-rarity-name">Rare</div>
				</div>
				<div class="shrink cell no-margin">
					<div class="crate-rarity-color" style="background:#9A2EFE;"></div>
				</div>
				<div class="shrink cell no-margin">
					<div class="crate-rarity-name">Epic</div>
				</div>
				<div class="shrink cell no-margin">
					<div class="crate-rarity-color" style="background:#B40404;"></div>
				</div>
				<div class="shrink cell no-margin">
					<div class="crate-rarity-name">Mythic</div>
				</div>
				<div class="shrink cell no-margin">
					<div class="crate-rarity-color" style="background:#F0BE1D;"></div>
				</div>
				<div class="shrink cell no-margin">
					<div class="crate-rarity-name">Legendary</div>
				</div>
			</div>
			<div class="push-15"></div>
			';

			$i = 0;

			foreach ($CrateContents as $CrateContent) {

				$i++;

				if ($i > 1) { echo '<div class="crate-contents-divider"></div>'; }

				$CrateContent = explode(':', $CrateContent);
				$CrateRarity = $CrateContent[0];
				$CrateType = $CrateContent[1];
				$CrateValue = $CrateContent[2];
				$CrateItemID = $CrateContent[3];
				$CrateItemName = $CrateContent[4];
				$CrateItemImage = $CrateContent[5];

				switch ($CrateRarity) {
					case 0:
						$HexCode = '4F953B';
						break;
					case 1:
						$HexCode = '0598E8';
						break;
					case 2:
						$HexCode = '9A2EFE';
						break;
					case 3:
						$HexCode = 'B40404';
						break;
					case 4:
						$HexCode = 'F0BE1D';
						break;
				}

				echo '
				<div class="grid-x grid-margin-x align-middle">
					<div class="shrink cell">
					';

					if ($CrateType == 0) {

						echo '<div class="crate-contents-image-coins" style="border:1px solid #'.$HexCode.';"></div>';

					} else {

						echo '<div class="crate-contents-image-item" style="border:1px solid #'.$HexCode.';"><img src="'.$cdnName . $CrateItemImage.'"></div>';

					}

					echo '
					</div>
					<div class="auto cell">
					';

					if ($CrateType == 0) {

						echo '<strong>'.number_format($CrateValue).' Bits</strong>';

					} else {

						echo '<strong>'.$CrateItemName.'</strong>';

					}

					echo '
					</div>
					';

					if ($CrateType == 1) {

						echo '
						<div class="shrink cell">
							<a href="'.$serverName.'/store/view/'.$CrateItemID.'/" target="_blank" class="button button-blue crate-button-contents-view">View</a>
						</div>
						';

					}

					echo '
				</div>
				';

			}

			echo '
		</div>
		';

	}

	echo '
	<div class="container lg-padding border-r">
		<div class="grid-x grid-margin-x">
			<div class="large-8 medium-8 small-6 cell">
				<div class="store-item-card relative">
					<img class="item-image" src="'.$cdnName . $gI->PreviewImage.'">
					';

					if ($AUTH && $gI->Username != 'BrickPlanet') {

						echo '
						<form action="" method="POST">
							<button class="report-abuse report-abuse-item" name="report_item"></button>
						</form>
						';

					}

					if ($gI->ItemType == 7) {

						echo '
						<button class="button button-blue crate-button-contents" data-open="ViewCrateContents">View Crate Contents</button>
						';

					}

					echo '
				</div>
				';

				if ($gI->IsCollectible == 0 && $gI->ItemType != 7) {

					echo '
					<div class="grid-x grid-margin-x">
						<div class="large-3 medium-3 small-6 cell text-center">
							<div class="item-info-content">'.date('M d, Y', $gI->TimeCreated).'</div>
							<div class="item-info-title">CREATED</div>
							<div class="push-15"></div>
						</div>
						<div class="large-3 medium-3 small-6 cell text-center">
							<div class="item-info-content">'.date('M d, Y', $gI->TimeUpdated).'</div>
							<div class="item-info-title">UPDATED</div>
							<div class="push-15"></div>
						</div>
						<div class="large-3 medium-3 small-6 cell text-center">
							<div class="item-info-content">'.number_format($gI->NumberCopies).'</div>
							<div class="item-info-title">OWNERS</div>
							<div class="push-15"></div>
						</div>
						<div class="large-3 medium-3 small-6 cell text-center">
							<div class="item-info-content">'.number_format($gI->NumberFavorites).'</div>
							<div class="item-info-title">FAVORITES</div>
							<div class="push-15"></div>
						</div>
					</div>
					';

				} else {

					echo '
					<div class="grid-x grid-margin-x">
						<div class="large-4 medium-4 small-4 cell text-center">
							<div class="item-info-content">'.date('M d, Y', $gI->TimeCreated).'</div>
							<div class="item-info-title">CREATED</div>
							<div class="push-15"></div>
						</div>
						<div class="large-4 medium-4 small-4 cell text-center">
							<div class="item-info-content">'.date('M d, Y', $gI->TimeUpdated).'</div>
							<div class="item-info-title">UPDATED</div>
							<div class="push-15"></div>
						</div>
						<div class="large-4 medium-4 small-4 cell text-center">
							<div class="item-info-content">'.number_format($gI->NumberFavorites).'</div>
							<div class="item-info-title">FAVORITES</div>
							<div class="push-15"></div>
						</div>
					</div>
					';


				}

				echo '
			</div>
			<div class="large-4 medium-4 small-6 cell">
				<div class="grid-x align-middle grid-margin-x">
					<div class="auto cell no-margin">
						<div class="item-name">
							<span>'.$gI->Name.'</span>
							';

							if ($gI->Username == $myU->Username) {

								echo '
								<span><a href="'.$serverName.'/store/edit/'.$gI->ID.'/" class="item-edit" title="Edit item"><i class="material-icons">border_color</i></a></span>
								';

							}

							echo '
						</div>
					</div>
					<div class="shrink cell right no-margin">
						<form action="" method="post">
						';
						if ($gI->ItemType != 4 && $AUTH) {

							$checkFavorited = $db->prepare("SELECT COUNT(*) FROM `ItemFavorite` WHERE `UserID` = ".$myU->ID." AND `ItemID` = ".$gI->ID."");
							$checkFavorited->execute();

							if ($checkFavorited->fetchColumn() == 0) {

								echo '
								<button type="submit" name="favorite" title="Favorite item" class="item-star"><i class="material-icons">star_bordered</i></button>
								<input type="hidden" name="csrf_favorite" value="'.$_SESSION['csrf_token'].'">
								';

							}

							else {

								echo '
								<button type="submit" name="unfavorite" title="Unfavorite item" class="item-star"><i class="material-icons">star</i></button>
								<input type="hidden" name="csrf_unfavorite" value="'.$_SESSION['csrf_token'].'">
								';

							}

						}

						echo '
						</form>
					</div>
				</div>
				<div class="item-divider"></div>
				<div class="item-category">
					';

					switch ($gI->ItemType) {
						case 1:
							echo 'Hat';
							break;
						case 2:
							echo 'Face';
							break;
						case 3:
							echo 'Accessory';
							break;
						case 4:
							echo 'T-Shirt';
							break;
						case 5:
							echo 'Shirt';
							break;
						case 6:
							echo 'Pants';
							break;
						case 7:
							echo 'Crate';
							break;
					}

					if ($gI->IsCollectible == 1 && $gI->ItemType != 7) {

						echo ', <strong>COLLECTIBLE</strong>';

					}

					echo '
				</div>
				';

				if ($gI->SaleActive == 1 || $gI->ItemType == 7) {

					if ($gI->Cost == 0) {
						$price = 'Free';
					} else {
						$price = number_format($gI->Cost) . ' Bits';
						$varSign = '<img src="'.$serverName.'/assets/images/bits-sm.png">';
					}

					if ($gI->ItemType != 7) {

						echo '
						<div class="grid-x grid-margin align-middle item-price">
							<div class="shrink cell">
							';
							if (isset($varSign)) {
								echo '
								'.$varSign.'
								';
							}
							echo '
							</div>
							<div class="shrink cell">
								<span>'.$price.'</span>
							</div>
						</div>
						';

					} else if ($gI->ItemType == 7 && $gI->SaleActive == 1) {

						echo '
						<div class="grid-x grid-margin align-middle item-price">
							<div class="shrink cell">
								<img src="'.$serverName.'/assets/images/credits-sm.png">
							</div>
							<div class="shrink cell">
								<strong style="margin-left:5px;">'.$gI->CostCredits.' Credits</strong>
							</div>
						</div>
						';

					}

					if ($myU->AccountVerified == 0) {

						echo '
						<button type="submit" class="button item-buy-button" disabled>
							<span class="has-tip" data-tooltip aria-haspopup="true" title="You must verify your email address before you can purchase items." style="cursor:not-allowed !important;">Buy Now</span>
						</button>
						';

					} else if ($myU->AccountVerified == 1 && $gI->SaleActive == 1) {

						echo '
						<input type="button" class="item-buy-button" value="Buy Now" data-open="BuyNowModal">
						<div class="reveal item-modal" id="BuyNowModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
						';

						if (!$AUTH) {

							if ($gI->ItemType != 7) {
								if ($gI->Cost == 0) {
									$gI->Cost = "free";
								} else {
									if ($gI->Cost == 1) {
										$term = "Bit";
									} else {
										$term = "Bits";
									}
									$gI->Cost = "<font class='coins-text'>".$gI->Cost." ".$term."</font>";
								}
							} else {
								$gI->Cost = '<strong>'.$gI->CostCredits.' Credits</strong>';
							}

							echo '
							<div class="grid-x grid-margin-x align-middle">
								<div class="auto cell no-margin">
									<div class="modal-title">Please log in to continue with this purchase.</div>
								</div>
								<div class="shrink cell no-margin">
									<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
								</div>
							</div>
							<div class="bc-modal-contentText">
								<p>
									You will need to log in to your user account to purchase <a href="'.$serverName.'/store/view/'.$gI->ID.'/">'.$gI->Name.'</a> from <a href="'.$serverName.'/users/'.$gI->Username.'/">'.$gI->Username.'</a> for <font class="modalPrice">'.$gI->Cost.'</font>. Would you like to log in?</p>
								<div align="center" style="margin-top:15px;">
									<input type="submit" class="button button-green store-button inline-block" name="ConfYes" onClick="window.location.href = \'/log-in/\'" value="Log in">
									<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
								</div>
							</div>
							';
						}

						else if ($STOREAUTH == false) {
							echo '
							<div class="grid-x grid-margin-x align-middle">
								<div class="auto cell no-margin">
									<div class="modal-title">Store purchases are temporarily unavailable.</div>
								</div>
								<div class="shrink cell no-margin">
									<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
								</div>
							</div>
							<div class="bc-modal-contentText">
								<p>We apologize, but store purchases are temporarily <strong>unavailable</strong>. No items may be sold or traded right now. Our services should be back online soon!</p>
								<div align="center" style="margin-top:15px;">
									<input type="submit" class="button button-green store-button inline-block" name="UpgradeDownConfYes" onClick="window.location.href = \'/store/\'" value="Browse more items">
									<input type="button" data-close class="button button-red store-button inline-block" value="Go back">
								</div>
							</div>
							';
						}

						else if ($NumCheckOwnership > 0 && $gI->ItemType != 7) {

							if ($gI->ItemType != 7) {
								if ($gI->Cost == 0) {
									$gI->Cost = "free";
								}

								else {
									if ($gI->Cost <= 1) {
										$term = "Bit";
									}
									else {
										$term = "Bits";
									}
									$gI->Cost = "<font class='coins-text'>".$gI->Cost." ".$term."</font>";
								}
							} else {
								$gI->Cost = '<strong>'.$gI->CostCredits.' Credits</strong>';
							}

							echo '
							<div class="grid-x grid-margin-x align-middle">
								<div class="auto cell no-margin">
									<div class="modal-title">It looks like this item is already in your backpack.</div>
								</div>
								<div class="shrink cell no-margin">
									<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
								</div>
							</div>
							<div class="bc-modal-contentText">
								<p>You are not able to re-purchase <a href="'.$serverName.'/store/view/'.$gI->ID.'/">'.$gI->Name.'</a> from <a href="'.$serverName.'/users/'.$gI->Username.'/">'.$gI->Username.'</a> for <font class="modalPrice">'.$gI->Cost.'</font>. You are only allowed to own one copy of this particular item in your inventory!</p>
								<div align="center" style="margin-top:15px;">
									<input type="submit" class="button button-green store-button inline-block" name="ConfYes" onClick="window.location.href = \'/store/\'" value="Shop for more items">
									<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
								</div>
							</div>
							';
						}

						else if ($gI->ItemType != 7 && $myU->CurrencyCoins < $gI->Cost || $gI->ItemType == 7 && $myU->CurrencyCredits < $gI->CostCredits) {

							if ($gI->ItemType != 7) {
								if ($gI->Cost == 0) {
									$gI->Cost = "free";
								}

								else {
									if ($gI->Cost <= 1) {
										$term = "Bit";
									}
									else {
										$term = "Bits";
									}
									$gI->Cost = "<font class='coins-text'>".$gI->Cost." ".$term."</font>";
								}
								$CurrencyType = 'currency';
							} else {
								$CurrencyType = 'credits';
								$gI->Cost = '<strong>'.$gI->CostCredits.' Credits</strong>';
							}

							echo '
							<div class="grid-x grid-margin-x align-middle">
								<div class="auto cell no-margin">
									<div class="modal-title">Oh no, you do not have enough to purchase this item!</div>
								</div>
								<div class="shrink cell no-margin">
									<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
								</div>
							</div>
							<div class="bc-modal-contentText">
								<p>You do not have enough '.$CurrencyType.' to purchase <a href="'.$serverName.'/store/view/'.$gI->ID.'/">'.$gI->Name.'</a> from <a href="'.$serverName.'/users/'.$gI->Username.'/">'.$gI->Username.'</a> for <font class="modalPrice">'.$gI->Cost.'</font>. Would you like to buy some upgrades so that you can make this purchase?</p>
								<div align="center" style="margin-top:15px;">
									<input type="submit" class="button button-green store-button inline-block" name="ConfirmYes" onClick="window.location.href = \''.$serverName.'/upgrade/\'" value="Yes, show me upgrades">
									<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
								</div>
							</div>
							';
						}
						else {

							if ($gI->ItemType != 7) {
								if ($gI->Cost == 0) {
									$CostNum = 0;
									$gI->Cost = "free";
								} else {
									$CostNum = $gI->Cost;
									$gI->Cost = '<font class="coins-text">' . $gI->Cost . ' Bits</font>';
								}
							} else {
								$gI->Cost = '<strong>'.$gI->CostCredits.' Credits</strong>';
							}

							echo '
							<form action="" method="post">
								<div class="grid-x grid-margin-x align-middle">
									<div class="auto cell no-margin">
										<div class="modal-title">Are you sure you would like to make this purchase?</div>
									</div>
									<div class="shrink cell no-margin">
										<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
									</div>
								</div>
								<p>Are you sure you would like to buy <a href="'.$serverName.'/store/view/'.$gI->ID.'/">'.$gI->Name.'</a> from <a href="'.$serverName.'/users/'.$gI->Username.'/">'.$gI->Username.'</a> for '.$gI->Cost.'? Your balance after this transaction will be '; if ($gI->ItemType != 7) { echo '<font class="coins-text">'.number_format(($myU->CurrencyCoins - $CostNum)).' Bits</font>'; } else { echo '<strong>'.number_format(($myU->CurrencyCredits - $gI->CostCredits)).' Credits</strong>'; } echo ' and will not be able to be refunded.</p>
								<div align="center" style="margin-top:15px;">
									<input type="submit" class="button button-green store-button inline-block" name="ConfirmYes" value="Yes, purchase item">
									<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
									<input type="hidden" name="Payment" value="Bits">
									<input type="button" data-close class="button button-grey store-button inline-block" value="No, cancel">
								</div>
							</form>
							';
						}

						echo '
						</div>
						';

					}

				}

				echo '
				<div class="view-item-right-creator-parent">
					<div class="grid-x grid-margin-x">
						<div class="large-12 cell text-center">
						';

						if ($gI->CreatorType == 0) {

							echo '
							<a href="'.$serverName.'/users/'.$gI->Username.'/">
								<div class="view-item-right-creator-avatar" style="background-image:url('; if ($gI->Username == 'BrickPlanet') { echo ''.$cdnName.'web/BCIconPadding.png);background-size: 98px 98px;'; } else { echo ''.$cdnName . $gI->AvatarURL.'-thumb.png);'; } echo '"></div>
							</a>
							';

						} else if ($gI->CreatorType == 1) {

							echo '
							<a href="'.$serverName.'/groups/'.$gI->GroupID.'/'.$gI->GroupSEOName.'/"><div class="view-item-right-creator-avatar" style="background-image:url('.$cdnName . $gI->GroupLogo.');"></div></a>
							<a href="'.$serverName.'/groups/'.$gI->GroupID.'/'.$gI->GroupSEOName.'/"><div class="view-item-right-creator-name">'.$gI->GroupName.'</div></a>
							';

						}

						if ($gI->Username == "BrickPlanet") {
							echo '
							<div class="grid-x grid-margin-x item-creator">
								<div class="large-12 cell text-center">
									<i class="material-icons">done</i>
									<span><a href="'.$serverName.'/users/'.$gI->Username.'/">Brick Planet</a></span>
								</div>
							</div>
							';
						}
						else {
							echo '
							<a href="'.$serverName.'/users/'.$gI->Username.'/"><div class="view-item-right-creator-name">'.$gI->Username.'</div></a>
							';
						}

						echo '
						</div>
					</div>
				</div>
				<div class="item-divider"></div>
				';

				if ($AUTH && $gI->ItemType == 7 && $UnopenedCount > 0 && !empty($gI->CrateIDs)) {

					echo '
					<div class="item-description">OPEN CRATE</div>
					<form action="" method="POST">
						<select class="normal-input" name="open_crate_inventory_id" style="padding:8px 15px;font-size:16px;">
							'.$SelectHTML.'
						</select>
						<div class="push-10"></div>
						<input type="submit" class="button button-green" value="Open" style="display:block;width:100%;">
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
					</form>
					<div class="item-divider"></div>
					';

				}

				echo '
				<div class="item-description">DESCRIPTION</div>
				<div class="view-item-right-description">
					'.nl2br($gI->Description).'
				</div>
			</div>
		</div>
	</div>
	';

	if ($gI->IsCollectible == 1 && $gI->ItemType != 7 && $gI->TradeLock == 0) {

		echo '
		<div class="push-15"></div>
		<a name="ItemSellers"></a>
		<div class="grid-x grid-margin-x align-middle">
			<div class="auto cell no-margin">
				<h5>Sellers ('.number_format($gI->ItemSellerCount).')</h5>
			</div>
			<div class="shrink cell right no-margin">
				';

				if ($gI->CheckOwnership > 0 && $seller_i > 0 && $AUTH) {

					if ($myU->VIP > 0) {

						$SellTaxRate = 30;
						$MathTaxRate = 0.70;

					} else {

						$SellTaxRate = 20;
						$MathTaxRate = 0.80;

					}

					echo '
					<button type="button" class="button button-grey" style="padding:3px 15px;font-size:14px;line-height:1.25;" data-open="SellItem">Sell Item</button>
					<div class="reveal item-modal" id="SellItem" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
						<form action="" method="POST">
							<div class="grid-x grid-margin-x align-middle">
								<div class="auto cell no-margin">
									<div class="modal-title">Sell item</div>
								</div>
								<div class="shrink cell no-margin">
									<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
								</div>
							</div>
							<div class="bc-modal-contentText">
								<p>Please select which copy you wish to sell.</p>
								<select name="SellInventoryID" class="normal-input" style="font-size:14px;">
								';

								$i = 0;



								foreach ($CrateIDs as $CrateID) {

									$CrateID = explode(':', $CrateID);

									if ($CrateID[2] == 0 || $CrateID[3] > 0) {
										continue;
									}

									$i++;

									echo '<option value="'.$CrateID[0].'">Copy #'.$i.'</option>';

								}

								echo '
								</select>
								<div class="push-15"></div>
								<label for="SellPrice">Price (Bits)</label>
								<input type="text" class="normal-input" id="SellPrice" name="SellPrice" style="font-size:14px;" onchange="updateCoinsEstimate(this.value)" value="2">
								<div class="sell-item-coins-estimate">After tax ('.$SellTaxRate.'%), you will receive <font class="coins-text" id="UpdateCoinsEstimate">1 Bits</font></div>
								<div align="center" style="margin-top:15px;">
									<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
									<input type="submit" class="button button-green store-button inline-block" value="Sell">
									<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
								</div>
							</div>
						</form>
					</div>
					<script>
						function numberWithCommas(x) {
							return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						}

						function updateCoinsEstimate(value) {
							if (value < 2) {
								document.getElementById("SellPrice").value = 2;
							}
							document.getElementById("UpdateCoinsEstimate").innerHTML = numberWithCommas(parseFloat(((value*'.($MathTaxRate).'))).toFixed(0))+" Bits";
						}
					</script>
					';

				}

				echo '
			</div>
		</div>
		<style>
			.item-seller-div {
				padding: 15px;
			}

			.item-seller-div a {
				color: #DDDDDD;
				font-weight: 600;
				font-size: 16px;
			}

			.item-seller-divider {
				background: #373840;
				height: 1px;
				width: 100%;
			}

			.item-seller-avatar {
				width: 32px;
				height: 32px;
				border: 1px solid #676978;
				border-radius: 50%;
			}
		</style>
		<div class="push-5"></div>
		<div class="container border-r">
			';

			if ($gI->ItemSellerCount == 0) {

				echo '
				<div style="padding:15px;">
					No one is currently selling this collectible.
				</div>
				';

			} else {

				$limit = 10;

				$pages = ceil($gI->ItemSellerCount / $limit);

				$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
					'options' => array(
						'default'   => 1,
						'min_range' => 1,
					),
				)));

				$offset = ($page - 1)  * $limit;
				if ($offset < 0) { $offset = 0; }

				$getSellers = $db->prepare("SELECT ItemSeller.ID, ItemSeller.UserID, User.Username, User.AvatarURL, ItemSeller.Price FROM ItemSeller JOIN User ON User.ID = ItemSeller.UserID WHERE ItemSeller.ItemID = ".$gI->ID." ORDER BY ItemSeller.Price ASC LIMIT ? OFFSET ?");
				$getSellers->bindValue(1, $limit, PDO::PARAM_INT);
				$getSellers->bindValue(2, $offset, PDO::PARAM_INT);
				$getSellers->execute();
				$sellerCounter = 0;

				while ($gS = $getSellers->fetch(PDO::FETCH_OBJ)) {

					$sellerCounter++;

					if ($sellerCounter > 1) {

						echo '<div class="item-seller-divider"></div>';

					}

					echo '
					<div class="item-seller-div">
						<div class="grid-x grid-margin-x align-middle">
							<div class="shrink cell">
								<a href="'.$serverName.'/users/'.$gS->Username.'/"><div class="item-seller-avatar" style="background:url('.$cdnName . $gS->AvatarURL.'-thumb.png);background-size:cover;"></div></a>
							</div>
							<div class="auto cell">
								<a href="'.$serverName.'/users/'.$gS->Username.'/">'.$gS->Username.'</a>
							</div>
							<div class="shrink cell right">
								<button type="button" class="button button-green" style="padding:8px 15px;font-size:14px;line-height:1.25;" data-open="ItemSeller'.$gS->ID.'"'; if ($gS->UserID == $myU->ID || $myU->AccountVerified == 0) { echo ' disabled'; } echo '>Buy for '.number_format($gS->Price).' Bits</button>
								<div class="reveal item-modal" id="ItemSeller'.$gS->ID.'" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
									<form action="" method="POST">
									';

									if ($gS->UserID != $myU->ID) {

										if (!$AUTH) {

											echo '
											<div class="grid-x grid-margin-x align-middle">
												<div class="auto cell no-margin">
													<div class="modal-title">Please log in to continue with this purchase.</div>
												</div>
												<div class="shrink cell no-margin">
													<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
												</div>
											</div>
											<div class="bc-modal-contentText">
												<p>
													You will need to log in to your user account to purchase <a href="'.$serverName.'/store/view/'.$gI->ID.'/">'.$gI->Name.'</a> from <a href="'.$serverName.'/users/'.$gS->Username.'/">'.$gS->Username.'</a> for <font class="coins-text"><strong>'.number_format($gS->Price).' Bits</strong></font>. Would you like to log in?</p>
												<div align="center" style="margin-top:15px;">
													<input type="submit" class="button button-green store-button inline-block" name="ConfYes" onClick="window.location.href = \'/log-in/\'" value="Log in">
													<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
												</div>
											</div>
											';

										} else if ($STOREAUTH == false) {

											echo '
											<div class="grid-x grid-margin-x align-middle">
												<div class="auto cell no-margin">
													<div class="modal-title">Store purchases are temporarily unavailable.</div>
												</div>
												<div class="shrink cell no-margin">
													<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
												</div>
											</div>
											<div class="bc-modal-contentText">
												<p>We apologize, but store purchases are temporarily <strong>unavailable</strong>. No items may be sold or traded right now. Our services should be back online soon!</p>
												<div align="center" style="margin-top:15px;">
													<input type="button" class="button button-green store-button inline-block" name="UpgradeDownConfYes" onClick="window.location.href = \'/store/\'" value="Browse more items">
													<input type="button" data-close class="button button-red store-button inline-block" value="Go back">
												</div>
											</div>
											';

										} else if ($gS->Price > $myU->CurrencyCoins) {

											echo '
											<div class="grid-x grid-margin-x align-middle">
												<div class="auto cell no-margin">
													<div class="modal-title">Oh no, you do not have enough to purchase this item!</div>
												</div>
												<div class="shrink cell no-margin">
													<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
												</div>
											</div>
											<div class="bc-modal-contentText">
												<p>You do not have enough Bits to purchase <a href="'.$serverName.'/store/view/'.$gI->ID.'/">'.$gI->Name.'</a> from <a href="'.$serverName.'/users/'.$gS->Username.'/">'.$gS->Username.'</a> for <font class="coins-text"><strong>'.number_format($gS->Price).' Bits</strong></font>. Would you like to buy some upgrades so that you can make this purchase?</p>
												<div align="center" style="margin-top:15px;">
													<input type="button" class="button button-green store-button inline-block" onClick="window.location.href = \''.$serverName.'/upgrade/\'" value="Yes, show me upgrades">
													<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
												</div>
											</div>
											';

										} else {

											echo '
											<div class="grid-x grid-margin-x align-middle">
												<div class="auto cell no-margin">
													<div class="modal-title">Are you sure you would like to make this purchase?</div>
												</div>
												<div class="shrink cell no-margin">
													<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
												</div>
											</div>
											<p>Are you sure you would like to buy <a href="'.$serverName.'/store/view/'.$gI->ID.'/">'.$gI->Name.'</a> from <a href="'.$serverName.'/users/'.$gS->Username.'/">'.$gS->Username.'</a> for <font class="coins-text"><strong>'.number_format($gS->Price).' Bits</strong></font>? Your balance after this transaction will be <font class="coins-text"><strong>'.number_format($myU->CurrencyCoins - $gS->Price).' Bits</strong></font> and will not be able to be refunded.</p>
											<div align="center" style="margin-top:15px;">
												<input type="submit" class="button button-green store-button inline-block" name="BuyPrivateSale" value="Yes, purchase item">
												<input type="hidden" name="PrivateSaleID" value="'.$gS->ID.'">
												<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
												<input type="button" data-close class="button button-grey store-button inline-block" value="No, cancel">
											</div>
											';

										}

									}

									echo '
									</form>
								</div>
							</div>
							';

							if ($gS->UserID == $myU->ID) {

							echo '
							<div class="shrink cell right">
								<form action="" method="POST">
									<input type="submit" class="button button-red" class="button button-green" value="Remove" style="padding:8px 15px;font-size:14px;line-height:1.25;">
									<input type="hidden" name="RemoveItemSaleID" value="'.$gS->ID.'">
									<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
								</form>
							</div>
							';

							}

							echo '
						</div>
					</div>
					';

				}

			}

			echo '
		</div>
		';

		if ($gI->ItemSellerCount > 0 && $pages > 1) {

			echo '
			<div class="push-25"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/store/view/'.$gI->ID.'/?page='.($page-1).'#ItemSellers">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
				';

				for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

					if ($i <= $pages) {

						echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/store/view/'.$gI->ID.'/?page='.($i).'#ItemSellers">'.$i.'</a></li>';

					}

				}

				echo '
				<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/store/view/'.$gI->ID.'/?page='.($page+1).'#ItemSellers">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
			</ul>
			';

		}

	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
