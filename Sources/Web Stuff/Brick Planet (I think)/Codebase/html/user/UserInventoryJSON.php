<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	if (empty($_GET['u']) || empty($_GET['t'])) {

		die("Error");

	}

	$getCount = $db->prepare("SELECT Item.ID FROM Item LEFT JOIN User ON Item.CreatorID = User.ID JOIN UserInventory ON Item.ID = UserInventory.ItemID LEFT JOIN UserGroup ON UserGroup.ID = Item.CreatorID WHERE UserInventory.UserID = (SELECT ID FROM User WHERE Username = ?) AND Item.ItemType = ? AND Item.PublicView = 1 GROUP BY Item.ID");
	$getCount->bindValue(1, $_GET['u'], PDO::PARAM_STR);
	$getCount->bindValue(2, $_GET['t'], PDO::PARAM_INT);
	$getCount->execute();
	$Count = $getCount->rowCount();

	if ($Count == 0) {

		die("No results found.");

	}

	$limit = 12;

	$pages = ceil($Count / $limit);

	$page = $_GET['p'];
	if (!is_numeric($page) || $page < 1) { $page = 1; }

	$offset = ($page - 1)  * $limit;
	if ($offset < 0) { $offset = 0; }

	$getItem = $db->prepare("SELECT Item.ID, Item.Name, Item.CreatorID, Item.ItemType, Item.CreatorType, Item.TimeUpdated, Item.Cost, Item.CostCredits, Item.SaleActive, Item.PreviewImage, User.Username, UserGroup.Name AS GroupName, COUNT(Item.ID) AS CopiesOwned FROM Item LEFT JOIN User ON Item.CreatorID = User.ID JOIN UserInventory ON Item.ID = UserInventory.ItemID LEFT JOIN UserGroup ON UserGroup.ID = Item.CreatorID WHERE UserInventory.UserID = (SELECT ID FROM User WHERE Username = ?) AND Item.ItemType = ? AND Item.PublicView = 1 GROUP BY Item.ID ORDER BY UserInventory.TimeCreated DESC LIMIT ? OFFSET ?");
	$getItem->bindValue(1, $_GET['u'], PDO::PARAM_STR);
	$getItem->bindValue(2, $_GET['t'], PDO::PARAM_INT);
	$getItem->bindValue(3, $limit, PDO::PARAM_INT);
	$getItem->bindValue(4, $offset, PDO::PARAM_INT);
	$getItem->execute();

	echo '<div class="grid-x grid-margin-x" style="margin-top:-25px;">';

	while ($gI = $getItem->fetch(PDO::FETCH_OBJ)) {

		if ($gI->CreatorType == 0) {
			$CreatorLink = '<a href="'.$serverName.'/users/'.$gI->Username.'/">'.$gI->Username.'</a>';
		} else {
			$CreatorLink = '<a href="'.$serverName.'/groups/'.$gI->CreatorID.'/'.str_replace(' ', '-', $gI->GroupName).'/">'.$gI->GroupName.'</a>';
		}

		echo '
		<div class="large-3 cell">
			<div class="border-r store-item-card">
				<div class="card-image relative">
					<a href="'.$serverName.'/store/view/'.$gI->ID.'/">
						<img src="'.$cdnName . $gI->PreviewImage.'">
					</a>
					';

					if ($gI->CopiesOwned > 1) {

						echo '
						<span class="number-copies" title="'.number_format($gI->CopiesOwned).' Copies">'.number_format($gI->CopiesOwned).'</span>
						';

					}

					echo '
				</div>
				<div class="card-divider"></div>
				<div class="card-body">
					<div class="grid-x grid-margin-x">
						<div class="auto cell">
							<div class="card-item-name"><a href="'.$serverName.'/store/view/'.$gI->ID.'/">'.LimitTextByCharacters($gI->Name, 22).'</a></div>
						</div>
					</div>
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell text-left">
							<div class="card-item-creator">'.$CreatorLink.'</div>
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

	echo '</div>';

	if ($pages > 1) {

		echo '
		<div class="push-25"></div>
		<ul class="pagination" role="navigation" aria-label="Pagination">
			<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '" onclick="userbackpack('.$_GET['t'].', '.($page-1).')">Previous <span class="show-for-sr">page</span>'; } echo '</li>
			';

			for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

				if ($i <= $pages) {

					echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'" onclick="userbackpack('.$_GET['t'].', '.($i).')">'.$i.'</li>';

				}

			}

			echo '
			<li class="pagination-next'; if ($page == $pages) { echo ' disabled'; } echo '" aria-label="Next page"'; if ($page != $pages) { echo ' onclick="userbackpack('.$_GET['t'].', '.($page+1).')"'; } echo '>Next <span class="show-for-sr">page</span></li>
		</ul>
		';

	}
