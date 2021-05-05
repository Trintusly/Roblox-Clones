<?php
require_once("/var/www/html/root/private/config.php");

	requireLogin();

	if ($SiteSettings->AllowTrades == 0) {

		echo '
		<h4>Temporarily unavailable</h4>
		<div class="container border-r md-padding">
			We\'re sorry, account trades are temporarily unavailable at this moment. Try again later.
		</div>
		';

		die;

	}

	if ($myU->Username == $_POST['username']) {

		header("Location: ".$serverName."/users/".$myU->Username."/");
		die;

	}

	if (empty($_POST['username']) || empty($_POST['giving_list']) || empty($_POST['requesting_list'])) {

		die;

	}

	$getUser = $db->prepare("SELECT ID, Username, TradeSettings, (SELECT COUNT(*) FROM Friend WHERE SenderID = ".$myU->ID." AND ReceiverID = User.ID AND Accepted = 1) AS CheckFriend, (SELECT COUNT(*) FROM BlockedUser WHERE (RequesterID = ".$myU->ID." AND BlockedID = User.ID) OR (RequesterID = User.ID AND BlockedID = ".$myU->ID.")) AS CheckBlocked, (SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE (Item.IsCollectible = 1 OR Item.ItemType = 7) AND Item.TradeLock = 0 AND UserInventory.UserID = ".$myU->ID." AND UserInventory.CanTrade = 1) AS SenderCollectibles, (SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE (Item.IsCollectible = 1 OR Item.ItemType = 7) AND Item.TradeLock = 0 AND UserInventory.UserID = User.ID AND UserInventory.CanTrade = 1) AS ReceiverCollectibles FROM User WHERE Username = ? AND AccountRestricted = 0");
	$getUser->bindValue(1, $_POST['username'], PDO::PARAM_STR);
	$getUser->execute();

	if ($getUser->rowCount() == 0) {

		echo 'We\'re sorry, an unexpected error has occurred.';

	} else {

		$gU = $getUser->fetch(PDO::FETCH_OBJ);

		if ($gU->TradeSettings == 1 && $gU->CheckFriend == 0 || $gU->CheckBlocked > 0 || $gU->TradeSettings == 2) {

			echo 'We\'re sorry, this user\'s privacy settings restricts you from trading with them.';

		} else if ($gU->SenderCollectibles == 0 || $gU->ReceiverCollectibles == 0) {

			echo 'We\'re sorry, both parties must have at least one (1) collectible in order to trade.';

		} else {

			$GivingList = (!empty($_POST['giving_list'])) ? implode(',', array_splice(array_unique(array_intersect_key(explode(',', $_POST['giving_list']), array_flip(array_filter(array_keys(explode(',', $_POST['giving_list'])), 'is_numeric')))), 0, 5)) : null;
			// vulnerable part below
			$RequestingList = (!empty($_POST['requesting_list'])) ? implode(',', array_splice(array_unique(array_intersect_key(explode(',', $_POST['requesting_list']), array_flip(array_filter(array_keys(explode(',', $_POST['requesting_list'])), 'is_numeric')))), 0, 5)) : null;
			$GivingCredits = (empty($_POST['giving_credits']) || !is_numeric($_POST['giving_credits']) || $_POST['giving_credits'] < 0) ? 0: (int)$_POST['giving_credits'];
			$RequestingCredits = (empty($_POST['requesting_credits']) || !is_numeric($_POST['requesting_credits']) || $_POST['requesting_credits'] < 0) ? 0: (int)$_POST['requesting_credits'];

			$MyInventory = $db->prepare("SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE ((Item.IsCollectible = 1) OR (Item.ItemType = 7)) AND Item.TradeLock = 0 AND Item.PublicView = 1 AND UserInventory.ID IN(".$GivingList.") AND UserInventory.UserID = ".$myU->ID." AND UserInventory.CanTrade = 1");
			$MyInventory->execute();
			$MyInventory = $MyInventory->fetchColumn();

			// sqli!
			$TheirInventory = $db->prepare("SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE ((Item.IsCollectible = 1) OR (Item.ItemType = 7)) AND Item.TradeLock = 0 AND Item.PublicView = 1 AND UserInventory.ID IN(".$RequestingList.") AND UserInventory.UserID = ".$gU->ID." AND UserInventory.CanTrade = 1");
			$TheirInventory->execute();
			$TheirInventory = $TheirInventory->fetchColumn();

			if ($MyInventory == 0 || $TheirInventory == 0 || $_POST['csrf_token'] != $_SESSION['csrf_token'] || empty($GivingList) || empty($RequestingList)) {

				echo 'We\'re sorry, an unexpected error has occurred.';

			} else if ($myU->CurrencyCredits < $GivingCredits) {

				echo 'We\'re sorry, you are requesting to give more Credits than you actually have.';

			} else {

				$Count = $db->prepare("SELECT COUNT(*) FROM UserTrade WHERE RequesterID = ".$myU->ID." AND Time+60 > ".time()."");
				$Count->execute();
				$Count = $Count->fetchColumn();

				if ($Count > 0) {

					echo 'We\'re sorry, you can only send one (1) trade per minute.';

				} else {

					$GivingList = explode(',', $GivingList);
					$RequestingList = explode(',', $RequestingList);

					if (empty($GivingList[1])) { $GivingList[1] = 0; }
					if (empty($GivingList[2])) { $GivingList[2] = 0; }
					if (empty($GivingList[3])) { $GivingList[3] = 0; }
					if (empty($RequestingList[1])) { $RequestingList[1] = 0; }
					if (empty($RequestingList[2])) { $RequestingList[2] = 0; }
					if (empty($RequestingList[3])) { $RequestingList[3] = 0; }

					$db->beginTransaction();

					$Insert = $db->prepare("INSERT INTO UserTrade (RequesterID, ReceiverID, Status, Time, Expires, GivingOne, GivingTwo, GivingThree, GivingFour, GivingCredits, WantOne, WantTwo, WantThree, WantFour, WantCredits, UpdatedOn) VALUES(".$myU->ID.", ".$gU->ID.", 0, ".time().", ".(time()+259200).", '".$GivingList[0]."', '".$GivingList[1]."', '".$GivingList[2]."', '".$GivingList[3]."', '".$GivingCredits."', '".$RequestingList[0]."', '".$RequestingList[1]."', '".$RequestingList[2]."', '".$RequestingList[3]."', '".$RequestingCredits."', ".time().")");
					$Insert->execute();
					$TradeId = $db->lastInsertId();

					$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
					$InsertUserActionLog->bindValue(1, 'Sent a trade request (Trade ID: '.$TradeId.')', PDO::PARAM_STR);
					$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
					$InsertUserActionLog->execute();

					$Count = $db->prepare("SELECT COUNT(*) FROM UserTrade WHERE RequesterID = ".$myU->ID." AND ReceiverID = ".$gU->ID." AND Time = ".time()."");
					$Count->execute();
					$Count = $Count->fetchColumn();

					if ($Count > 1) {
						$db->rollBack();
					} else {
						$db->commit();
						echo 'ok';
					}

				}

			}

		}

	}
