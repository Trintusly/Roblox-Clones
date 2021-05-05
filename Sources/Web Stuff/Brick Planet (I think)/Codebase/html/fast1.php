<?php
require_once("/var/www/html/root/private/config.php");

	$cache->delete('AdminIdArray');
	die;
	$UserIdArray = array(1, 1337);
	$AdminIdList = $cache->get('AdminIdList');
	if (!$AdminIdList) {
		$GetUser = $db->prepare("SELECT GROUP_CONCAT(ID) FROM User WHERE Admin > 0");
		$GetUser->execute();
		$cache->set('AdminIdList', explode(',', $GetUser->fetchColumn()), 86400);
		$AdminIdList = $cache->get('AdminIdList');
	}
	var_dump($AdminIdList);
	$AdminIdArray = explode(',', $AdminIdList);
	
	$AdminInGame = (count(array_intersect($UserIdArray, $AdminIdArray))) ? true : false;
	var_dump($AdminInGame);

	/*$GetUserGames = $db->prepare("SELECT UserGame.ID, UserGame.Name FROM game.UserGame WHERE SEOName IS NULL");
	$GetUserGames->execute();
	
	while ($gG = $GetUserGames->fetch(PDO::FETCH_OBJ)) {
		
		$SEOName = str_replace(' ', '-', str_replace('/', '--', $gG->Name));
		$UpdateUserGame = $db->prepare("UPDATE game.UserGame SET SEOName = ? WHERE ID = ".$gG->ID."");
		$UpdateUserGame->bindValue(1, $SEOName, PDO::PARAM_STR);
		$UpdateUserGame->execute();
		echo "Updated ID: {$gG->ID}\n";
		
	}*/
	
	//$UpdateUserGame = $db->prepare("UPDATE game.UserGame JOIN User ON UserGame.UserID = User.ID SET UserGame.SEOName = CONCAT(User.Username, '\'s-Untitled-Game') WHERE UserGame.Name = CONCAT(User.Username, '\'s Untitled Game')")

	/*$Query = $db->prepare("SELECT Item.ID, Item.CreatorID, Item.TimeCreated, Item.ItemType FROM Item WHERE PreviewImage = 'pending.png'");
	$Query->execute();
	
	while ($Q = $Query->fetch(PDO::FETCH_OBJ)) {
		
		$Insert = $db->prepare("INSERT INTO admin_panel.UserAsset (UserID, ReferenceType, ReferenceID, TimeReport) VALUES(".$Q->CreatorID.", ".($Q->ItemType - 3).", ".$Q->ID.", ".$Q->TimeCreated.")");
		$Insert->execute();
		
	}*/
	//$cache->delete('Site_Filter_BlacklistWords');

	/*if ($i = 1508994000; $i < 1510207200; $i += 86400) {

		$TimeBegin = $i;
		$TimeEnd = $i + 86400;

		$Query = $db->prepare("SELECT SUM(PreviousBalance-NewBalance) AS TotalCoins, COUNT(UserTransactionLog.ID) AS TotalTransactions, UserGroup.ID FROM UserTransactionLog JOIN Item ON UserTransactionLog.ReferenceID = Item.ID JOIN UserGroup ON Item.CreatorID = UserGroup.ID WHERE EventID = 2 AND TimeTransaction >= ".$TimeBegin." AND TimeTransaction <= ".$TimeEnd." GROUP BY UserGroup.ID");
		$Query->execute();
		
		//echo "SELECT SUM(PreviousBalance-NewBalance) AS TotalCoins, COUNT(UserTransactionLog.ID) AS TotalTransactions, UserGroup.ID FROM UserTransactionLog JOIN Item ON UserTransactionLog.ReferenceID = Item.ID JOIN UserGroup ON Item.CreatorID = UserGroup.ID WHERE EventID = 2 AND TimeTransaction >= ".$TimeBegin." AND TimeTransaction <= ".$TimeEnd." GROUP BY UserGroup.ID<br />";

		
		while ($Q = $Query->fetch(PDO::FETCH_OBJ)) {

			$getEarning = $db->prepare("SELECT COUNT(*) FROM UserGroupDailyEarning WHERE GroupID = ".$Q->ID." AND TimeStart = ".$TimeBegin." AND TimeEnd = ".$TimeEnd."");
			$getEarning->execute();

			if ($getEarning->fetchColumn() == 0) {

				$Create = $db->prepare("INSERT INTO UserGroupDailyEarning (GroupID, Coins, TimeStart, TimeEnd, TransactionsCount, Status) VALUES(".$Q->ID.", ".$Q->TotalCoins.", ".$TimeBegin.", ".$TimeEnd.", ".$Q->TotalTransactions.", 0)");
				$Create->execute();

				echo "INSERT INTO UserGroupDailyEarning (GroupID, Coins, TimeStart, TimeEnd, TransactionsCount, Status) VALUES(".$Q->ID.", ".$Q->TotalCoins.", ".$TimeBegin.", ".$TimeEnd.", ".$Q->TotalTransactions.", 0)<br /><br /><hr><br /><br />";

			} else {

				/*$getEarning = $db->prepare("SELECT Coins FROM UserGroupDailyEarning WHERE GroupID = ".$Q->ID." AND TimeStart = ".$TimeBegin." AND TimeEnd = ".$TimeEnd."");
				$getEarning->execute();
				$EarningsInCoins = $getEarning->fetchColumn();

				$DistributeAmount = $Q->TotalCoins - $EarningsInCoins;

				if ($DistributeAmount != 0 && $DistributeAmount > 0) {

					//$Update = $db->prepare("UPDATE UserGroupDailyEarning SET Coins = ".$Q->TotalCoins." WHERE GroupID = ".$Q->ID." AND TimeStart = ".$TimeBegin." AND TimeEnd = ".$TimeEnd."");
					//$Update->execute();

					//$UpdateGroup = $db->prepare("UPDATE UserGroup SET CoinsVault = CoinsVault + ".$DistributeAmount." WHERE ID = ".$Q->ID."");
					//$UpdateGroup->execute();

					echo 'GroupID: '.$Q->ID.', Total Coins: '.$Q->TotalCoins.', Previous Total Coins: '.$EarningsInCoins.' (a difference of '.$DistributeAmount.' (to be distributed))<br />';
					echo "UPDATE UserGroupDailyEarning SET Coins = ".$Q->TotalCoins." WHERE GroupID = ".$Q->ID." AND TimeStart = ".$TimeBegin." AND TimeEnd = ".$TimeEnd."<br />";
					echo "UPDATE UserGroup SET CoinsVault = CoinsVault + ".$DistributeAmount." WHERE ID = ".$Q->ID."<br /><br /><hr><br /><br />";

				}

			}

		}
		

	}*/

	/*echo get_timeago(1506332964);
	die;

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
		$Rarity = array(0 => 80, 1 => 12, 2 => 6, 3 => 1.8, 4 => 0.2);
		$WinningRarity = determineCrateRarity($Rarity);

		$Count = $db->prepare("SELECT COUNT(*) FROM ItemCrateContent WHERE ItemID = ".$CrateID." AND ContentRarity = ".$WinningRarity."");
		$Count->execute();

		if ($Count->fetchColumn() == 0) {
			determineWinningCrateItem($CrateID);
		} else {
			$Update = $db->prepare("UPDATE UserInventory SET CrateItemID = (SELECT ID FROM ItemCrateContent WHERE ContentRarity = ".$WinningRarity." ORDER BY RAND() LIMIT 1) WHERE ID = ".$InventoryID." AND UserID = ".$myU->ID."");
			$Update->execute();
		}

	}

	//determineWinningCrateItem(20218, 129122);

	// Temp
	$CrateID = 20218;
	$InventoryID = 129122;

	$getWinningInfo = $db->prepare("SELECT Item.ID, Item.Name, Item.PreviewImage, Item.ShadowImage, ItemCrateContent.ContentValue FROM ItemCrateContent LEFT JOIN Item ON Item.ID = (CASE WHEN ItemCrateContent.ContentType = 1 THEN ItemCrateContent.ContentID ELSE 0 END) WHERE ItemCrateContent.ID = (SELECT CrateItemID FROM UserInventory WHERE ID = ".$InventoryID." AND UserID = 1)");
	$getWinningInfo->execute();
	$gWI = $getWinningInfo->fetch(PDO::FETCH_OBJ);
	$WinningItemPic = (empty($gWI->ID)) ? ''.$serverName.'/assets/images/coins-125.png' : $cdnName . $gWI->PreviewImage;
	$WinningItemDiv = (empty($gWI->ID)) ? 'crate-winner-coins' : 'crate-winner-item';
	$WinningItemName = (empty($gWI->ID)) ? number_format($gWI->ContentValue).' Coins' : $gWI->Name;

	$PrizesArray = array();
	$getPrizes = $db->prepare("SELECT ItemCrateContent.ContentRarity, Item.ShadowImage FROM ItemCrateContent LEFT JOIN Item ON Item.ID = (CASE WHEN ItemCrateContent.ContentType = 1 THEN ItemCrateContent.ContentID ELSE 0 END) WHERE ItemCrateContent.ItemID = 20218");
	$getPrizes->execute();

	while ($gP = $getPrizes->fetch(PDO::FETCH_OBJ)) {

		if (empty($gP->ShadowImage)) {
			array_push($PrizesArray, ''.$serverName.'/assets/images/coins-preview.png', ''.$serverName.'/assets/images/coins-preview.png', ''.$serverName.'/assets/images/coins-preview.png', ''.$serverName.'/assets/images/coins-preview.png', ''.$serverName.'/assets/images/coins-preview.png', ''.$serverName.'/assets/images/coins-preview.png', ''.$serverName.'/assets/images/coins-preview.png', ''.$serverName.'/assets/images/coins-preview.png', ''.$serverName.'/assets/images/coins-preview.png', ''.$serverName.'/assets/images/coins-preview.png');
		} else {
			array_push($PrizesArray, ''.$cdnName . $gP->ShadowImage.'', ''.$cdnName . $gP->ShadowImage.'', ''.$cdnName . $gP->ShadowImage.'', ''.$cdnName . $gP->ShadowImage.'', ''.$cdnName . $gP->ShadowImage.'', ''.$cdnName . $gP->ShadowImage.'', ''.$cdnName . $gP->ShadowImage.'', ''.$cdnName . $gP->ShadowImage.'', ''.$cdnName . $gP->ShadowImage.'', ''.$cdnName . $gP->ShadowImage.'');
		}

	}

	shuffle($PrizesArray);

	$WinningIndex = floor(count($PrizesArray)*0.5)+1;
	$PrizesArray[$WinningIndex] = (empty($gWI->ID)) ? ''.$serverName.'/assets/images/coins-preview.png' : $cdnName . $gWI->ShadowImage;

	echo '
	<script src="'.$serverName.'/assets/js/jquery-ui.min.js"></script>
	<div class="item-modal" style="width:705px;margin:0 auto;">
		<div class="container border-r md-padding" style="width:100%;overflow:hidden;">
			<div class="crate-contents">
			';

			foreach ($PrizesArray as $Prize) {

				echo '
				<div class="crate-item">
					<div class="crate-item-image" style="background:url('.$Prize.');background-size:cover;"></div>
				</div>
				';

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
		<div class="crate-winner-name">You won <strong>'.$WinningItemName.'</strong>!</div>
		<div class="push-15"></div>
		<div class="text-center" align="center">
			<input type="button" class="button button-blue store-button inline-block" onclick="window.location.href = \''.$serverName.'/account/character/\'" value="Edit Character">
			<input type="button" data-close class="button button-grey store-button inline-block" value="Close">
		</div>
	</div>
	<div class="push-25"></div>
	<button onclick="RunCrateSpinner()" class="button button-green" style="margin:0 auto;">Spin</button>
	<style>
		.crate-contents {
			white-space: nowrap;
			width: 100%;
			font-size: 0;
		}

		.crate-item {
			display: inline-block;
			background: #4C4E57;
			width: 75px;
			height: 75px;
			border: 1px solid #16171C;
			margin: 0 25px;
			position: relative;
		}

		.crate-item-image {
			width: 60px;
			height: 60px;
			margin-top: 7.5px;
			margin-left: 7.5px;
		}

		.crate-bottom-divider {
			width: 100%;
			text-align: center;
			border-bottom: 1px solid #676978;
			line-height: 0.1em;
			margin: 10px 0 20px;
		}

		.crate-bottom-divider span {
			padding: 0 10px;
			background: #23242B;
		}

		.crate-bottom-divider span i {
			font-size: 18px;
			line-height: inherit;
			cursor: default;
		}

		.crate-winner-item {
			width: 256px;
			height: 256px;
			border: 1px solid #676978;
			border-radius: 50%;
			margin: 0 auto;
		}

		.crate-winner-coins {
			width: 125px;
			height: 125px;
			border: 1px solid #676978;
			border-radius: 50%;
			margin: 0 auto;
		}

		.crate-winner-name {
			margin-top: 15px;
			text-align: center;
			font-size: 24px;
		}
	</style>
	<script>
		function RunCrateSpinner() {
			var $item = $(".crate-item");
			$item.animate({"left":"-='.(($WinningIndex-3)*125).'px"}, 3000, "easeOutQuad");
			setTimeout(OpenWinningDiv, 3100);
		}

		function OpenWinningDiv() {
			$("#WinningCrateItemModal").foundation("open");
		}
	</script>
	';*/

	/*$refund = $db->prepare("SELECT UserID FROM new.ItemCrateLog WHERE Text LIKE '%: 0 coins%'");
	$refund->execute();

	while ($r = $refund->fetch(PDO::FETCH_OBJ)) {

		$insert = $db->prepare("INSERT INTO UserInventory (UserID, ItemID, TimeCreated) VALUES(".$r->UserID.", 23252, ".time().")");
		$insert->execute();

	}*/

	/*function renderItem($itemid) {
		$callback = file_get_contents("http://10.132.43.124/?seriousKey=dAktdYZ2SBABYCmK&itemId=" . $itemid);
	}

	$get = $db->prepare("SELECT ID FROM Item WHERE ShadowImage IS NOT NULL AND ThumbnailImage IS NULL");
	$get->execute();

	while ($g = $get->fetch(PDO::FETCH_OBJ)) {
		renderItem($g->ID);
		echo "Re-rendered {$g->ID}\n";
	}*/

	/*$getUser = $db->prepare("SELECT Username, AvatarURL, TradeSettings, (SELECT COUNT(*) FROM Friend WHERE SenderID = ".$myU->ID." AND ReceiverID = User.ID AND Accepted = 1) AS CheckFriend FROM User WHERE Username = ?");
	$getUser->bindValue(1, $_GET['Username'], PDO::PARAM_STR);
	$getUser->execute();

	if ($getUser->rowCount() == 0) {

		echo 'We\'re sorry, this user was not found.';

	} else {

		$gU = $getUser->fetch(PDO::FETCH_OBJ);

		if ($gU->TradeSettings == 1 && $gU->CheckFriend == 0 || $gU->TradeSettings == 2) {

			echo 'We\'re sorry, this user\'s privacy settings restricts you from trading with them.';

		} else {

			echo '
			<div class="grid-x grid-margin-x">
				<div class="large-3 medium-3 cell">
					<div class="container-header md-padding">
						<strong>'.$myU->Username.'</strong>
					</div>
					<div class="container border-wh sm-padding">
						<img src="'.$cdnName . $myU->AvatarURL.'.png">
					</div>
				</div>
				<div class="large-7 medium-6 cell">
					<div class="container-header md-padding">
						<strong>Your Inventory</strong>
					</div>
					<div class="container border-wh sm-padding">

					</div>
				</div>
				<div class="large-3 medium-3 cell">
					<div class="container-header md-padding">
						<strong>Giving</strong>
					</div>
					<div class="container border-wh sm-padding">

					</div>
				</div>
			</div>
			<div class="push-15"></div>
			<div class="grid-x grid-margin-x">
				<div class="large-3 medium-3 cell">
					<div class="container-header md-padding">
						<strong>'.$gU->Username.'</strong>
					</div>
					<div class="container border-wh sm-padding">
						<img src="'.$cdnName . $gU->AvatarURL.'.png">
					</div>
				</div>
				<div class="large-7 medium-6 cell">
					<div class="container-header md-padding">
						<strong>Their Inventory</strong>
					</div>
					<div class="container border-wh sm-padding">

					</div>
				</div>
				<div class="large-3 medium-3 cell">
					<div class="container-header md-padding">
						<strong>Requesting</strong>
					</div>
					<div class="container border-wh sm-padding">

					</div>
				</div>
			</div>
			';

		}

	}*/

	/*$getEarnings = $db->prepare("SELECT * FROM UserDailyEarning WHERE TimeStart = 1506661200");
	$getEarnings->execute();

	while ($gE = $getEarnings->fetch(PDO::FETCH_OBJ)) {

		$getTransactions = $db->prepare("SELECT COUNT(*) AS Count, SUM(PreviousBalance-NewBalance) AS TotalBalance FROM UserTransactionLog WHERE EventID = 3 AND ReferenceID IN(SELECT ID FROM Item WHERE CreatorID = ".$gE->UserID.") AND TimeTransaction >= 1506661200 AND TimeTransaction <= 1506747600");
		$getTransactions->execute();
		$gT = $getTransactions->fetch(PDO::FETCH_OBJ);
		if (empty($gT->TotalBalance)) { $gT->TotalBalance = 0; }

		if ($gT->TotalBalance > 0) {

			$Count = $db->prepare("SELECT COUNT(*) FROM UserDailyEarning WHERE UserID = ".$gE->UserID." AND TimeStart = 1506747600 AND TimeEnd = 1506747600");
			$Count->execute();

			if ($Count->fetchColumn() == 0) {
				echo "INSERT INTO UserDailyEarning (UserID, Coins, TimeStart, TimeEnd, TransactionsCount) VALUES(".$gE->UserID.", 0, 1506747600, 1506747600, 0);<br />";
			}

			echo "UPDATE UserDailyEarning SET Coins = ".$gT->TotalBalance.", TransactionsCount = ".$gT->Count." WHERE UserID = ".$gE->UserID." AND TimeStart = 1506747600;<br />";

		}

	}*/

	/*$getEarnings = $db->prepare("SELECT SUM(Price) AS Price, SellerID, COUNT(*) AS Count FROM new.ItemSellerHistory WHERE TimeSale >= 1506661200 AND TimeSale <= 1506747600 GROUP BY SellerID");
	$getEarnings->execute();

	while ($gE = $getEarnings->fetch(PDO::FETCH_OBJ)) {

		$Count = $db->prepare("SELECT COUNT(*) FROM UserDailyEarning WHERE UserID = ".$gE->SellerID." AND TimeStart = 1506747600 AND TimeEnd = 1506834000");
		$Count->execute();

		if ($Count->fetchColumn() == 0) {
			echo "INSERT INTO UserDailyEarning (UserID, Coins, TimeStart, TimeEnd, TransactionsCount) VALUES(".$gE->SellerID.", 0, 1506747600, 1506834000, 0);<br />";
		}

		echo "UPDATE UserDailyEarning SET Coins = ".$gE->Price.", TransactionsCount = TransactionsCount + ".$gE->Count." WHERE UserID = ".$gE->SellerID." AND TimeStart = 1506747600;<br />";

	}*/


	/*function removeIt($string) {
		$string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
		$matches = array();
		$matchFound = preg_match_all("/\b(fuck|shit)\b/i", $string, $matches);
		if ($matchFound) {
			$words = array_unique($matches[0]);
			foreach ($words as $word) {
				echo $word.'<br />';
			}
		}
	}

	echo removeIt("fucki t");*/

	/*$getEarnings = $db->prepare("SELECT SUM(PreviousBalance-NewBalance) AS Coins, Item.CreatorID FROM UserTransactionLog JOIN Item ON Item.ID = UserTransactionLog.ReferenceID WHERE UserTransactionLog.EventID = 1 AND UserTransactionLog.TimeTransaction >= 1506747600 AND UserTransactionLog.TimeTransaction <= 1506834000 AND Item.CreatorType = 0 GROUP BY UserTransactionLog.ReferenceID HAVING Coins > 0");
	$getEarnings->execute();

	while ($gE = $getEarnings->fetch(PDO::FETCH_OBJ)) {

		$GetExtra = $db->prepare("SELECT SUM(Price) FROM ItemSellerHistory WHERE SellerID = ".$gE->CreatorID." AND TimeSale >= 1506747600 AND TimeSale <= 1506834000");
		$GetExtra->execute();

		$Total = $gE->Coins + $GetExtra->fetchColumn();

		$YesterdayEarnings = $db->prepare("SELECT Coins FROM UserDailyEarning WHERE UserID = ".$gE->CreatorID." AND TimeStart = 1506747600 LIMIT 1");
		$YesterdayEarnings->execute();

		if ($YesterdayEarnings->rowCount() == 0) {
			$OkCoins = 0;
		} else {
			$OkCoins = $YesterdayEarnings->fetchColumn();
		}

		$FinalTotal = $Total - $OkCoins;

		if ($FinalTotal > 0) {

			$Count = $db->prepare("SELECT COUNT(*) FROM UserDailyEarning WHERE UserID = ".$gE->CreatorID." AND TimeStart = 1506834000 AND TimeEnd = 1506920400");
			$Count->execute();

			if ($Count->fetchColumn() == 0) {
				echo "INSERT INTO UserDailyEarning (UserID, Coins, TimeStart, TimeEnd, TransactionsCount) VALUES(".$gE->CreatorID.", 0, 1506834000, 1506920400, 0);<br />";
			}

			echo "UPDATE UserDailyEarning SET Coins = Coins + ".$FinalTotal." WHERE UserID = ".$gE->CreatorID." AND TimeStart = 1506834000;<br />";

		}

		/*$Count = $db->prepare("SELECT COUNT(*) FROM UserDailyEarning WHERE UserID = ".$gE->SellerID." AND TimeStart = 1506747600 AND TimeEnd = 1506834000");
		$Count->execute();

		if ($Count->fetchColumn() == 0) {
			echo "INSERT INTO UserDailyEarning (UserID, Coins, TimeStart, TimeEnd, TransactionsCount) VALUES(".$gE->SellerID.", 0, 1506747600, 1506834000, 0);<br />";
		}

		echo "UPDATE UserDailyEarning SET Coins = Coins + ".$gE->Price.", TransactionsCount = TransactionsCount + ".$gE->Count." WHERE UserID = ".$gE->SellerID." AND TimeStart = 1506747600;<br />";*/

	//}

	/*$Query = $db->prepare("SELECT ID, Name FROM UserGroup WHERE SEOName IS NULL");
	$Query->execute();

	while ($Q = $Query->fetch(PDO::FETCH_OBJ)) {

		$SEOName = $Q->Name;
		$SEOName = str_replace('/', '--', $SEOName);
		$SEOName = str_replace(' ', '-', $SEOName);

		$Update = $db->prepare("UPDATE UserGroup SET SEOName = ? WHERE ID = ".$Q->ID."");
		$Update->bindValue(1, $SEOName, PDO::PARAM_STR);
		$Update->execute();

	}*/

	/*require_once('/var/www/html/root/private/composer/vendor/autoload.php');

	$filter = new \JCrowe\BadWordFilter\BadWordFilter();

	if ($filter->isDirty(array('Your momma so fat, she shit on the earth and made dirt'))) {
		echo 'Hello';
	} else {
		echo 'Goodbye';
	}

	$clean = $filter->clean('I would like to associate the fact that even though in the basement, your semen did not block the word with a skyscraper. So fuck off you ass ');
	var_dump($clean);*/

	/*$getReplies = $db->prepare("SELECT ID, ThreadID FROM ForumReply WHERE MATCH (Post) AGAINST('JCR')");
	$getReplies->execute();

	while ($gR = $getReplies->fetch(PDO::FETCH_OBJ)) {

		$movePost = $db->prepare("INSERT INTO archives.ForumReply SELECT * FROM ForumReply WHERE ID = ? AND ThreadID = ".$gR->ThreadID."");
		$movePost->bindValue(1, $gR->ID, PDO::PARAM_INT);
		$movePost->execute();

		$ReplyID = $db->lastInsertId();

		if ($movePost->rowCount() > 0) {

			$delete = $db->prepare("DELETE FROM ForumReply WHERE ID = ?");
			$delete->bindValue(1, $gR->ID, PDO::PARAM_INT);
			$delete->execute();

			$log = $db->prepare("INSERT INTO ForumAdminLog (ForumType, ForumID, AdminID, UserID, TimeAction, ActionIP) VALUES(1, ?, ".$myU->ID.", (SELECT UserID FROM archives.ForumReply WHERE ID = ".$ReplyID."), ".time().", '".$_SERVER['REMOTE_ADDR']."')");
			$log->bindValue(1, $gR->ID, PDO::PARAM_INT);
			$log->execute();

		}

	}*/

	/*$getItemsAndDelete = $db->prepare("SELECT * FROM new.UserTransactionLog WHERE EventID = 1 AND ReferenceID IN(SELECT ID FROM Item WHERE CreatorID = 1 AND CreatorType = 0);");
	$getItemsAndDelete->execute();

	while ($gI = $getItemsAndDelete->fetch(PDO::FETCH_OBJ)) {

		// Refund User
		$GetTransactionAmount = $gI->PreviousBalance - $gI->NewBalance;

		$Update = $db->prepare("UPDATE User SET CurrencyCoins = CurrencyCoins + ".$GetTransactionAmount." WHERE ID = ".$gI->UserID."");
		$Update->execute();

		$Delete = $db->prepare("DELETE FROM UserInventory WHERE UserID = ".$gI->UserID." AND ItemID = ".$gI->ReferenceID."");
		$Delete->execute();

	}*/

/*	echo '
<html prefix="og: http://ogp.me/ns#">
<head>
<meta charset="utf-8" />
<title>Brick Create</title>
<meta property="og:title" content="Isaac\'s Profile" />
<meta property="og:description" content="View the full profile of Isaac, one of many builders playing on Brick Create." />
<meta property="og:type" content="profile" />
<meta property="og:url" content="https://test.brickcreate.com/fast1.php" />
<meta property="og:image" content="https://cdn.brickcreate.com/f3471216-7404-4c08-81db-13836e176bcd.png" />
<meta property="og:updated_time" content="'.time().'" />
</head>
<body>
<img src="https://test.brickcreate.com/TXyFRF7.png">
</body>
</html>
	';*/
