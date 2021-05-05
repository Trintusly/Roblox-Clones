<?php
	include("../SiT_3/config.php");
	
	$error = array();
	
	$clanID = mysqli_real_escape_string($conn,$_GET['id']);
	$sqlClan = "SELECT * FROM `clans` WHERE `id`='$clanID'";
	$result = $conn->query($sqlClan);
	$clanRow = $result->fetch_assoc();
	
	$memCountSQL = "SELECT * FROM `clans` WHERE `id`='$clanID';";
	$memCount = $conn->query($memCountSQL);
	$memRow = $memCount->fetch_assoc();
	$memCount = $memRow['members'];
	
	$userID = $_SESSION['id'];
	$checkSQL = "SELECT * FROM `clans_members` WHERE `user_id`='$userID' AND `group_id`='$clanID' AND `status`='in';";
	$check = $conn->query($checkSQL);
	$isIn = $check->num_rows;
	if($isIn) {
		$currentRow = $check->fetch_assoc();
		$currentPower = $currentRow['rank'];
		$currentRankSQL = "SELECT * FROM `clans_ranks` WHERE `group_id`='$clanID' AND `power`='$currentPower'";
		$currentRankQuery = $conn->query($currentRankSQL);
		$currentRank = $currentRankQuery->fetch_assoc();
	}

	if(!($isIn && $currentRank['perm_ranks'] == 'yes')) {
		header("Location: /clan?id=".$clanID);
	}
	
	if($isIn && isset($_POST['userID']) && isset($_POST['rank'])) {
		$user = mysqli_real_escape_string($conn,$_POST['userID']);
		$rank = mysqli_real_escape_string($conn,$_POST['rank']);
		
		//check rank exists
		$checkSQL = "SELECT * FROM `clans_ranks` WHERE `group_id`='$clanID' AND `power`='$rank'";
		$check = $conn->query($checkSQL);
		if($check->num_rows > 0) {
			//check rank is less than theirs
			if($rank < $currentRank) {
				$updateSQL = "UPDATE `clans_members` SET `rank`='$rank' WHERE `group_id`='$clanID' AND `user_id`='$user' AND `status`='in'";
				$update = $conn->query($updateSQL);
			} else {
				$error[] = "Rank must be lower than yours";
			}
		} else {
			$error[] = "Invalid rank";
		}
	}
	
	
	
	
	$clanID = $clanID;
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
			echo '<select onchange="changeRank('.$userID.', this.value)" id="rank">';
			$sqlRanks = "SELECT * FROM `clans_ranks` WHERE `group_id`='$clanID' ORDER BY `power` <> '$rank', `power` ASC";
			$rankResult = $conn->query($sqlRanks);
			while($rankRow = $rankResult->fetch_assoc())
			{
				echo '<option value='.$rankRow['power'].'>'.$rankRow['name'].'</option>';
			}
			echo '</select>';
			echo '<img width=80% src="http://storage.brick-hill.com/images/avatars/'.$userID.'.png?c='.$userRow['avatar_id'].'"><br>';
			echo '<a style="color:#000;" href="http://www.brick-hill.com/user?id='.$userID.'">'.$userRow['username'].'</a>';
			echo '</div>';
		//}
	}
	
	echo '</div><div>';
	
	if($members/4 > 1) {
		for($i = 0; $i < ($members/4); $i++)
		{
			echo '<a style="color:#000;" onclick="getRank('.$i.', '.$rank.')">'.($i+1).'</a> ';
		}
	}
	
	echo '</div>';
	echo '<script>
	function changeRank(user,new_rank) {
	  	$.post("edit_members?id='.$clanID.'", {userID: user, rank: new_rank}, function(result){getRank(0,1);});
  	};
	</script>';
?>