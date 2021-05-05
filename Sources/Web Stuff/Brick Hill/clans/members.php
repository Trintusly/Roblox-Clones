<?php
	include("../SiT_3/config.php");
	
	$clanID = mysqli_real_escape_string($conn,$_GET['clan']);
	$rank = mysqli_real_escape_string($conn,$_GET['rank']);
	$page = mysqli_real_escape_string($conn,$_GET['page']);
	
	$page = max($page,0);
	
	$limit = ($page)*4;
	$membersSQL = "SELECT * FROM `clans_members` WHERE `group_id`='$clanID' AND `rank`='$rank' AND `status`='in' ORDER BY `id` DESC LIMIT $limit,4";
	$memberResult = $conn->query($membersSQL);
	
	$countSQL = "SELECT * FROM `clans_members` WHERE `group_id`='$clanID' AND `rank`='$rank' AND `status`='in'";
	$count = $conn->query($countSQL);
	$members = $count->num_rows;
	
	echo '<div style="width:100%;display:block;">';
	
	$r = 0;
	while($rankRow=$memberResult->fetch_assoc()){ 
		$r++;
		//if($r >= (($page+1)*5)) {break;}
		//if($r >= ($page*5)) {
			$userID = $rankRow['user_id'];
			$userSQL = "SELECT * FROM `beta_users` WHERE `id`='$userID'";
			$userResult = $conn->query($userSQL);
			$userRow=$userResult->fetch_assoc();
			echo '<div style="display:inline-block;width:25%">';
			echo '<img width=80% src="http://storage.brick-hill.com/images/avatars/'.$userID.'.png?c='.$userRow['avatar_id'].'"><br>';
			echo '<a style="color:#000;" href="http://www.brick-hill.com/user?id='.$userID.'">'.$userRow['username'].'</a>';
			echo '</div>';
		//}
	}
	
	echo '</div><div class="numButtonsHolder">';
	
	if($members/4 > 1) {
		for($i = 0; $i < ($members/4); $i++)
		{
			echo '<a onclick="getRank('.$i.', '.$rank.')">'.($i+1).'</a> ';
		}
	}
	
	echo '</div>';
?>