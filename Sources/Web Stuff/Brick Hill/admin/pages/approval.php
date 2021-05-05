<?php 	
	require("adminOnly.php");
    include("../../SiT_3/config.php");
	
    if($power < 1) {header("Location: ../");die(); } 
	
?>
<div id="box" style="padding: 5px;">
				<div id="subsect">
					<h3>Image Approval</h3>
				</div>
					<div style="margin-bottom:10px;" onclick="var spoilerContent = $(this).children('#spoiler-content'); if(spoilerContent.css('display') == 'none') { spoilerContent.css('display', 'block'); } else if(spoilerContent.css('display') == 'block') { spoilerContent.css('display', 'none');  } ">
					
					<?php
					
					$shopImageSQL = "SELECT * FROM `shop_items` WHERE `approved`='no' ORDER BY `date` DESC LIMIT 0,10";
					$shopImage = $conn->query($shopImageSQL);
					$shopImageCount = $shopImage->num_rows;
						
					?>
					<div class="spoiler"> Shop Items (<?php echo $shopImageCount; ?>)</div>
					<div id="spoiler-content" style="<?php if (isset($_GET['approval'])) { if($_GET['approval'] == "shop") { echo "display:block;/* ok */"; } else { echo "display:none;"; }; } else { echo "display:none;"; }; ?>">
					<?php 
					
					if ($shopImageCount > 0) {
					
					while($shopRow = $shopImage->fetch_assoc()) {
							$itemID = $shopRow['id'];
							$type = $shopRow['type'];
							if($type != "pants") {$type = $type.'s';}
							echo '<div id="subsect" style="overflow:auto;">';
							echo '<div style="text-align:center;padding:4px;"><div><div style="width:35%;float:left;text-align:center;"><img style="width:250px;" src="/shop_storage/assests/'.$type.'/'.shopItemHash($itemID).'.png"></div><div style="width:35%;float:left;text-align:center;"><img style="width:250px;" src="/shop_storage/thumbnails/'.$itemID.'.png"></div>';
							echo '<div style="width:30%;text-algin:center;float:left;padding-top:10px;"><a href="/shop/item?id='.$itemID.'">'.htmlentities($shopRow['name']).'</a>';
							echo '<br><br><a class="blue-button" href="index?approve='.$itemID.'">Approve</a><br><br><a class="red-button" href="index?decline='.$itemID.'">Decline</a></div></div>';
							echo '</div></div>';
					}
					
					} else {
						?><div style="padding:5px;text-align:center;">No shop items need approval!</div><?php
					}
					?>
					</div>
					</div>
					<div style="margin-bottom:10px;" onclick="var spoilerContent = $(this).children('#spoiler-content'); if(spoilerContent.css('display') == 'none') { spoilerContent.css('display', 'block'); } else if(spoilerContent.css('display') == 'block') { spoilerContent.css('display', 'none');  } ">
					
					<?php
					
					$clanLogoSQL = "SELECT * FROM `clans` WHERE `approved`='no' LIMIT 0,10";
					$clanLogoQuery = $conn->query($clanLogoSQL);
					$clanLogoCount = $clanLogoQuery->num_rows;
						
					?>
					<div class="spoiler"> Clan Logos (<?php echo $clanLogoCount; ?>)</div>
					<div id="spoiler-content" style="<?php if (isset($_GET['approval'])) { if($_GET['approval'] == "clan") { echo "display:block;"; } else { echo "display:none;"; }; } else { echo "display:none;"; }; ?>">
					<?php 
					
					if ($clanLogoCount > 0) {
					
					while($clanRow = $clanLogoQuery->fetch_assoc()) {
							$clanID = $clanRow['id'];
							echo '<div id="subsect" style="overflow:auto;">';
							echo '<div style="text-align:center;padding:4px;"><div><div style="width:50%;float:left;text-align:center;"><img style="width:250px;" src="http://storage.brick-hill.com/images/clans/'.$clanID.'.png"></div>';
							echo '<div style="width:50%;text-algin:center;float:left;padding-top:10px;"><a href="/shop/item?id='.$itemID.'">'.htmlentities($clanRow['name']).'</a>';
							echo '<br><br><a class="blue-button" href="index?clan-approve='.$clanID.'">Approve</a><br><br><a class="red-button" href="index?decline='.$itemID.'">Decline</a></div></div>';
							echo '</div></div>';
					}
					
					} else {
						?><div style="padding:5px;text-align:center;">No clan logos approval!</div><?php
					}
					?>
					</div>
					</div>
			</div>