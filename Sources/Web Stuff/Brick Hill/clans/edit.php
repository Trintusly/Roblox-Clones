<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header("Location: index"); die();}

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

	if(!($isIn && ($currentRank['perm_ranks'] == 'yes' || $currentRank['perm_members'] == 'yes'))) {
		header("Location: /clan?id=".$clanID);
	}
	
	if(isset($_POST['newDesc'])) {
		$desc = mysqli_real_escape_string($conn,$_POST['description']);
		
		$updateSQL = "UPDATE `clans` SET `description`='$desc' WHERE `id`='$clanID'";
		$update = $conn->query($updateSQL);
	}
	
	//this area is messed up and idk why
	if(isset($_POST['rankName'])) {
		if($currentRank['perm_ranks'] == 'yes') {
			//change rank names
			$findRanksSQL = "SELECT * FROM `clans_ranks` WHERE `group_id`='$clanID' ORDER BY `power` ASC;";
			$findRanks = $conn->query($findRanksSQL);
			while($rankRow = $findRanks->fetch_assoc()) {
				$rankPower = $rankRow['power'];
				if($rankPower <= $currentRank['power']) {
					$newName = mysqli_real_escape_string($conn,$_POST['rank'.$rankPower]);
					if(isset($_POST['perm_ranks'.$rankPower])) {$permRanks = 'yes';} else {$permRanks = 'no';}
					if(isset($_POST['perm_posts'.$rankPower])) {$permPosts = 'yes';} else {$permPosts = 'no';}
					if(isset($_POST['perm_members'.$rankPower])) {$permMembers = 'yes';} else {$permMembers = 'no';}
					
					$rankNameSQL = "UPDATE `clans_ranks` SET `name`='$newName',`perm_ranks`='$permRanks',`perm_posts`='$permPosts',`perm_members`='$permMembers' WHERE `group_id`='$clanID' AND `power`='$rankPower'";
					$rankName = $conn->query($rankNameSQL);
				} else {
					$error[] = "Cannot edit ranks of higher power";
				}
			}
			
			//change rank values
			$findRanksSQL = "SELECT * FROM `clans_ranks` WHERE `group_id`='$clanID' ORDER BY `power` ASC;";
			$findRanks = $conn->query($findRanksSQL);
			while($rankRow = $findRanks->fetch_assoc()) {
				$rankPower = $rankRow['power'];
				$newPower = mysqli_real_escape_string($conn,$_POST['power'.$rankPower]);
				
				//check if rank already exists
				$checkSQL = "SELECT * FROM `clans_ranks` WHERE `power`='$newPower' AND `group_id`='$clanID'";
				$check = $conn->query($checkSQL);
				
				//check if the power is greater than their own
				if($check->num_rows <= 0 && $newPower < $currentRank['power']) {
					$newRankPowerSQL = "UPDATE `clans_ranks` SET `power`='$newPower' WHERE `group_id`='$clanID' AND `power`='$rankPower'";
					$newRankPower = $conn->query($newRankPowerSQL);
					
					//update the users who are already in this rank
					$updateUsersSQL = "UPDATE `clans_members` SET `rank`='$newPower' WHERE `rank`='$rankPower' AND `group_id`='$clanID'";
					$updateUsers = $conn->query($updateUsersSQL);
					header("Location: edit?id=".$clanID);
				}
			}
		}
	}
	//mess up ends here
	
	if(isset($_POST['rankNew']) && ($currentRank['perm_ranks'] == 'yes')) {
		$currentUserSQL = "SELECT * FROM `beta_users` WHERE `id`='$userID'";
		$currentUser = $conn->query($currentUserSQL);
		$currentRow = $currentUser->fetch_assoc();
	
		if($currentRow['bucks'] >= 4 && !empty($_POST['power']) && !empty($_POST['rank'])) {
			$newPower = mysqli_real_escape_string($conn,$_POST['power']);
			$newRank = mysqli_real_escape_string($conn,$_POST['rank']);
			
			//if the power of this rank is less than their own
			if($currentRank['power'] > $newPower) {
			
				//check if rank already exists
				$checkSQL = "SELECT * FROM `clans_ranks` WHERE `power`='$newPower' AND `group_id`='$clanID'";
				$check = $conn->query($checkSQL);
				
				if($check->num_rows == 0) {
					$insertSQL = "INSERT INTO `clans_ranks` (`id`,`group_id`,`power`,`name`,`perm_ranks`,`perm_posts`,`perm_members`) VALUES (NULL,'$clanID','$newPower','$newRank','no','no','no')";
					$insert = $conn->query($insertSQL);
					
					$newBucks = $currentRow['bucks']-4;
					$newBucksSQL = "UPDATE `beta_users` SET `bucks`='$newBucks' WHERE `id`='$userID'";
					$buy = $conn->query($newBucksSQL);
					
					header("Location: edit?id=".$clanID);
				} else {
					$error[] = "Rank already exists";
				}
			} else {
				$error[] = "Power too high";
			}
		}
	}
	
	if(isset($_POST['newImage'])) {
		if(isset($_FILES['image'])) {
			$imgName = $_FILES['image']['name'];
			$imgSize = $_FILES['image']['size'];
			$imgTmp = $_FILES['image']['tmp_name'];
			$imgType = $_FILES['image']['type'];
			$isImage = getimagesize($imgTmp);
			
			if($isImage !== false) {
				if($imgSize < 2097152) {
					$approvedSQL = "UPDATE `clans` SET `approved`='no' WHERE `id`='$clanID'";
					$approved = $conn->query($approvedSQL);
					if($approved) {
						move_uploaded_file($imgTmp,"../../storage_subdomain/images/clans/".$clanID.".png");
					}
				} else {
					echo 'File size must be smaller than 2MB';
				}
			} else {
				echo "File must be an image!";
			}
		} else {
			echo "You did not upload a tshirt!";
		}
	}
?>

<!DOCTYPE html>
	<head>
		<title>Edit Clan - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<h3><?php echo $clanRow['name']; ?></h3>
				<form action="" method="POST" style="margin:10px;" enctype="multipart/form-data">
					<h4>Image:</h4>
					<img style="width:200px;height:200px;" src="http://storage.brick-hill.com/images/clans/<?php echo $clanID; ?>.png">
					<input type="file" name="image"><br>
					<input type="submit" name="newImage">
				</form>
				
				<form action="" method="POST" style="margin:10px;">
					<h4>Description:</h4>
					<textarea name="description" style="width:500px;height:250px;"><?php echo $clanRow['description']; ?></textarea><br>
					<input type="submit" name="newDesc">
				</form>
			</div>
			<div id="box" style="margin-top:10px;padding:10px;">
				<?php
				if($currentRank['perm_ranks'] == 'yes') {
				?>
				<div style="text-align:center">
					<div style="text-align:left;">
						<h4>Members</h4>
						<select onchange="getRank(0, this.value)">
							<?php
								$sqlRanks = "SELECT * FROM `clans_ranks` WHERE `group_id`='$clanID' ORDER BY `power` ASC;";
								$rankResult = $conn->query($sqlRanks);
								while($rankRow = $rankResult->fetch_assoc())
								{
									echo '<option value='.$rankRow['power'].'>'.$rankRow['name'].'</option>';
								}
							?>
						</select>
					</div>
					<div id="members"></div>
				</div>
			</div>
			<div id="box" style="margin-top:10px;">
				<div style="padding:10px;">
					<h4>Ranks</h4>
				</div>
				<div id="subsect" style="padding:10px;">
					<h5>Manage</h5>
					<div class="label" style="width:130px;display:inline-block;">Rank Power</div>
					<div class="label" style="width:130px;display:inline-block;">Rank Name</div>
					<div class="label" style="width:20px;display:inline-block;"><i class="fa fa-info-circle" title="Allows users to create and change ranks"></i></div>
					<div class="label" style="width:20px;display:inline-block;"><i class="fa fa-info-circle" title="Allows users to moderate the wall"></i></div>
					<div class="label" style="width:20px;display:inline-block;"><i class="fa fa-info-circle" title="Allows users to change members' ranks"></i></div>
					<form action="" method="POST">
					<?php
						$findRanksSQL = "SELECT * FROM `clans_ranks` WHERE `group_id`='$clanID' ORDER BY `power` ASC;";
						$findRanks = $conn->query($findRanksSQL);
						while($rankRow = $findRanks->fetch_assoc()) {
							echo '<tr>';
							if($rankRow['perm_ranks'] == 'yes') {$perm_ranks = 1;} else {$perm_ranks = 0;}
							if($rankRow['perm_posts'] == 'yes') {$perm_posts = 1;} else {$perm_posts = 0;}
							if($rankRow['perm_members'] == 'yes') {$perm_members = 1;} else {$perm_members = 0;}
							echo '<input name="power'.$rankRow['power'].'" value="'.$rankRow['power'].'">
							      <input name="rank'.$rankRow['power'].'" value="'.$rankRow['name'].'">
							      <input type="checkbox" name="perm_ranks'.$rankRow['power'].'" '.str_repeat("checked",$perm_ranks).'>
							      <input type="checkbox" name="perm_posts'.$rankRow['power'].'" '.str_repeat("checked",$perm_posts).'>
							      <input type="checkbox" name="perm_members'.$rankRow['power'].'" '.str_repeat("checked",$perm_members).'>
							      <br>';
						}
					?>
						<input type="submit" name="rankName">
					</form>
				</div>
				<div id="subsect" style="padding:10px;">
					<h5>New Rank</h5>
					<form action="" method="POST">
						<input name="power" placeholder="Power">
						<input name="rank" placeholder="Name"><br>
						<span style="color:green;font-size:12px;">This will cost <i class="fa fa-money"></i>6</span><br>
						<input type="submit" name="rankNew">
					</form>
				</div>
				
				<?php
				}
				?>
			</div>
		</div>
		<script>
			window.onload = function() {
				getRank(0,1);
			}
			
			function getRank(page, rank) {
				$("#members").load("http://www.brick-hill.com/clans/edit_members?id=<?php echo $clanID; ?>&rank="+rank+"&page="+page);
			}
		</script>
	<?php
		include("../SiT_3/footer.php");
	?>
	</body>
</html>