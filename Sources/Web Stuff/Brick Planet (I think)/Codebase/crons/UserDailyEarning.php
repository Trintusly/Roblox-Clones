<?php
	require_once('/var/www/html/root/private/db.php');
	
	$getRows = $db->prepare("SELECT UserDailyEarning.ID, UserDailyEarning.UserID, UserDailyEarning.Coins, UserDailyEarning.TimeStart, UserDailyEarning.TimeEnd, UserDailyEarning.TransactionsCount, User.CurrencyCoins FROM UserDailyEarning JOIN User ON UserDailyEarning.UserID = User.ID WHERE UserDailyEarning.TimeEnd < ".time()." AND UserDailyEarning.Status = 0");
	$getRows->execute();
	
	while ($gR = $getRows->fetch(PDO::FETCH_OBJ)) {
		
		$Flag = 0;
		
		$getYesterday = $db->prepare("SELECT Coins, TransactionsCount FROM UserDailyEarning WHERE UserID = ".$gR->UserID." AND TimeEnd = UNIX_TIMESTAMP(CURDATE())");
		$getYesterday->execute();
		
		if ($getYesterday->rowCount() == 0) {
			$YesterdayCoins = 0;
			$YesterdayTransactions = 0;
		} else {
			$gY = $getYesterday->fetch(PDO::FETCH_OBJ);
			$YesterdayCoins = ($gY->Coins == 0) ? 1 : $gY->Coins;
			$YesterdayTransactions = ($gY->TransactionsCount == 0) ? 1 : $gY->TransactionsCount;
		}
		
		/*
		Check for major percentage increases that are otherwise unlikely
		*/
		
		$PercentChange = (($gR->TransactionsCount - $YesterdayTransactions)/$YesterdayTransactions)*100;
		
		if ($PercentChange > 10000) {
			$Flag = 1;
		}
		
		$PercentChange = (($gR->Coins - $YesterdayCoins)/$YesterdayCoins)*100;
		
		if ($PercentChange > 10000) {
			$Flag = 1;
		}
		
		/*
		Check for:
		 - Accounts buying items that are linked by IP (aka coin farming)
		*/
		
		// Check if buyers have IP(s) matching the seller
		
		$Check = $db->prepare("SELECT COUNT(*) FROM UserTransactionLog JOIN UserIP ON UserTransactionLog.UserID = UserIP.UserID WHERE UserTransactionLog.EventID = 1 AND UserTransactionLog.ReferenceID IN(SELECT ID FROM Item WHERE CreatorID = ".$gR->UserID.") AND UserTransactionLog.TimeTransaction >= ".$gR->TimeStart." AND UserTransactionLog.TimeTransaction <= ".$gR->TimeEnd." AND UserIP.IP IN(SELECT IP FROM UserIP WHERE UserID = ".$gR->UserID.")");
		$Check->execute();
		$Count = $Check->fetchColumn();
		
		if ($Count > 2) {
			$Flag = 1;
		}
		
		// Check if buyers share the same IP(s)
		
		$Check = $db->prepare("SELECT COUNT(*) FROM UserTransactionLog JOIN UserIP ON UserTransactionLog.UserID = UserIP.UserID WHERE UserTransactionLog.EventID = 1 AND UserTransactionLog.ReferenceID IN(SELECT ID FROM Item WHERE CreatorID = ".$gR->UserID." AND CreatorType = 0) AND UserTransactionLog.TimeTransaction >= ".$gR->TimeStart." AND UserTransactionLog.TimeTransaction <= ".$gR->TimeEnd." GROUP BY IP HAVING COUNT(*) > 1");
		$Check->execute();
		$Count = $Check->fetchColumn();
		
		if ($Count > 2) {
			$Flag = 1;
		}
		
		/* Process Tax & Payout */
		
		switch (true) {
			case $gR->Coins <= 500:
				$Math = 1;
				break;
			case $gR->Coins <= 5000:
				$Math = 0.9;
				break;
			case $gR->Coins <= 10000:
				$Math = 0.85;
				break;
			case $gR->Coins <= 50000:
				$Math = 0.775;
				break;
			case $gR->Coins > 50000:
				$Math = 0.7;
				break;
		}
		
		$ReceiveAmount = floor($gR->Coins*$Math);
		
		if ($Flag == 0 || $gR->UserID == -1) {
			
			$Update = $db->prepare("UPDATE User SET CurrencyCoins = CurrencyCoins + ".$ReceiveAmount.", TotalEarningsCount = TotalEarningsCount + ".$ReceiveAmount." WHERE ID = ".$gR->UserID."");
			$Update->execute();
			
			$Update = $db->prepare("UPDATE UserDailyEarning SET Status = 1 WHERE ID = ".$gR->ID."");
			$Update->execute();
			
		} else {
			
			$Update = $db->prepare("UPDATE UserDailyEarning SET Status = 2 WHERE ID = ".$gR->ID."");
			$Update->execute();
			
			$Insert = $db->prepare("INSERT INTO ap.EarningInvestigation (EarningID, EarningType, FlagType, TimeInvestigation) VALUES(".$gR->ID.", 0, ".$Flag.", ".time().")");
			$Insert->execute();
			
		}
		
	}
	
	$setRanks = $db->prepare("SELECT ID FROM User WHERE TotalEarningsCount > 0 ORDER BY TotalEarningsCount DESC");
	$setRanks->execute();
	
	$i = 0;
	
	while ($sR = $setRanks->fetch(PDO::FETCH_OBJ)) {
		
		$i++;
		
		$Update = $db->prepare("UPDATE User SET TotalEarningsRank = ".$i." WHERE ID = ".$sR->ID."");
		$Update->execute();
		
	}
	