<?php
	include('../../SiT_3/header.php');
	include('../../SiT_3/config.php');
	include('../../SiT_3/PHP/helper.php');
	
	if(!$loggedIn) {header("Location: index"); die();}
	
	$error = array();
	
	$createdSQL = "SELECT * FROM `clans` WHERE `owner_id` = '$currentUserID'";
	$created = $conn->query($createdSQL);
	if($created->num_rows >= $membershipRow['create_clans']) {
		$error[] = "You cannot create any more clans";
	}
	
	$clansSQL = "SELECT * FROM `clans_members` WHERE `user_id` = '$currentUserID' AND `status`='in'";
	$clans = $conn->query($clansSQL);
	if($clans->num_rows >= $membershipRow['join_clans']) {
		$error[] = "You cannot create any more clans";
	}
	
	if(isset($_POST['submit'])) {
		if(isset($_FILES['image'])) {
			$imgName = $_FILES['image']['name'];
			$imgSize = $_FILES['image']['size'];
			$imgTmp = $_FILES['image']['tmp_name'];
			$imgType = $_FILES['image']['type'];
			$isImage = getimagesize($imgTmp);
			
			if($isImage !== false) {
				if($imgSize < 2097152) {
					if(isset($_POST['name'])) {
						$name = mysqli_real_escape_string($conn,$_POST['name']);
						$nameSQL = "SELECT * FROM `clans` WHERE `name` LIKE '$name'";
						$nameExists = $conn->query($nameSQL);
						if($nameExists->num_rows == 0) {
							if(isset($_POST['prefix'])) {
								if($userRow->{'bucks'} >= 25) {
									$prefix = mysqli_real_escape_string($conn,$_POST['prefix']);
									if(strlen($prefix) >= 3 and strlen($prefix) <= 4) {
										if(ctype_alnum($prefix)) {
											if(isset($_POST['description'])) {
												$desc = mysqli_real_escape_string($conn,$_POST['description']);
											} else {$desc = NULL;}
										
											$userID = $_SESSION['id'];
											
											$clanSQL = "INSERT INTO `clans` (`id`,`owner_id`,`name`,`tag`,`description`,`members`) VALUES (NULL ,'$userID','$name','$prefix','$desc','1')";
											$clan = $conn->query($clanSQL);
											$clanID = $conn->insert_id;
											
											$newMoney = $userRow->{'bucks'}-25;
											$newMoneySQL = "UPDATE `beta_users` SET `bucks`='$newMoney' WHERE `id`='$userID'";
											$newMoneyQ = $conn->query($newMoneySQL);
											
											$memberSQL = "INSERT INTO `clans_members` (`id`,`group_id`,`user_id`,`rank`,`status`) VALUES (NULL ,'$clanID','$userID','100','in')";
											$member = $conn->query($memberSQL);
											
											///ADD RANKS
											$addOwnerSQL = "INSERT INTO `clans_ranks` (`id`,`group_id`,`power`,`name`,`perm_ranks`,`perm_posts`,`perm_members`) VALUES (NULL ,'$clanID','100','Owner','yes','yes','yes')";
											$addOwner = $conn->query($addOwnerSQL);
											
											$addModeratorSQL = "INSERT INTO `clans_ranks` (`id`,`group_id`,`power`,`name`,`perm_ranks`,`perm_posts`,`perm_members`) VALUES (NULL ,'$clanID','75','Moderator','no','yes','no')";
											$addModerator = $conn->query($addModeratorSQL);
											
											$addMemberSQL = "INSERT INTO `clans_ranks` (`id`,`group_id`,`power`,`name`,`perm_ranks`,`perm_posts`,`perm_members`) VALUES (NULL ,'$clanID','1','Member','no','no','no')";
											$addMember = $conn->query($addMemberSQL);
											
											move_uploaded_file($imgTmp,"../../../storage_subdomain/images/clans/".$clanID.".png");
											
											header("location: /clan?id=".$clanID);
										} else {
											$error[] = 'Your prefix must contain only alphanumeric characters';
										}
									} else {
										$error[] = 'Your clan prefix must be between 3 and 4 characters.';
									}
								} else {
									$error[] = 'Insufficient bucks!';
								}
							} else {
								$error[] = 'Your clan needs a prefix!';
							}
						} else {
							$error[] = 'Name taken!';
						}
					} else {
						$error[] = 'Your clan needs a name!';
					}
				} else {
				$error[] = 'File size must be smaller than 2MB';
			}
		} else {
			$error[] = "File must be an image!";
		}
	} else {
		$error[] = "You did not upload a tshirt!";
	}
	}
?>

<!DOCTYPE html>
	<head>
		<title>New Clan - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<h2>Create Clan</h2>
				<?php
				if(!empty($error)) {
					echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
					foreach($error as $errno) {
						echo $errno."<br>";
					} 
					echo '</div>';
				}
				?>
				<form style="margin:10px;" action="" method="POST" enctype="multipart/form-data">
					<input type="text" name="prefix" style="font-size:14px;padding:4px;margin-bottom:10px;width:40px;" placeholder="Tag">
					&nbsp;<input type="text" name="name" style="font-size:14px;padding:4px;margin-bottom:10px;" placeholder="Name"><br>
					Image: <input type="file" name="image" style="margin-bottom:10px;"><br>
					<textarea name="description" placeholder="Description" style="width:320px;height:100px;margin-bottom:10px;"></textarea><br>
					<span style="color:green;font-size:12px;">This will cost <i class="fa fa-money"></i>25</span><br>
					<input type="submit" name="submit">
				</form>
			</div>
		</div>
	</body>
</html>

<?php
	include("../../SiT_3/footer.php");
?>