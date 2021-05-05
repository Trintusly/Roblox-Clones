<?php
session_name("BRICK-SESSION");
session_start();
include("../SiT_3/config.php");
if(isset($_GET['page'])) {
	$page = mysqli_real_escape_string($conn,$_GET['page']);
	$page = max($page,0);

	$limit = ($page)*12;
	if(isset($_GET['item']) || isset($_GET['search'])) {
		$crateSQL = "SELECT * FROM `shop_items` WHERE ";
		if(isset($_GET['item'])) {
			$item = mysqli_real_escape_string($conn,$_GET['item']);
			if($item == 'all') {
				$crateSQL = $crateSQL."`approved`='yes' AND `type`='hat' OR `type`='tool' OR `type`='face' AND ";
			} else {
				$crateSQL = $crateSQL."`approved`='yes' AND `type`='$item' AND ";
			}
		} else {$item = '';}
		if(isset($_GET['search'])) {
			$search = mysqli_real_escape_string($conn,$_GET['search']);
			$crateSQL = $crateSQL."`name` LIKE '%$search%' AND ";
		} else {$search = '';}
		$countSQL = $crateSQL."`approved`='yes'";
		$crateSQL = $crateSQL."`approved`='yes' ORDER BY `last_updated` DESC LIMIT $limit,12";
	} else {
		$crateSQL = "SELECT * FROM `shop_items` WHERE `type`='hat' OR `type`='tool' OR `type`='face' ORDER BY `last_updated` DESC LIMIT $limit,12";
		$countSQL = "SELECT * FROM `shop_items` WHERE `approved`='yes' AND (`type`='hat' OR `type`='tool' OR `type`='face')";
	}
	
	$result = $conn->query($crateSQL);
	$count = $conn->query($countSQL);
	$items = $count->num_rows;
	if ($items < 1) { echo '<div style="text-align: center;">No results found!</div>'; die();}
	$r = 0;
	echo '<div style="width:100%;display:block;overflow:auto;">';
	while($searchRow=$result->fetch_assoc()){
		$r++;
		//if($r >= (($page+1)*12)) {break;}
		//if($r >= ($page*12)) {
			$id = $searchRow['owner_id'];
			$sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$id'";
			$userResult = $conn->query($sqlUser);
			$userRow=$userResult->fetch_assoc();
		
			echo '<div style="margin: 10px; width: 142px; display:inline-block; ';
			echo'"><a href="item?id=' . $searchRow['id'] . '"><img ';
			
			// If collectible
			if($searchRow['collectable-edition']=='yes'){
				echo'style="background-image:url(\'speciale_ban.png\'); background-size:cover; border:0px; width:142px; height:142px;"';
			}
			elseif($searchRow['collectible']=='yes') {
				echo'style="background-image:url(\'special_ban.png\'); background-size:cover; border:0px; width:142px; height:142px;"';
			}
			elseif($searchRow['bits']==0 or $searchRow['bucks']==0){
				echo'style="background-image:url(\'free_ban.png\'); background-size:cover; border:0px; width:142px; height:142px;"';
			}
			
			if ($searchRow['approved'] == 'yes') {$thumbnail = $searchRow['id'];}
			elseif ($searchRow['approved'] == 'declined') {$thumbnail = 'declined';}
			else {$thumbnail = 'pending';}
			
			
			echo 'id="shopItem" src="/shop_storage/thumbnails/' . $thumbnail . '.png?c=' . rand() . '"></a>'; 
					
			if (strlen(htmlentities($searchRow['name'])) >= 20) {$dot = '...';} else {$dot = '';}
			echo '<span style="display:inline-block; float:left; width:100%">
				<a class="shopTitle" href="item?id=' . $searchRow['id'] . '">' . substr(htmlentities($searchRow['name']),0,20) . $dot . '</a>
				</span>
				<span style="display:inline-block; float:left; padding-left:0px;"><p class="shopDesc">by<a class="shopDesc" href="/user?id='. $searchRow['owner_id'] . '">' . $userRow['username'] . '</a></p></span>
				<span style="padding:0px; display:inline-block; float:right; text-align:right">';
			if ($searchRow['bucks'] >= 1) {
				echo '<p class="shopDesc" style="color:Green;"><i class="fa fa-money"></i> ' . $searchRow['bucks'] . '</p>';}
			elseif ($searchRow['bucks'] == 0) 
				{echo '<p class="shopDesc" style="color:#44A4EE;">FREE</p>';}
			if ($searchRow['bits'] >= 1) {
				echo '<p class="shopDesc" style="color:Orange;"><i class="fa fa-circle"></i> ' . $searchRow['bits'] . '</p>';}
			elseif ($searchRow['bits'] == 0 && $searchRow['bucks'] != 0) 
				{echo '<p class="shopDesc" style="color:#44A4EE;">FREE</p>';}
			echo '</span></div>';
			
		//}
	}
	
	if(($items/12) > 1) {
		echo '<div>';
		for($i = 0; $i < ($items/12); $i++)
		{
			echo '<a style="color:#000;" onclick="getPage(\''.$item.'\',\''.$search.'\', '.$i.')">'.($i+1).'</a> ';
		}
		echo '</div>';
	}
	
	echo '</div>';
} else {
	echo 'Error loading crate';
	die();
}

?>

