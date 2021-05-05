<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");

	if (!isset($_GET['PrimarySort'])) {
		
		$PrimarySort = 'recent';
		
	}
	
	else if ($_GET['PrimarySort'] == 'recent' || $_GET['PrimarySort'] == 'popular') {
		
		$PrimarySort = $_GET['PrimarySort'];
		
	}
	
	else {
		
		$PrimarySort = 'recent';
		
	}
	
	if (!isset($_GET['search'])) {
		
		$_GET['search'] = '';
		
	}
	
	else if (isset($_GET['search'])) {
		
		$_GET['search'] = htmlentities($_GET['search']);
		
	}
	
	if (!isset($_GET['ItemType'])) {
		
		$ItemType = 'all';
		
	}
	
	else if ($_GET['ItemType'] == 'all' || $_GET['ItemType'] == 'hat' || $_GET['ItemType'] == 'face' || $_GET['ItemType'] == 'accessory' || $_GET['ItemType'] == 'tshirt' || $_GET['ItemType'] == 'shirt' || $_GET['ItemType'] == 'pants') {
		
		$ItemType = $_GET['ItemType'];
		
	}
	
	else {
		
		$ItemType = 'all';
		
	}
	
	if (!isset($_GET['MinimumPriceRange'])) {
		
		$MinimumPriceRange = 0;
		
	}
	
	else if (is_numeric($_GET['MinimumPriceRange'])) {
		
		$MinimumPriceRange = $_GET['MinimumPriceRange'];
		
	}
	
	else {
		
		$MinimumPriceRange = 0;
		
	}
	
	if (!isset($_GET['MaximumPriceRange'])) {
		
		$MaximumPriceRange = 0;
		
	}
	
	else if (is_numeric($_GET['MaximumPriceRange'])) {
		
		$MaximumPriceRange = $_GET['MaximumPriceRange'];
		
	}
	
	else {
		
		$MaximumPriceRange = 0;
		
	}
	
	if (!isset($_GET['Currency'])) {
		
		$Currency = 'null';
		
	}
	
	else if ($_GET['Currency'] == 'cash' || $_GET['Currency'] == 'coins') {
		
		$Currency = $_GET['Currency'];
		
	}
	
	else {
	
		$Currency = 'null';
	
	}
	
	if (!isset($_GET['SortPrice'])) {
		
		$SortPrice = 'null';
		
	}
	
	else if ($_GET['SortPrice'] == 'hightolow' || $_GET['SortPrice'] == 'lowtohigh') {
		
		$SortPrice = $_GET['SortPrice'];
		
	}
	
	else {
		
		$SortPrice = 'null';
		
	}
	
	if ($PrimarySort == 'recent') {
		
		$addQuery = '';
		$addRangeQuery = '';
		$addSearchQuery = '';
		$addSortQuery = 'ORDER BY `UpdatedTime` DESC';
		
		if ($ItemType == 'all') {
			$addItemType = '`ItemType` IN(\'hat\',\'accessory\',\'face\') AND';
		}
		else {
			$addItemType = '`ItemType` = \''.$ItemType.'\' AND';
		}
		
		if (!empty($_GET['search'])) {
			
			$addSearchQuery = ' AND `Name` LIKE ?';
			
		}
		
		if ($MinimumPriceRange != 'null' && $MaximumPriceRange != 'null' && $MinimumPriceRange < $MaximumPriceRange) {
			
			if ($Currency == 'null' || $Currency == 'coins') {
				
				$addRangeQuery = ' AND `Price` >= '.$MinimumPriceRange.' AND `Price` <= '.$MaximumPriceRange.'';
				
			}
			
			else if ($Currency == 'cash') {
				
				$addRangeQuery = ' AND `PriceCash` >= '.$MinimumPriceRange.' AND `PriceCash` <= '.$MaximumPriceRange.'';
				
			}
			
		}
		
		if ($SortPrice == 'lowtohigh') {
			
			if ($Currency == 'null' || $Currency == 'coins') {
			
				$addRangeQuery = ' AND OnSale = 1';
				$addSortQuery = 'ORDER BY `Price` ASC';
			
			}
			
			else if ($Currency == 'cash') {
				
				$addRangeQuery = ' AND OnSale = 1';
				$addSortQuery = 'ORDER BY `PriceCash` ASC';
				
			}
			
		}
		
		else if ($SortPrice == 'hightolow' || $SortPrice == 'null') {
			
			if ($Currency == 'coins') {
			
				$addRangeQuery = ' AND OnSale = 1';
				$addSortQuery = 'ORDER BY `Price` DESC';
			
			}
			
			else if ($Currency == 'cash') {
				
				$addRangeQuery = ' AND OnSale = 1';
				$addSortQuery = 'ORDER BY `PriceCash` DESC';
				
			}
			
		}
		
		if ($ItemType == 'all') {
		
			if (empty($addSearchQuery)) {
				
				$getNumItems = $db->prepare("SELECT COUNT(*) FROM Items WHERE ".$addItemType." Items.ViewFile != 'pending.png' AND Items.ViewFile != 'rejected.png' AND Items.Name != '[ Inappropriate Content ]'".$addSearchQuery."".$addRangeQuery." ".$addSortQuery."");
				$getNumItems->execute();
				$getNumItems = $getNumItems->fetchColumn();
				// Limit per page
				$limit = 10;
					
				// How many pages will there be
				$pages = ceil($getNumItems / $limit);
					
				// Page we are currently on
				$page = min($pages, filter_input(INPUT_GET, 'Page', FILTER_VALIDATE_INT, array(
					'options' => array(
						'default'   => 1,
						'min_range' => 1,
					),
				)));
					
				$offset = ($page - 1)  * $limit;
				
				$getItems = $db->prepare("SELECT Items.ID, Items.Name, Items.Price AS PriceCoins, Items.PriceCash, Items.CreatorID, Items.ItemType, Items.ViewFile, Items.OnSale, Items.IsLimited, Items.FullStock, Items.RemainingStock, Users.Username AS CreatorName FROM Items JOIN Users ON Users.ID = Items.CreatorID WHERE ".$addItemType." Items.ViewFile != 'pending.png' AND Items.ViewFile != 'rejected.png' AND Items.Name != '[ Inappropriate Content ]'".$addSearchQuery."".$addRangeQuery." ".$addSortQuery." LIMIT ? OFFSET ?");
				$getItems->bindValue(1, $limit, PDO::PARAM_INT);
				$getItems->bindValue(2, $offset, PDO::PARAM_INT);
				$getItems->execute();
				
			}
			
			else if (!empty($addSearchQuery)) {
				
				$getNumItems = $db->prepare("SELECT COUNT(*) FROM Items WHERE ".$addItemType." Items.ViewFile != 'pending.png' AND Items.ViewFile != 'rejected.png' AND Items.Name != '[ Inappropriate Content ]'".$addSearchQuery."".$addRangeQuery." ".$addSortQuery."");
				$getNumItems->execute();
				$getNumItems = $getNumItems->fetchColumn();
				
				// Limit per page
				$limit = 10;
					
				// How many pages will there be
				$pages = ceil($getNumItems / $limit);
					
				// Page we are currently on
				$page = min($pages, filter_input(INPUT_GET, 'Page', FILTER_VALIDATE_INT, array(
					'options' => array(
						'default'   => 1,
						'min_range' => 1,
					),
				)));
					
				$offset = ($page - 1)  * $limit;
				
				$getItems = $db->prepare("SELECT Items.ID, Items.Name, Items.Price AS PriceCoins, Items.PriceCash, Items.CreatorID, Items.ItemType, Items.ViewFile, Items.OnSale, Items.IsLimited, Items.FullStock, Items.RemainingStock, Users.Username AS CreatorName FROM Items JOIN Users ON Users.ID = Items.CreatorID WHERE ".$addItemType." Items.ViewFile != 'pending.png' AND Items.ViewFile != 'rejected.png' AND Items.Name != '[ Inappropriate Content ]'".$addSearchQuery."".$addRangeQuery." ".$addSortQuery." LIMIT ? OFFSET ?");
				$getItems->bindValue(1, '%'.$_GET['search'].'%', PDO::PARAM_STR);
				$getItems->bindValue(2, $limit, PDO::PARAM_INT);
				$getItems->bindValue(3, $offset, PDO::PARAM_INT);
				$getItems->execute();
			
			}
		
		}
		
		else {
			
			$getNumItems = $db->prepare("SELECT COUNT(*) FROM Items WHERE ".$addItemType." Items.ViewFile != 'pending.png' AND Items.ViewFile != 'rejected.png' AND Items.Name != '[ Inappropriate Content ]'".$addSearchQuery."".$addRangeQuery." ".$addSortQuery."");
			$getNumItems->execute();
			$getNumItems = $getNumItems->fetchColumn();
			
			// Limit per page
			$limit = 10;
				
			// How many pages will there be
			$pages = ceil($getNumItems / $limit);
				
			// Page we are currently on
			$page = min($pages, filter_input(INPUT_GET, 'Page', FILTER_VALIDATE_INT, array(
				'options' => array(
					'default'   => 1,
					'min_range' => 1,
				),
			)));
				
			$offset = ($page - 1)  * $limit;
			
			$getItems = $db->prepare("SELECT Items.ID, Items.Name, Items.Price AS PriceCoins, Items.PriceCash, Items.CreatorID, Items.ItemType, Items.ViewFile, Items.OnSale, Items.IsLimited, Items.FullStock, Items.RemainingStock, Users.Username AS CreatorName FROM Items JOIN Users ON Users.ID = Items.CreatorID WHERE ".$addItemType." Items.ViewFile != 'pending.png' AND Items.ViewFile != 'rejected.png' AND Items.Name != '[ Inappropriate Content ]'".$addSearchQuery."".$addRangeQuery." ".$addSortQuery." LIMIT ? OFFSET ?");
			
			if (!empty($addSearchQuery)) {
				$getItems->bindValue(1, '%'.$_GET['search'].'%', PDO::PARAM_STR);
			}
			
			$getItems->execute();
			
		}
		
	}
	
	else if ($PrimarySort == 'popular') {
		
		$addQuery = '';
		$addRangeQuery = '';
		$addSortQuery = '';
		$addItemType = '';
		$addSearchQuery = '';

		if ($ItemType != 'all') {
			$addItemType = '`ItemType` = \''.$ItemType.'\' AND';
		}
		
		if (!empty($_GET['search'])) {
			
			$addSearchQuery = ' AND `Name` LIKE ?';
			
		}
		
		if ($MinimumPriceRange != 'null' && $MaximumPriceRange != 'null' && $MinimumPriceRange < $MaximumPriceRange) {
			
			if ($Currency == 'null' || $Currency == 'coins') {
				
				$addRangeQuery = ' AND `Price` >= '.$MinimumPriceRange.' AND `Price` <= '.$MaximumPriceRange.'';
				
			}
			
			else if ($Currency == 'cash') {
				
				$addRangeQuery = ' AND `PriceCash` >= '.$MinimumPriceRange.' AND `PriceCash` <= '.$MaximumPriceRange.'';
				
			}
			
		}
		
		if ($SortPrice == 'lowtohigh') {
			
			if ($Currency == 'null' || $Currency == 'coins') {
			
				$addSortQuery = 'ORDER BY `Price` ASC';
			
			}
			
			else if ($Currency == 'cash') {
				
				$addSortQuery = 'ORDER BY `PriceCash` ASC';
				
			}
			
		}
		
		else if ($SortPrice == 'hightolow') {
			
			if ($Currency == 'null' || $Currency == 'coins') {
			
				$addSortQuery = 'ORDER BY `Price` DESC';
			
			}
			
			else if ($Currency == 'cash') {
				
				$addSortQuery = 'ORDER BY `PriceCash` DESC';
				
			}
			
		}
		
		$yesterday = time() - 86400;
		
		if ($ItemType == 'all') {
			
			if (empty($addSearchQuery)) {
				
				$getItems = $db->prepare("SELECT Items.ID, Items.Name, Items.Price AS PriceCoins, Items.PriceCash, Items.CreatorID, Items.ItemType, Items.ViewFile, Items.OnSale, Items.IsLimited, Items.FullStock, Items.RemainingStock, Users.Username AS CreatorName FROM Items JOIN Users ON Users.ID = Items.CreatorID WHERE Items.ID IN((SELECT `ItemID` FROM `Inventory` WHERE `TimePurchased` >= ".$yesterday.")) AND ".$addItemType." Items.ViewFile != 'pending.png' AND Items.ViewFile != 'rejected.png' AND Items.Name != '[ Inappropriate Content ]'".$addSearchQuery."".$addRangeQuery." ".$addSortQuery." LIMIT ? OFFSET ?");
				$getItems->execute();
				
			}
			
			else if (!empty($addSearchQuery)) {
			
				$getItems = $db->prepare("SELECT Items.ID, Items.Name, Items.Price AS PriceCoins, Items.PriceCash, Items.CreatorID, Items.ItemType, Items.ViewFile, Items.OnSale, Items.IsLimited, Items.FullStock, Items.RemainingStock, Users.Username AS CreatorName FROM Items JOIN Users ON Users.ID = Items.CreatorID WHERE Items.ID IN((SELECT `ItemID` FROM `Inventory` WHERE `TimePurchased` >= ".$yesterday.")) AND ".$addItemType." Items.ViewFile != 'pending.png' AND Items.ViewFile != 'rejected.png' AND Items.Name != '[ Inappropriate Content ]'".$addSearchQuery."".$addRangeQuery." ".$addSortQuery." LIMIT ? OFFSET ?");
				$getItems->bindValue(1, '%'.$_GET['search'].'%', PDO::PARAM_STR);
				$getItems->execute();
			
			}
		
		}
		
		else {
			
			$getItems = $db->prepare("SELECT Items.ID, Items.Name, Items.Price AS PriceCoins, Items.PriceCash, Items.CreatorID, Items.ItemType, Items.ViewFile, Items.OnSale, Items.IsLimited, Items.FullStock, Items.RemainingStock, Users.Username AS CreatorName FROM Items JOIN Users ON Users.ID = Items.CreatorID WHERE Items.ID IN((SELECT `ItemID` FROM `Inventory` WHERE `TimePurchased` >= ".$yesterday.")) AND ".$addItemType." Items.ViewFile != 'pending.png' AND Items.ViewFile != 'rejected.png' AND Items.Name != '[ Inappropriate Content ]'".$addSearchQuery."".$addRangeQuery." ".$addSortQuery."");
			
			if (!empty($addSearchQuery)) {
			
				$getItems->bindValue(1, '%'.$_GET['search'].'%', PDO::PARAM_STR);
			
			}
			
			$getItems->execute();
			
		}
	
	}
	
	$rows = array();
	
	while ($r = $getItems->fetcH(PDO::FETCH_OBJ)) {
		
		$rows[] = $r;
		
	} 
	
	echo json_encode($rows);