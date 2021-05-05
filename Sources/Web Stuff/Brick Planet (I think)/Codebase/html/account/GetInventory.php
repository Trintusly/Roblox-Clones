<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	requireLogin();
	
	$ItemsArray = array();
	
	if (!isset($_GET['type'])) {
		
		die();
		
	}
	
	else if ($_GET['type'] == 'hat') {
		
		$type = 1;
		
	}
	
	else if ($_GET['type'] == 'faces') {
		
		$type = 2;
		
	}
	
	else if ($_GET['type'] == 'accessories') {
		
		$type = 3;
		
	}
	
	else if ($_GET['type'] == 'tshirts') {
		
		$type = 4;
		
	}
	
	else if ($_GET['type'] == 'shirts') {
		
		$type = 5;
		
	}
	
	else if ($_GET['type'] == 'pants') {
		
		$type = 6;
		
	}
	
	if (!empty($_GET['Search']) && $_GET['Search'] != "undefined") {
		
		$add = " AND MATCH(Item.Name) AGAINST(?)";
		
	}
	
	else {
		
		$add = "";
		
	}
	
	$getCount = $db->prepare("SELECT COUNT(DISTINCT Item.ID) FROM UserInventory JOIN Item ON Item.ID = UserInventory.ItemID WHERE UserInventory.UserID = ".$myU->ID." AND Item.ItemType = ?".$add." ORDER BY UserInventory.TimeCreated DESC");
	$getCount->bindValue(1, $type, PDO::PARAM_STR);
	
	if (!empty($_GET['Search']) && $_GET['Search'] != "undefined") {
		$getCount->bindValue(2, $_GET['Search'], PDO::PARAM_STR);
	}
	
	$getCount->execute();
	$numCount = $getCount->fetchColumn();
	
	// Limit per page
	$limit = 8;
		
	// How many pages will there be
	$pages = ceil($numCount / $limit);
	
	// Page we are currently on
	$page = min($pages, filter_input(INPUT_GET, 'Page', FILTER_VALIDATE_INT, array(
		'options' => array(
			'default'   => 1,
			'min_range' => 1,
		),
	)));
	
	if ($page == 0) { $page = 1; }
		
	$offset = ($page - 1)  * $limit;

	$getInventory = $db->prepare("SELECT UserInventory.ID, UserInventory.ItemID, UserInventory.CollectionNumber, Item.Name, Item.ItemType, Item.PreviewImage, Item.IsCollectible FROM UserInventory JOIN Item ON Item.ID = UserInventory.ItemID WHERE UserInventory.UserID = ".$myU->ID." AND Item.ItemType = ?".$add." GROUP BY Item.ID ORDER BY UserInventory.TimeCreated DESC LIMIT ".$limit." OFFSET ".$offset."");
	$getInventory->bindValue(1, $type, PDO::PARAM_STR);
	if (!empty($_GET['Search']) && $_GET['Search'] != "undefined") {
		$getInventory->bindValue(2, '%'.$_GET['Search'].'%', PDO::PARAM_STR);
	}
	$getInventory->execute();
	
	echo '<div class="grid-x grid-margin-x clearfix">';
	
	while ($gI = $getInventory->fetch(PDO::FETCH_OBJ)) {
		
		echo '
		<div class="large-3 cell">
			<div class="edit-character-card text-center">
				<img src="'.$cdnName.''.$gI->PreviewImage.'" class="card-image">
				<a href="'.$serverName.'/store/view/'.$gI->ItemID.'/'.str_replace(' ', '-', $gI->Name).'/" target="_blank">'.$gI->Name.'</a>
				<a class="wear" onclick="wearItem(\''.$gI->ID.'\')">Wear</a>
			</div>
		</div>
		';
		
	}
	
	echo '</div>';
	
	if ($pages > 1) {

		echo '
		<div class="push-10"></div>
		<ul class="pagination" role="navigation" aria-label="Pagination">
			<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a onclick="updateInventory(\''.htmlentities($_GET['type']).'\','.($page-1).')">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
			';

			for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

				if ($i <= $pages) {

					echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a onclick="updateInventory(\''.htmlentities($_GET['type']).'\','.($i).')">'.$i.'</a></li>';

				}

			}

			echo '
			<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a onclick="updateInventory(\''.htmlentities($_GET['type']).'\','.($page+1).')">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
		</ul>
		';

	}
	