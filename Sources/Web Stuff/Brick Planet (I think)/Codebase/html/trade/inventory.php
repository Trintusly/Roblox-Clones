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
	
	$Type = ($_GET['Type'] != 'My' && $_GET['Type'] != 'Their') ? 'My' : $_GET['Type'];
	$Disinclude = (!empty($_GET['Disinclude'])) ? implode(',', array_intersect_key(explode(',', $_GET['Disinclude']), array_flip(array_filter(array_keys(explode(',', $_GET['Disinclude'])), 'is_numeric')))) : null;
	
	if (!empty($Disinclude) && $Disinclude != '') {
		$Query = 'SELECT Item.ID FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE ((Item.IsCollectible = 1) OR (Item.ItemType = 7)) AND Item.TradeLock = 0 AND Item.PublicView = 1 AND UserInventory.ID NOT IN('.$Disinclude.') AND UserInventory.UserID = (SELECT ID FROM User WHERE Username = ?) AND UserInventory.CanTrade = 1 GROUP BY Item.ID';
	} else {
		$Query = 'SELECT Item.ID FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE ((Item.IsCollectible = 1) OR (Item.ItemType = 7)) AND Item.TradeLock = 0 AND Item.PublicView = 1 AND UserInventory.UserID = (SELECT ID FROM User WHERE Username = ?) AND UserInventory.CanTrade = 1 GROUP BY Item.ID';
	}
	
	$Count = $db->prepare($Query);
	$Count->bindValue(1, $_GET['Username'], PDO::PARAM_STR);
	$Count->execute();
	$Count = $Count->rowCount();
	
	if ($Count > 0) {
	
		echo '<div class="grid-x grid-margin-x">';
				
		$limit = 8;
			
		$pages = ceil($Count / $limit);
			
		$page = min($pages, filter_input(INPUT_GET, 'Page', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
			
		$offset = ($page - 1)  * $limit;
		if ($offset < 0) { $offset = 0; }
		
		if (!empty($Disinclude)) { 
			$Query = 'SELECT UserInventory.ID AS InventoryID, Item.ID, Item.ItemType, Item.Name, Item.ThumbnailImage, COUNT(Item.ID) AS CopiesOwned FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE ((Item.IsCollectible = 1) OR (Item.ItemType = 7)) AND Item.TradeLock = 0 AND Item.PublicView = 1 AND UserInventory.ID NOT IN('.$Disinclude.') AND UserInventory.UserID = (SELECT ID FROM User WHERE Username = ?) AND UserInventory.CanTrade = 1 GROUP BY Item.ID ORDER BY Item.TimeCreated DESC LIMIT ? OFFSET ?';
		} else {
			$Query = 'SELECT UserInventory.ID AS InventoryID, Item.ID, Item.ItemType, Item.Name, Item.ThumbnailImage, COUNT(Item.ID) AS CopiesOwned FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE ((Item.IsCollectible = 1) OR (Item.ItemType = 7)) AND Item.TradeLock = 0 AND Item.PublicView = 1 AND UserInventory.UserID = (SELECT ID FROM User WHERE Username = ?) AND UserInventory.CanTrade = 1 GROUP BY Item.ID ORDER BY Item.TimeCreated DESC LIMIT ? OFFSET ?';
		}
		
		$getItems = $db->prepare($Query);
		$getItems->bindValue(1, $_GET['Username'], PDO::PARAM_STR);
		$getItems->bindValue(2, $limit, PDO::PARAM_INT);
		$getItems->bindValue(3, $offset, PDO::PARAM_INT);
		$getItems->execute();
		
		$i = 0;
		
		while ($gI = $getItems->fetch(PDO::FETCH_OBJ)) {
			
			$i++;
			
			echo '
			<div class="large-3 medium-3 cell trade-card" onclick="add'.$Type.'Item('.$gI->InventoryID.', '.$gI->ID.')" id="'.$Type.'Element'.$gI->ID.'" title="'.$gI->Name.' (click to add)">
				<div class="store-item-card">
					<div class="card-image relative">
						<img src="'.$cdnName . $gI->ThumbnailImage.'">
						<span id="number_copies" class="number-copies" title="'.number_format($gI->CopiesOwned).' Copies">'.number_format($gI->CopiesOwned).'</span>
					</div>
				</div>
			</div>
			';
			
		}
		
		echo '</div>';
		
		if ($Count > 0 && $pages > 1) {
			
			echo '
			<div class="push-15"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li onclick="load'.$Type.'Inventory('.($page-1).')" class="pagination-previous'; if ($page == 1) { echo ' disabled'; } echo '">Previous <span class="show-for-sr">page</span></i></li>
				';

				for ($i = max(1, $page - 10); $i <= min($page + 10, $pages); $i++) {
					
					if ($i <= $pages) {
					
						echo '<li onclick="load'.$Type.'Inventory('.$i.')"'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'">'.$i.'</li>';

					}
					
				}
				
				if ($page < $pages) {

					echo '
					<li onclick="load'.$Type.'Inventory('.($page+1).')" class="pagination-next'; if ($page == $pages) { echo ' disabled'; } echo '" aria-label="Next page">Next <span class="show-for-sr">page</span></li>
					';
				
				}
				
				echo '
			</ul>
			<div class="push-5"></div>
			';
			
		} else {
			
			echo '<div class="push-25"></div>';
			
		}
		
		echo '<input type="hidden" id="'.$Type.'Pages" value="'.$pages.'">';
	
	} else {
		
		echo '<input type="hidden" id="'.$Type.'Pages" value="1">';
		
	}