<?php
$page = 'creator-area';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	$getTodayEarnings = $db->prepare("SELECT Coins, TransactionsCount FROM UserDailyEarning WHERE UserID = ".$myU->ID." AND TimeStart = UNIX_TIMESTAMP(CURDATE()) AND TimeEnd = UNIX_TIMESTAMP(DATE_ADD(CURDATE(),INTERVAL +1 DAY))");
	$getTodayEarnings->execute();
	
	$getYesterdayEarnings = $db->prepare("SELECT Coins, TransactionsCount FROM UserDailyEarning WHERE UserID = ".$myU->ID." AND TimeEnd = UNIX_TIMESTAMP(CURDATE())");
	$getYesterdayEarnings->execute();

	if ($getTodayEarnings->rowCount() == 0) {
		$TodayEarnings = 0;
		$TodaySales = 0;
	} else {
		$gT = $getTodayEarnings->fetch(PDO::FETCH_OBJ);
		$TodayEarnings = $gT->Coins;
		$TodaySales = $gT->TransactionsCount;
	}
	
	if ($getYesterdayEarnings->rowCount() == 0) {
		$YesterdayEarnings = 0;
		$YesterdaySales = 0;
	} else {
		$gY = $getYesterdayEarnings->fetch(PDO::FETCH_OBJ);
		$YesterdayEarnings = $gY->Coins;
		$YesterdaySales = $gY->TransactionsCount;
	}
	
	$ClothingCategory = (!isset($_GET['clothing_category']) && $_GET['clothing_category'] != 1 && $_GET['clothing_category'] != 2) ? 0 : $_GET['clothing_category'];
	$ClothingQuery = htmlentities(strip_tags($_GET['clothing_query']));
	
	switch ($ClothingCategory) {
		case 0:
			$DBClothingCategory = 'Item.ItemType IN(5,6)';
			break;
		case 1:
			$DBClothingCategory = 'Item.ItemType = 5';
			break;
		case 2:
			$DBClothingCategory = 'Item.ItemType = 6';
			break;
	}
	
	echo '
	<script>
	document.title = "Creator Area - Brick Create";
	';
	if (isset($_GET['sales_page'])) {
		echo '
		window.onload = function() {
			setTimeout(function() {
				$("#tabs").foundation("selectTab", "sales");
			}, 100);
		}
		';
		$jumped = 1;
	} else if (isset($_GET['earnings_page'])) {
		echo '
		window.onload = function() {
			setTimeout(function() {
				$("#tabs").foundation("selectTab", "earnings");
			}, 100);
		}
		';
		$jumped = 1;
	} else if (isset($_GET['clothing_page']) || !empty($_GET['clothing_category']) || !empty($_GET['clothing_query'])) {
		echo '
		window.onload = function() {
			setTimeout(function() {
				$("#tabs").foundation("selectTab", "clothing");
			}, 100);
		}
		';
		$jumped = 1;
	}
	echo '
	</script>
	<div class="grid-x grid-margin-x align-middle">
		<div class="auto cell no-margin">
			<h4>Creator Area</h4>
		</div>
		<div class="shrink cell no-margin">
			<button class="button button-green" type="button" data-toggle="dropdown">Create</button>
			<div class="dropdown-pane creator-area-dropdown" id="dropdown" data-dropdown data-hover="true" data-hover-pane="true">
				<ul>
					<li><a href="'.$serverName.'/creator-area/create/shirt/">Create Shirt</a></li>
					<li><a href="'.$serverName.'/creator-area/create/pants/">Create Pants</a></li>
				</ul>
				<div class="creator-area-dropdown-divider"></div>
				<ul>
					<li><a href="'.$serverName.'/creator-area/create/group/">Create Group</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="push-15"></div>
	<ul class="tabs grid-x grid-margin-x settings-tabs" data-tabs id="tabs">
		<li class="no-margin tabs-title cell'; if (!isset($jumped)) { echo ' is-active'; } echo '" aria-selected="true"><a href="#dashboard">Dashboard</a></li>
		<li class="no-margin tabs-title cell"><a href="#sales">Sales</a></li>
		<li class="no-margin tabs-title cell"><a href="#earnings">Earnings</a></li>
		<li class="no-margin tabs-title cell"><a href="#clothing" class="no-right-border">Clothing</a></li>
	</ul>
	<div class="tabs-content" data-tabs-content="tabs">
		<div id="dashboard" class="tabs-panel'; if (!isset($jumped)) { echo ' is-active'; } echo '">
			<div class="grid-x grid-margin-x">
				<div class="large-4 medium-4 small-6 cell">
					<div class="container border-r md-padding text-center">
						<div class="creator-area-info-title">Earnings Today</div>
						<div class="creator-area-info-info creator-area-info-price">'.number_format($TodayEarnings).' Bits</div>
						<div class="creator-area-trending trending-flat">
							';
							
							if ($TodayEarnings == 0 && $YesterdayEarnings == 0 || $TodayEarnings == $YesterdayEarnings) {
								
								echo '
								<i class="material-icons trending-flat">trending_flat</i><span class="trending-flat">+0 Bits (+0%) vs yesterday</span>
								';
					
								} else if ($YesterdayEarnings == 0 && $TodayEarnings > 0) {
									
									$Difference = $TodayEarnings - $YesterdayEarnings;
									
									echo '
									<i class="material-icons trending-up">arrow_drop_up</i><span class="trending-up">+'.number_format($Difference).' Bits (+100%) vs yesterday</span>
									';
									
								} else if ($TodayEarnings > $YesterdayEarnings) {
								
								$Difference = $TodayEarnings - $YesterdayEarnings;
								$PercentChange = (($TodayEarnings - $YesterdayEarnings)/$YesterdayEarnings)*100;
								
								echo '
								<i class="material-icons trending-up">arrow_drop_up</i><span class="trending-up">+'.number_format($Difference).' Bits (+'.number_format($PercentChange, 2).'%) vs yesterday</span>
								';
							
							} else if ($TodayEarnings < $YesterdayEarnings) {
								
								$Difference = $YesterdayEarnings - $TodayEarnings;
								if ($TodayEarnings > 0) {
									$PercentChange = (($YesterdayEarnings - $TodayEarnings)/$TodayEarnings)*100;
								} else {
									$PercentChange = '-100';
								}
								
								echo '
								<i class="material-icons trending-down">arrow_drop_down</i><span class="trending-down">-'.number_format($Difference).' Bits ('.number_format($PercentChange, 2).'%) vs yesterday</span>
								';
								
							}
							
							echo '
						</div>
					</div>
				</div>
				<div class="large-4 medium-4 small-6 cell">
					<div class="container border-r md-padding text-center">
						<div class="creator-area-info-title"># Of Sales Today</div>
						<div class="creator-area-info-info">'.number_format($TodaySales).'</div>
						<div class="creator-area-trending trending-flat">
						';
						
						if ($TodaySales == 0 && $YesterdaySales == 0 || $TodaySales == $YesterdaySales) {
							
							echo '
							<i class="material-icons trending-flat">trending_flat</i><span class="trending-flat">+0 Bits (+0%) vs yesterday</span>
							';
							
							} else if ($YesterdayEarnings == 0 && $TodayEarnings > 0) {
								
								$Difference = $TodaySales - $YesterdaySales;
								
								echo '
								<i class="material-icons trending-up">arrow_drop_up</i><span class="trending-up">+'.number_format($Difference).' (+100%) vs yesterday</span>
								';
								
							} else if ($TodaySales > $YesterdaySales) {
							
							$Difference = $TodaySales - $YesterdaySales;
							$PercentChange = (($TodaySales - $YesterdaySales)/$YesterdaySales)*100;
							
							echo '
							<i class="material-icons trending-up">arrow_drop_up</i><span class="trending-up">+'.number_format($Difference).' (+'.number_format($PercentChange, 2).'%) vs yesterday</span>
							';
							
							} else if ($TodaySales < $YesterdaySales) {
								
								$Difference = $YesterdaySales - $TodaySales;
								if ($TodaySales > 0) {
									$PercentChange = (($YesterdaySales - $TodaySales)/$TodaySales)*100;
								} else {
									$PercentChange = '-100';
								}
								
								echo '
								<i class="material-icons trending-down">arrow_drop_down</i><span class="trending-down">-'.number_format($Difference).' ('.number_format($PercentChange, 2).'%) vs yesterday</span>
								';
								
							}
						
						echo '
						</div>
					</div>
				</div>
				<div class="large-4 medium-4 small-6 cell">
					<div class="container border-r md-padding text-center">
						<div class="creator-area-info-title">Total Earnings</div>
						<div class="creator-area-info-info creator-area-info-price">'.number_format($myU->TotalEarningsCount).' Bits</div>
						<div class="creator-area-trending"><span class="trending-flat">#'.number_format($myU->TotalEarningsRank).' Globally</span></div>
					</div>
				</div>
			</div>
		</div>
		<div id="sales" class="tabs-panel">
			<h5>Sales</h5>
			<div class="container border-r md-padding">
				';
				
				if ($myU->SalesCount == 0) {
					
					echo 'No sales found. When you sell things, logs will show here.';
					
				} else {
				
					$limit = 10;
						
					$pages = ceil($myU->SalesCount / $limit);
						
					$page = min($pages, filter_input(INPUT_GET, 'sales_page', FILTER_VALIDATE_INT, array(
						'options' => array(
							'default'   => 1,
							'min_range' => 1,
						),
					)));
						
					$offset = ($page - 1)  * $limit;
					if ($offset < 0) { $offset = 0; }
					
					$getSales = $db->prepare("SELECT * FROM (SELECT Item.ID, Item.Name, Item.PreviewImage, (UTL.PreviousBalance-UTL.NewBalance) AS Amount, UTL.TimeTransaction, User.Username FROM UserTransactionLog AS UTL JOIN Item ON UTL.ReferenceID = Item.ID JOIN User ON UTL.UserID = User.ID WHERE UTL.EventID = 1 AND Item.CreatorID = ".$myU->ID." AND Item.CreatorType = 0 UNION SELECT Item.ID, Item.Name, Item.PreviewImage, (UTL.PreviousBalance-UTL.NewBalance) AS Amount, UTL.TimeTransaction, User.Username FROM UserTransactionLog AS UTL JOIN ItemSellerHistory ON UTL.ID = ItemSellerHistory.UTLID JOIN Item ON Item.ID = ItemSellerHistory.ItemID JOIN User ON ItemSellerHistory.BuyerID = User.ID WHERE UTL.EventID = 3 AND ItemSellerHistory.SellerID = ".$myU->ID.") x  ORDER BY TimeTransaction DESC LIMIT ? OFFSET ?");
					$getSales->bindValue(1, $limit, PDO::PARAM_INT);
					$getSales->bindValue(2, $offset, PDO::PARAM_INT);
					$getSales->execute();
					
					$i = 0;
					
					while ($gS = $getSales->fetch(PDO::FETCH_OBJ)) {
						
						$i++;
						
						if ($i > 1) {
							echo '<div class="creator-area-trans-divider"></div>';
						}
						
						echo '
						<div class="grid-x grid-margin-x align-middle creator-area-trans">
							<div class="shrink cell">
								<a href="'.$serverName.'/store/view/'.$gS->ID.'/"><div class="creator-area-trans-pic" style="background:url('.$cdnName . $gS->PreviewImage.') no-repeat;background-size:48px 48px;background-position: center center;"></div></a>
							</div>
							<div class="auto cell">
								<a href="'.$serverName.'/users/'.$gS->Username.'/">'.$gS->Username.'</a> purchased <a href="'.$serverName.'/store/view/'.$gS->ID.'/">'.$gS->Name.'</a> for <font class="coins-text">'.$gS->Amount.' Bits</font>
							</div>
							<div class="shrink cell right">
								'.date('m/d/Y g:iA', $gS->TimeTransaction).'
							</div>
						</div>
						';
						
					}
				
				}
				
				echo '
			</div>
			';
			
			if ($myU->SalesCount > 0 && $pages > 1) {
				
				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/creator-area/?sales_page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
					';

					for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
						
						if ($i <= $pages) {
						
							echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/creator-area/?sales_page='.($i).'">'.$i.'</a></li>';

						}
						
					}

					echo '
					<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/creator-area/?sales_page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
				</ul>
				';
			
			}
			
			echo '
		</div>
		<div id="earnings" class="tabs-panel">
			<h5>Earnings, by day</h5>
			<div class="container border-r md-padding">
				';
				
				if ($myU->EarningsCount == 0) {
					
					echo 'No results found.';
					
				} else {
					
					echo '
					<div class="grid-x grid-margin-x">
						<div class="large-5 medium-5 small-5 cell">
							<strong>Date</strong>
						</div>
						<div class="large-2 medium-2 small-2 cell">
							<strong># Of Sales</strong>
						</div>
						<div class="large-2 medium-2 small-2 cell">
							<strong>Gross</strong>
						</div>
						<div class="large-2 medium-2 small-2 cell">
							<strong>Final</strong>
						</div>
						<div class="large-1 medium-1 small-1 cell text-right">
							<strong>Status</strong>
						</div>
					</div>
					<div class="creator-area-trans-divider"></div>
					';
				
					$limit = 10;
						
					$pages = ceil($myU->EarningsCount / $limit);
						
					$page = min($pages, filter_input(INPUT_GET, 'earnings_page', FILTER_VALIDATE_INT, array(
						'options' => array(
							'default'   => 1,
							'min_range' => 1,
						),
					)));
						
					$offset = ($page - 1)  * $limit;
					if ($offset < 0) { $offset = 0; }
					
					$getEarnings = $db->prepare("SELECT Coins, TimeStart, TimeEnd, TransactionsCount, Status FROM UserDailyEarning WHERE UserID = ".$myU->ID." ORDER BY TimeEnd DESC LIMIT ? OFFSET ?");
					$getEarnings->bindValue(1, $limit, PDO::PARAM_INT);
					$getEarnings->bindValue(2, $offset, PDO::PARAM_INT);
					$getEarnings->execute();
					
					$i = 0;
					
					while ($gE = $getEarnings->fetch(PDO::FETCH_OBJ)) {
						
						$i++;
						
						if ($i > 1) {
							echo '<div class="creator-area-trans-divider"></div>';
						}
						
						switch ($gE->Status) {
							case 0:
								$Status = '-';
								break;
							case 1:
								$Status = '<div class="status-paid">Paid</div>';
								break;
							case 2:
								$Status = '<div class="status-held">Held</div>';
								break;
						}
						
						switch (true) {
							case $gE->Coins <= 500:
								$Bracket = '0';
								$Math = 1;
								break;
							case $gE->Coins <= 5000:
								$Bracket = '10';
								$Math = 0.9;
								break;
							case $gE->Coins <= 10000:
								$Bracket = '15';
								$Math = 0.85;
								break;
							case $gE->Coins <= 50000:
								$Bracket = '22.5';
								$Math = 0.775;
								break;
							case $gE->Coins > 50000:
								$Bracket = '30';
								$Math = 0.7;
								break;
						}
						
						echo '
						<div class="grid-x grid-margin-x">
							<div class="large-5 medium-5 small-5 cell">
								<span class="show-for-large">'.date('F dS, Y', $gE->TimeStart).'&nbsp;&dash;&nbsp;'.date('F dS, Y', $gE->TimeEnd).'</span>
								<span class="hide-for-large">'.date('m/d/Y', $gE->TimeStart).'&nbsp;&dash;&nbsp;'.date('m/d/Y', $gE->TimeEnd).'</span>
							</div>
							<div class="large-2 medium-2 small-2 cell">
								'.number_format($gE->TransactionsCount).'
							</div>
							<div class="large-2 medium-2 small-2 cell">
								<font class="coins-text">'.number_format($gE->Coins).' Bits</font>
							</div>
							<div class="large-2 medium-2 small-2 cell">
								<font class="coins-text">'.number_format((floor($gE->Coins*$Math))).' Bits</font> <font class="earnings-tax">(-'.$Bracket.'%)</font>
							</div>
							<div class="large-1 medium-1 small-1 cell text-right">
								'.$Status.'
							</div>
						</div>
						';
						
					}
				
				}
				
				echo '
			</div>
			';
			
			if ($myU->EarningsCount > 0 && $pages > 1) {
				
				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/creator-area/?earnings_page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
					';

					for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
						
						if ($i <= $pages) {
						
							echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/creator-area/?earnings_page='.($i).'">'.$i.'</a></li>';

						}
						
					}

					echo '
					<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/creator-area/?earnings_page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
				</ul>
				';
			
			}
			
			echo '
		</div>
		<div id="clothing" class="tabs-panel">
		';
		
		$limit = 10;
		
		if (empty($ClothingQuery)) {
			$countCreations = $db->prepare("SELECT COUNT(*) FROM Item JOIN UserInventory ON Item.ID = UserInventory.ItemID WHERE ".$DBClothingCategory." AND Item.CreatorID = ".$myU->ID." AND Item.CreatorType = 0 AND UserInventory.UserID = Item.CreatorID");
			$countCreations->execute();
			$ClothingCount = $countCreations->fetchColumn();
			$pages = ceil($ClothingCount / $limit);
		} else if (!empty($ClothingQuery)) {
			$countCreations = $db->prepare("SELECT COUNT(*) FROM Item JOIN UserInventory ON Item.ID = UserInventory.ItemID WHERE ".$DBClothingCategory." AND MATCH(Item.Name) AGAINST(?) AND Item.CreatorID = ".$myU->ID." AND Item.CreatorType = 0 AND UserInventory.UserID = Item.CreatorID");
			$countCreations->bindValue(1, $ClothingQuery, PDO::PARAM_STR);
			$countCreations->execute();
			$ClothingCount = $countCreations->fetchColumn();
			$pages = ceil($ClothingCount / $limit);
		}
		
		$page = min($pages, filter_input(INPUT_GET, 'clothing_page', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
			
		$offset = ($page - 1)  * $limit;
		if ($offset < 0) { $offset = 0; }
		
		echo '
			<h5>Clothing</h5>
			<div class="container border-r md-padding">
				';
				
				if ($ClothingCount == 0) {
					
					echo 'No results found.';
					
				} else {
				
					echo '
					<form action="" method="GET">
						<div class="grid-x grid-margin-x">
							<div class="shrink cell">
								<label for="clothing_category"><strong>Category</strong></label>
								<select name="clothing_category" class="normal-input clothing-input">
									<option value="0">All</option>
									<option value="1"'; if ($ClothingCategory == 1) { echo ' selected'; } echo '>Shirts</option>
									<option value="2"'; if ($ClothingCategory == 2) { echo ' selected'; } echo '>Pants</option>
								</select>
							</div>
							<div class="auto cell">
								<label for="clothing_query"><strong>Search</strong></label>
								<input type="text" name="clothing_query" class="normal-input clothing-input"'; if (!empty($ClothingQuery)) { echo ' value="'.$ClothingQuery.'"'; } echo '>
							</div>
							<div class="shrink cell">
								<label><strong>&nbsp;</strong></label>
								<input type="submit" class="button button-blue" value="Search">
							</div>
						</div>
						<input type="hidden" name="clothing_page" value="'.$page.'">
					</form>
					<div class="push-15"></div>
					<div class="grid-x grid-margin-x">
						<div class="large-1 medium-1 small-3 cell">
							<strong>Picture</strong>
						</div>
						<div class="large-3 medium-3 small-5 cell">
							<strong>Name</strong>
						</div>
						<div class="large-2 medium-2 small-2 cell text-center">
							<strong>Price</strong>
						</div>
						<div class="large-1 medium-1 small-1 cell text-center show-for-medium">
							<strong>Views</strong>
						</div>
						<div class="large-1 medium-1 small-1 cell text-center show-for-medium">
							<strong>Sales</strong>
						</div>
						<div class="large-2 medium-2 small-2 cell show-for-medium">
							<strong><span class="show-for-large">Last</span> <span>Updated</span></strong>
						</div>
						<div class="large-2 medium-2 small-2 cell text-right">
							<strong>Actions</strong>
						</div>
					</div>
					<div class="creator-area-trans-divider"></div>
					';
					
					if ($ClothingCategory == 0) {
						$getCreations = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.TimeUpdated, Item.PreviewImage AS Image, Item.Cost, Item.SaleActive, Item.NumberCopies, Item.ImpressionCount FROM Item JOIN UserInventory ON Item.ID = UserInventory.ItemID WHERE Item.CreatorID = ".$myU->ID." AND Item.CreatorType = 0 AND UserInventory.UserID = Item.CreatorID ORDER BY Item.TimeUpdated DESC LIMIT ? OFFSET ?");
						$getCreations->bindValue(1, $limit, PDO::PARAM_INT);
						$getCreations->bindValue(2, $offset, PDO::PARAM_INT);
						$getCreations->execute();
					} else if (empty($ClothingQuery)) {
						$getCreations = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.TimeUpdated, Item.PreviewImage AS Image, Item.Cost, Item.SaleActive, Item.NumberCopies, Item.ImpressionCount FROM Item JOIN UserInventory ON Item.ID = UserInventory.ItemID WHERE ".$DBClothingCategory." AND Item.CreatorID = ".$myU->ID." AND Item.CreatorType = 0 AND UserInventory.UserID = Item.CreatorID ORDER BY Item.TimeUpdated DESC LIMIT ? OFFSET ?");
						$getCreations->bindValue(1, $limit, PDO::PARAM_INT);
						$getCreations->bindValue(2, $offset, PDO::PARAM_INT);
						$getCreations->execute();
					} else if (!empty($ClothingQuery)) {
						$getCreations = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.TimeUpdated, Item.PreviewImage AS Image, Item.Cost, Item.SaleActive, Item.NumberCopies, Item.ImpressionCount FROM Item JOIN UserInventory ON Item.ID = UserInventory.ItemID WHERE ".$DBClothingCategory." AND MATCH(Item.Name) AGAINST(?) AND Item.CreatorID = ".$myU->ID." AND Item.CreatorType = 0 AND UserInventory.UserID = Item.CreatorID ORDER BY Item.TimeUpdated DESC LIMIT ? OFFSET ?");
						$getCreations->bindValue(1, $ClothingQuery, PDO::PARAM_STR);
						$getCreations->bindValue(2, $limit, PDO::PARAM_INT);
						$getCreations->bindValue(3, $offset, PDO::PARAM_INT);
						$getCreations->execute();
					}
					
					$i = 0;
					
					while ($gC = $getCreations->fetch(PDO::FETCH_OBJ)) {
						
						$i++;
						
						if ($i > 1) {
							echo '<div class="creator-area-trans-divider"></div>';
						}
						
						echo '
						<div class="grid-x grid-margin-x align-middle creator-area-trans">
							<div class="large-1 medium-1 small-3 cell text-center">
								<a href="'.$serverName.'/store/view/'.$gC->ID.'/"><div class="creator-area-trans-pic" style="background:url('.$cdnName . $gC->Image.') no-repeat;background-size:48px 48px;background-position: center center;"></div></a>
							</div>
							<div class="large-3 medium-3 small-5 cell">
								<a href="'.$serverName.'/store/view/'.$gC->ID.'/">'.$gC->Name.'</a>
								 - <font class="sub">('; if ($gC->ItemType == 5) { echo 'shirt'; } else { echo 'pants'; } echo ')</font>
								';
								
								if ($gC->SaleActive == 0) {
									echo ' - <font class="sub">(off sale)</font>';
								}
								
								echo '
							</div>
							<div class="large-2 medium-2 small-2 cell text-center">
								<font class="coins-text"><span>'.number_format($gC->Cost).'</span> <span class="show-for-medium">Bits</span></font>
							</div>
							<div class="large-1 medium-1 small-1 cell text-center show-for-medium">
								'.number_format($gC->ImpressionCount).'
							</div>
							<div class="large-1 medium-1 small-1 cell text-center show-for-medium">
								'.number_format($gC->NumberCopies).'
							</div>
							<div class="large-2 medium-2 small-2 cell show-for-medium">
								'.date('m/d/Y g:iA', $gC->TimeUpdated).'
							</div>
							<div class="large-2 medium-2 small-2 cell text-right">
								<a href="'.$serverName.'/store/edit/'.$gC->ID.'/" class="button button-grey" style="color:#FFF;display:inline;">Edit</a>
							</div>
						</div>
						';
						
					}
				
				}
				
				echo '
			</div>
			';
			
			if ($myU->ItemCount > 0 && $pages > 1) {
				
				if ($ClothingCategory == 0 && empty($ClothingQuery)) {
					$Link = '?clothing_page=';
				} else {
					$Link = '?clothing_category='.$ClothingCategory.'&clothing_query='.$ClothingQuery.'&clothing_page=';
				}
				
				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/creator-area/'.$Link . ($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
					';

					for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
						
						if ($i <= $pages) {
						
							echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/creator-area/'.$Link . ($i).'">'.$i.'</a></li>';

						}
						
					}

					echo '
					<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/creator-area/'.$Link . ($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
				</ul>
				';
			
			}
			
			echo '
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");