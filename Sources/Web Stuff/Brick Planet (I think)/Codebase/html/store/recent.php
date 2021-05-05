<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	if ($_GET['ItemType'] == 'all') {

		$getRecent = $cache->get('MarketRecentAll');
	
	}
	
	else if ($_GET['ItemType'] == 'head') {
		
		$getRecent = $cache->get('MarketRecentHeads');
		
	}
	
	else if ($_GET['ItemType'] == 'hat') {
		
		$getRecent = $cache->get('MarketRecentHats');
		
	}
	
	else if ($_GET['ItemType'] == 'face') {
		
		$getRecent = $cache->get('MarketRecentFaces');
		
	}
	
	else if ($_GET['ItemType'] == 'accessory') {
		
		$getRecent = $cache->get('MarketRecentAccessories');
		
	}
	
	else if ($_GET['ItemType'] == 'tshirt') {
		
		$getRecent = $cache->get('MarketRecentTShirts');
		
	}
	
	else if ($_GET['ItemType'] == 'shirt') {
		
		$getRecent = $cache->get('MarketRecentShirts');
		
	}
	
	else if ($_GET['ItemType'] == 'pants') {
		
		$getRecent = $cache->get('MarketRecentPants');
		
	}
	
	else {
		die("Error");
	}
	
	if ($_GET['Page'] == 'undefined' || $_GET['Page'] > 10) {
		unset($_GET['Page']);
	}

	echo '
	<div class="pure-g" style="margin-bottom:0;">
	';
	
	// Page we are currently on
	$page = min(10, filter_input(INPUT_GET, 'Page', FILTER_VALIDATE_INT, array(
		'options' => array(
			'default'   => 1,
			'min_range' => 1,
		),
	)));
	
	$startAt = ($page-1)*18;
	$endAt = $startAt+18;
	
	$counter = 0;
	$i = 0;
	
	foreach ($getRecent as $gF) {
		
		$counter++;
		
		if ($counter > $startAt && $counter <= $endAt) {
		
			$i++;
		
			if ($gF->Username == 'BLOXCity') { $NameView = 'BLOX City'; } else { $NameView = $gF->Username; }
			
			echo '
			<div class="pure-u-4-24" style="position:relative;'; if ($counter > 6) { echo 'margin-top:15px;'; } echo '">
				';
				
				if ($gF->IsLimited == 1) {
					
					echo '
					<div class="ribbon"><span>COLLECTIBLE</span></div>
					';
					
				}
				
				if ($gF->GoesOffSale > time()) {
					
					echo '
					<div class="off-sale tooltipped" data-position="left" data-delay="50" data-tooltip="This item will go off sale at '.date('m/d/Y g:iA', $gF->GoesOffSale).' CST"><i class="material-icons" style="color:#666666;font-size:22px;">timelapse</i></div>
					';
					
				}
				
				echo '
				<a href="'.$serverName.'/market/'.$gF->ID.'/"><img src="'.$cdnName.''.$gF->ViewFile.'" class="responsive-market-img item-view item-view-padding"></a>
				<a href="'.$serverName.'/market/'.$gF->ID.'/"><div class="item-name">'.$gF->Name.'</div></a>
				<div class="item-creator">
					Creator: <a href="'.$serverName.'/users/'.$gF->UserID.'/'.$gF->Username.'/">'.$NameView.'</a>
				</div>
				';
				
				if ($gF->OnSale == 1) {
				
				echo '
				<div class="item-price">
					';
					
					if (!empty($gF->PriceCash) && $gF->PriceCash) {
						
						echo '
						<div class="item-price-cash">
							<i class="material-icons" style="font-size:14px;color:#15BF6B;">monetization_on</i>
							'.number_format($gF->PriceCash).'
						</div>
						';
						
					}
					
					if (!empty($gF->Price) && $gF->Price) {
						
						echo '
						<div class="item-price-coins">
							<i class="material-icons" style="font-size:14px;color:#F2C11B;">copyright</i>
							'.number_format($gF->Price).'
						</div>
						';
						
					}
					
					if ($gF->IsLimited == 1 && $gF->RemainingStock > 0) {
						
						echo '
						<div class="item-stock">
							'.number_format($gF->RemainingStock).'/'.number_format($gF->FullStock).' remaining
						</div>
						';
						
					}
					
					else if ($gF->IsLimited == 1 && $gF->RemainingStock == 0) {
						
						echo '
						<div class="item-stock">
							SOLD OUT
						</div>
						';
						
					}
					
					echo '
				</div>
				';
				
				}
				
				echo '
			</div>
			';
			
			if ($i == 6) {
				
				echo '<div class="clearfix"></div>';
				
				$i = 0;
				
			}
		
		}
		
	}
	
	echo '
	</div>
	';
	
	
	if ($page <= 9) {
		
		echo '<div style="padding-top:15px;text-align:center;"><a onclick="loadRecent(\''.$_GET['ItemType'].'\','.($page + 1).')" id="'.($page + 1).'DIV" style="font-size:16px;cursor:pointer;">Load more...</a></div>';
		
	}
	