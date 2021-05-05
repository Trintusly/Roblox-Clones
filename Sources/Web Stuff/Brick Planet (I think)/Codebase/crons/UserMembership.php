<?php
	require_once('/var/www/html/root/private/db.php');

	// Grant daily Coins to VIP members.

	$getUsers = $db->prepare("SELECT User.ID, User.VIP, User.VIP_Recurring, User.VIP_Expires FROM User WHERE VIP != 0 AND User.NextUpgradeCoinPay <= ".time()."");
	$getUsers->execute();

	while ($gU = $getUsers->fetch(PDO::FETCH_OBJ)) {

		switch ($gU->VIP) {
			case 1:
				$Daily = '100';
				break;
			case 2:
				$Daily = '200';
				break;
			case 3:
				$Daily = '300';
				break;
		}

		$Update = $db->prepare("UPDATE User SET CurrencyCoins = CurrencyCoins + ".$Daily.", NextUpgradeCoinPay = ".(time() + 86400)." WHERE ID = ".$gU->ID."");
		$Update->execute();

	}

	// Find expired VIP members, and remove accordingly (or renew)

	$getUsers = $db->prepare("SELECT User.ID, User.VIP, User.VIP_Recurring, User.VIP_Expires FROM User WHERE VIP != 0 AND User.VIP_Expires <= ".time()."");
	$getUsers->execute();

	while ($gU = $getUsers->fetch(PDO::FETCH_OBJ)) {

		if ($gU->VIP_Recurring == 0) {

			$Update = $db->prepare("UPDATE User SET VIP = 0, VIP_Recurring = 0, VIP_Expires = 0 WHERE ID = ".$gU->ID."");
			$Update->execute();

			$Delete = $db->prepare("DELETE FROM UserBadge WHERE UserID = ".$gU->ID." AND AchievementID = ".($gU->VIP + 8)."");
			$Delete->execute();
			
			if ($gU->DiscordId > 0) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://discordapi.brickcreate.com/modify-user-vip?userId='.$gU->DiscordId.'&action=remove-role&level=' . $gU->VIP);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);
			}

		} else if ($gU->VIP_Recurring == 1) {

			$Update = $db->prepare("UPDATE User SET VIP_Expires = ".(time() + 2678400)." WHERE ID = ".$gU->ID."");
			$Update->execute();

		}

	}
