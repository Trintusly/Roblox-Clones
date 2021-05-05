<?php

	if (!isset($_GET['type']) || empty($_GET['type'])) { die('Invalid Request'); }
	
	require_once('/usr/share/nginx/root/private/db.php');
	
	$cache = new Memcached();
	$cache->addServer('127.0.0.1', 11211);
	
	if (empty($cache->get('CatalogHats'))) {
		
		$getItems = $db->prepare("SELECT `ID`,`Name`,`Description`,`Price`,`PriceCash`,`CreatorID`,`ItemType`,`ViewFile`,`CreationTime`,`UpdatedTime`,`OnSale`,`IsLimited`,`FullStock`,`RemainingStock` FROM `Items` WHERE `ItemType` IN('hat','accessory','face') AND `ViewFile` != 'pending.png' AND `ViewFile` != 'rejected.png' ORDER BY `UpdatedTime` DESC");
		$getItems->execute();
		
		while ($gI = $getItems->fetch(PDO::FETCH_OBJ)) {
			$array[] = $gI;
		}
		
		$cache->set('CatalogHats', $array, 30);
		
	}
	
	$getData = $cache->get('CatalogHats');
	
	echo '<div class="row">';
	
	$i = 0;
	
	foreach ($getData as $row) {
		
		$i++;
		
		$getCreator = $db->prepare("SELECT `Username` FROM `Users` WHERE `ID` = ".$row->CreatorID."");
		$getCreator->execute();
		$gC = $getCreator->fetchColumn();
		
		if (strlen($row->Name) > 19) {
			
			$Short = substr($row->Name, 0, 19);
			
			$ItemName = substr($row->Name, 0, 19) . '...';
			
		}
		
		else {
			
			$ItemName = $row->Name;
			
		}
		
		echo '
		<div class="col-md-3">
			<div class="catalog-white-container"><div class="catalog-white-container-content">
				<div style="position:relative;width:160px;height:160px;">
					<a href="https://www.bloxcity.com/catalog/item/'.$row->ID.'"><img src="https://storage.googleapis.com/bloxcity-file-storage/'.$row->ViewFile.'" style="border:1px solid #eee;padding:15px;float:right;position:absolute;right:0;top:0;z-index:1000;width:160px;height:160px;"></a>
					';
					
					if ($row->IsLimited == 1) {
					
						echo '
						<img src="https://storage.googleapis.com/bloxcity-file-storage/assets/images/collectible-icon.png" width="25" height="25" style="top:2px;right:2px;position:absolute;" title="Collectible" alt="Collectible">
						';
					
					}
					
					echo '
				</div>
				<div style="height:10px;"></div>
				<a href="https://www.bloxcity.com/catalog/item/'.$row->ID.'" style="text-decoration:none;"><div style="color:#555;font-size:16px;font-family:Roboto;font-weight:500;" title="'.$row->Name.'">'.$ItemName.'</div></a>
				<div style="height:5px;"></div>
				<div style="color:#999;font-size:12px;font-family:Roboto;font-weight:300;">Created by <a href="'.$serverName.'/profile/'.$gC.'">'.$gC.'</a></div>
				';
				
				if ($row->OnSale == 1) {
					
					if ($row->PriceCash != 0) {
						
						echo '<font style="color:#5CAB7D;font-size:12px;font-family:Roboto;font-weight:500;">'.number_format($row->PriceCash).' Cash</font>';
						
					}
					
					if ($row->Price != 0) {
						
						echo '<font style="color:#FFBC42;font-size:12px;font-family:Roboto;font-weight:500px;">'.number_format($row->Price).' Coins</font>';
						
					}
					
					if ($row->PriceCash == 0 && $row->Price == 0) {
						
						echo '<font style="color:#666;font-size:12px;font-family:Roboto;font-weight:500;">Off Sale</font>';
						
					}
					
				}
				
				else {
					
					echo '<font style="color:#666;font-size:12px;font-family:Roboto;font-weight:500;">Off Sale</font>';
					
				}
				
				if ($row->IsLimited == 1) {
					
					echo '<font style="display:block;color:#E53A40;font-size:12px;font-family:Roboto;font-weight:500;">'.$row->RemainingStock.'/'.$row->FullStock.' remaining</font>';
					
				}
				
				echo '
			</div></div>
			<div style="height:25px;"></div>
		</div>
		';
		
		if ($i == 4) {
			echo '<div class="clearfix"></div>';
			$i = 0;
		}
			
	}
	
	echo '</div>';