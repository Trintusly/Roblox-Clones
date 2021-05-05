<?php
	
	include("../SiT_3/config.php");
	
	$clanID = mysqli_real_escape_string($conn,$_GET['clan']);
	$page = mysqli_real_escape_string($conn,$_GET['page']);
	
	$page = max($page,1);
	
	if(isset($_SESSION['id'])) {$userID = $_SESSION['id']; $loggedIn = true;} else {$userID = 0; $loggedIn = false;}
	$checkSQL = "SELECT * FROM `clans_members` WHERE `user_id`='$userID' AND `group_id`='$clanID' AND `status`='in';";
	$check = $conn->query($checkSQL);
	$isIn = min($check->num_rows,1);
	if($isIn) {
		$currentRow = $check->fetch_assoc();
		$currentPower = $currentRow['rank'];
		$currentRankSQL = "SELECT * FROM `clans_ranks` WHERE `group_id`='$clanID' AND `power`='$currentPower'";
		$currentRankQuery = $conn->query($currentRankSQL);
		$currentRank = $currentRankQuery->fetch_assoc();
	} else {
		$currentRank = 0;
	}
	
	$totalSQL = "SELECT * FROM `clans_walls` WHERE `group_id`='$clanID' AND `type`!='deleted'";
	$total = $conn->query($totalSQL);
	$count = $total->num_rows;
	
	$limit = ($page-1)*10;
	$wallSQL = "SELECT * FROM `clans_walls` WHERE `group_id`='$clanID' AND `type`!='deleted' ORDER BY `type` ASC, `id` DESC LIMIT $limit,10";
	$wall = $conn->query($wallSQL);
	while($wallRow = $wall->fetch_assoc()) {
		if($wallRow['type'] == 'pinned') {$pin = 1;} else {$pin = 0;}
		echo '<div id="subsect" style="overflow: auto;">
		<img style="float:left; width:80px;" src="http://storage.brick-hill.com/images/avatars/'.$wallRow['owner_id'].'.png?c='.rand()/*$wallRow['avatar_id']*/.'"><span style="font-size:12px;">'.str_repeat('<i class="fa fa-thumb-tack"></i>',$pin).$wallRow['time'].'</span><br>'. htmlentities ( $wallRow['post'] );
		if($loggedIn) {
			if($currentRank['perm_posts'] == 'yes') {
				if($wallRow['type'] == 'normal') {
					echo '<div><a class="label" href="?id='.$clanID.'&pin='.$wallRow['id'].'">Pin</a>';
				} else {
					echo '<div><a class="label" href="?id='.$clanID.'&unpin='.$wallRow['id'].'">Unpin</a>';
				}
				echo '&nbsp;<a class="label" href="?id='.$clanID.'&delete='.$wallRow['id'].'">Delete</a></div>';
			}
		}
			
		echo '</div>';
	}
	
	
	
	
	echo '</div><div class="numButtonsHolder">';
	
	if($count/10 > 1) {
		for($i = 0; $i < ($count/10); $i++)
		{
			echo '<a onclick="getWall('.($i+1).')">'.($i+1).'</a> ';
		}
	}
	
	echo '</div>';
?>