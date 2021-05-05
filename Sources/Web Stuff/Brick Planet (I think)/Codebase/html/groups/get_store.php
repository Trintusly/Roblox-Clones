<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	$GroupID = (int)$_GET['id'];
	
	$countStoreItems = $db->prepare("SELECT StoreCount FROM UserGroup WHERE UserGroup.ID = ? AND UserGroup.IsDisabled = 0");
	$countStoreItems->bindValue(1, $GroupID, PDO::PARAM_INT);
	$countStoreItems->execute();
	$countStoreItem = $countStoreItems->fetch(PDO::FETCH_OBJ);
	
	if ($countStoreItems->rowCount() == 0 || $countStoreItem->StoreCount == 0) {
		
		echo '
		<div class="grid-x grid-margin-x">
			<div class="auto cell">
				No group store items found.
			</div>
		</div>
		';
		
	} else {
	
		$limit = 8;
		
		$pages = ceil($countStoreItem->StoreCount / $limit);
			
		$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
			
		$offset = ($page - 1)  * $limit;
		if ($offset < 0) { $offset = 0; }
	
		$getGroupStoreItems = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.PreviewImage, Item.Cost, Item.SaleActive FROM Item WHERE Item.CreatorID = ? AND Item.CreatorType = 1 ORDER BY Item.TimeUpdated DESC LIMIT ? OFFSET ?");
		$getGroupStoreItems->bindValue(1, $GroupID, PDO::PARAM_INT);
		$getGroupStoreItems->bindValue(2, $limit, PDO::PARAM_INT);
		$getGroupStoreItems->bindValue(3, $offset, PDO::PARAM_INT);
		$getGroupStoreItems->execute();
		
		echo '<div class="push-15"></div><div class="grid-x grid-margin-x view-group-store">';
		
		while ($gS = $getGroupStoreItems->fetch(PDO::FETCH_OBJ)) {
			
			switch ($gS->ItemType) {
				case 5:
					$ItemType = 'SHIRT';
					break;
				case 6:
					$ItemType = 'PANTS';
					break;
			}
			
			echo '
			<div class="large-3 cell">
				<a href="'.$serverName.'/store/view/'.$gS->ID.'/">
					<div class="relative">
						<img src="'.$cdnName . $gS->PreviewImage.'">
						<div class="view-group-store-indicator">'.$ItemType.'</div>
					</div>
				</a>
				<div class="view-group-store-name"><a href="'.$serverName.'/store/view/'.$gS->ID.'/">'.$gS->Name.'</a></div>
				';
				
				if ($gS->SaleActive == 1) {
					
					echo '
					<div class="text-center">
						<div class="card-item-price" title="'.number_format($gS->Cost).' Bits">
							<span><img src="'.$serverName.'/assets/images/bits-sm.png" style="width:20px;display:inline;"></span>
							<span>'.number_format($gS->Cost).'</span>
						</div>
					</div>
					';
					
				}
				
				echo '
			</div>
			';
			
		}
		
		echo '</div>';
		
		if ($pages > 1) {
		
			echo '
			<div class="push-25"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="#" onclick="getStoreItems('.($page-1).')">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
				';

				for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
					
					if ($i <= $pages) {
					
						echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="#" onclick="getStoreItems('.($i).')">'.$i.'</a></li>';

					}
					
				}

				echo '
				<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="#" onclick="getStoreItems('.($page+1).')">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
			</ul>
			';
		
		}
	
	}