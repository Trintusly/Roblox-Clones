<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	$allowedSorts = array(1 => 'hats', 2 => 'faces', 3 => 'accessories', 5 => 'shirts', 6 => 'pants', 7 => 'recent');
	
	if (empty($_GET['sort']) || array_search($_GET['sort'], $allowedSorts) == FALSE) {
		echo 'An unexpected error has occurred. Try refreshing the page.';
		die;
	}
	
	$sort = $_GET['sort'];
	$element = array_search($sort, $allowedSorts);
	
	if ($element == 7) {
		$element = '1,2,3,7';
	}
	
	if (!empty($_GET['query'])) {
		$countItems = $db->prepare("SELECT COUNT(Item.ID) FROM Item WHERE MATCH(Item.Name) AGAINST(?) AND Item.ItemType IN(".$element.") AND Item.PublicView = 1");
		$countItems->bindValue(1, $_GET['query'], PDO::PARAM_STR);
	}
	
	else {
		$countItems = $db->prepare("SELECT COUNT(Item.ID) FROM Item WHERE Item.ItemType IN(".$element.") AND Item.PublicView = 1");
	}
	
	$countItems->execute();
	$NumItems = $countItems->fetchColumn();
	
	if ($NumItems == 0) {
		
		echo '
		<div class="container border-wh md-padding">
		No results found. Try refining your search.
		</div>
		';
		
	}
	
	else {
	
		$limit = 15;
		$pages = ceil($NumItems / $limit);
		$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
		$offset = ($page - 1)  * $limit;
		
		if (!empty($_GET['query'])) {
			$getItems = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.TimeUpdated, Item.Cost, Item.CostCredits, Item.SaleActive, Item.PreviewImage, User.Username FROM Item JOIN User ON Item.CreatorID = User.ID WHERE MATCH(Item.Name) AGAINST(?) AND Item.ItemType IN(".$element.") AND Item.PreviewImage NOT IN('pending.png', 'rejected.png') AND Item.PublicView = 1 ORDER BY Item.TimeUpdated DESC LIMIT ? OFFSET ?");
			$getItems->bindValue(1, $_GET['query'], PDO::PARAM_STR);
			$getItems->bindValue(2, $limit, PDO::PARAM_INT);
			$getItems->bindValue(3, $offset, PDO::PARAM_INT);
		}
		
		else {
			$getItems = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.TimeUpdated, Item.Cost, Item.CostCredits, Item.SaleActive, Item.PreviewImage, User.Username FROM Item JOIN User ON Item.CreatorID = User.ID WHERE Item.ItemType IN(".$element.") AND Item.PreviewImage NOT IN('pending.png', 'rejected.png') AND Item.PublicView = 1 ORDER BY Item.TimeUpdated DESC LIMIT ? OFFSET ?");
			$getItems->bindValue(1, $limit, PDO::PARAM_INT);
			$getItems->bindValue(2, $offset, PDO::PARAM_INT);
		}
		
		$getItems->execute();
		
		echo '<div class="container border-wh"><div class="grid-x grid-margin-x">';
		
		while ($gI = $getItems->fetch(PDO::FETCH_OBJ)) {
			
			echo '
			<div class="large-custom-2-4 medium-4 small-6 cell">
				<div class="border-r store-item-card">
					<div class="card-image" style="position:relative;">
						';
						
						if ($gI->Username == "BrickPlanet") {
							echo '
							<div class="official-item-parent">
								<div class="official-item-image" title="Official item sold by BrickPlanet"></div>
							</div>
							';
						}
						
						echo '
						<a href="'.$serverName.'/store/view/'.$gI->ID.'/"><img src="'.$cdnName . $gI->PreviewImage.'"></a>	
					</div>
					<div class="card-divider"></div>
					<div class="card-body">
						<div class="grid-x grid-margin-x">
							<div class="auto cell">
								<div class="card-item-name"><a href="'.$serverName.'/store/view/'.$gI->ID.'/" title="'.htmlentities(strip_tags($gI->Name)).'">'.LimitTextByCharacters($gI->Name, 22).'</a></div>
							</div>
						</div>
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell text-left">
								<div class="card-item-creator">
									<a href="'.$serverName.'/users/'.$gI->Username.'/">'.$gI->Username.'</a>
								</div>
							</div>
							<div class="shrink cell text-right">
								';
								if ($gI->SaleActive == 1 && $gI->Cost > 0 && $gI->ItemType != 7) {
									echo '
									<div class="card-item-price" title="'.number_format($gI->Cost).' Bits"><span><img src="'.$serverName.'/assets/images/bits-sm.png"></span><span>'.number_format($gI->Cost).'</span></div>
									';
								} else if ($gI->SaleActive == 1 && $gI->Cost < 1 && $gI->ItemType != 7) {
									echo '
									<div class="card-item-price" title="Free"><font class="coins-text">Free</font></div>
									';
								} else if ($gI->SaleActive == 1 && $gI->ItemType == 7) {
									echo '
									<div class="card-item-price" title="'.number_format($gI->CostCredits).' Credits"><span><img src="'.$serverName.'/assets/images/credits-sm.png"></span><span>'.number_format($gI->CostCredits).'</span></div>
									';
								}
								echo '
							</div>
						</div>
					</div>
				</div>
			</div>
			';
			
		}
		
		echo '</div><div class="push-25"></div></div>';
		
		if ($pages > 1) {
		
			echo '
			<div class="push-25"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li onclick="switchCategory(\''.$sort.'\', '.($page-1).')" class="pagination-previous'; if ($page == 1) { echo ' disabled'; } echo '">Previous <span class="show-for-sr">page</span></i></li>
				';

				for ($i = max(1, $page - 10); $i <= min($page + 10, $pages); $i++) {
					
					if ($i <= $pages) {
					
						echo '<li onclick="switchCategory(\''.$sort.'\', '.$i.')"'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'">'.$i.'</li>';

					}
					
				}
				
				if ($page < $pages) {

					echo '
					<li onclick="switchCategory(\''.$sort.'\', '.($page+1).')" class="pagination-next'; if ($page == $pages) { echo ' disabled'; } echo '" aria-label="Next page">Next <span class="show-for-sr">page</span></li>
					';
				
				}
				
				echo '
			</ul>
			';
		
		}
	
	}