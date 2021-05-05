<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	if (!isset($_GET['id'])) {
		
		header("Location: ".$serverName."/groups/");
		die;
		
	}
	
	$getGroup = $db->prepare("SELECT UserGroup.ID, UserGroup.GroupCategory, UserGroup.Name, UserGroup.SEOName, UserGroup.Description, (CASE WHEN UserGroup.OwnerType = 0 THEN User.Username ELSE UG.Name END) AS OwnerName, UserGroup.OwnerID, UserGroup.OwnerType, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, UserGroup.CoinsVault, UserGroup.VaultDisplay, UserGroup.JoinType, UserGroup.NonMemberTab, UserGroup.MemberTab, UserGroup.MemberCount, UserGroup.WallCount, (SELECT CASE WHEN COUNT(*) > 0 THEN CONCAT(UserGroupMember.Rank, ':', UserGroupRank.PermissionViewWall, ':', UserGroupRank.PermissionPostWall, ':', UserGroupRank.PermissionModerateWall, ':', UserGroupRank.PermissionChangeRank, ':', UserGroupRank.PermissionKickUser, ':', UserGroupRank.PermissionInviteUser, ':', UserGroupRank.PermissionAcceptRequests, ':', UserGroupRank.PermissionAnnouncements, ':', UserGroupRank.PermissionEvents, ':', UserGroupRank.PermissionGroupFunds) ELSE 0 END FROM UserGroupMember JOIN UserGroupRank ON UserGroupMember.Rank = UserGroupRank.Rank WHERE UserGroupMember.GroupID = UserGroup.ID AND UserGroupMember.UserID = ".$myU->ID." AND UserGroupRank.GroupID = UserGroup.ID) AS IsMember, GROUP_CONCAT(UserGroupRank.Name, '%', UserGroupRank.Rank, '%', UserGroupRank.MemberCount, '%', UserGroupRank.PermissionViewWall, '%', UserGroupRank.PermissionPostWall, '%', UserGroupRank.PermissionModerateWall, '%', UserGroupRank.PermissionChangeRank, '%', UserGroupRank.PermissionKickUser, '%', UserGroupRank.PermissionInviteUser, '%', UserGroupRank.PermissionAcceptRequests, '%', UserGroupRank.PermissionAnnouncements, '%', UserGroupRank.PermissionEvents, '%', UserGroupRank.PermissionGroupFunds SEPARATOR '^') AS GroupRanks, UserGroup.StoreCount, UserGroup.JoinRequestCount, UserGroup.OutboundRequestCount, UserGroup.TotalEarningsCount, UserGroup.TotalEarningsRank, UserGroup.SalesCount, UserGroup.EarningsCount, (CASE UserGroup.OwnerType WHEN 0 THEN User.VIP WHEN 1 THEN (SELECT UV.VIP FROM User UV WHERE UV.ID = (SELECT User.ID FROM UserGroup AS UGG JOIN User ON UGG.OwnerID = User.ID WHERE UGG.ID = UserGroup.OwnerID)) END) AS VIP FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) JOIN UserGroupRank FORCE INDEX(UserGroupRank_GroupID_FK_idx) ON UserGroup.ID = UserGroupRank.GroupID WHERE UserGroup.ID = ?");
	$getGroup->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getGroup->execute();
	
	if ($getGroup->rowCount() == 0) {
		
		header("Location: ".$serverName."/groups/");
		die;
		
	}
	
	$gG = $getGroup->fetch(PDO::FETCH_OBJ);
	
	$TempGroupRanks = explode('^', $gG->GroupRanks);
	$GroupRanks = array();
	
	if ($gG->IsMember != 0) {
		$MemberData = explode(':', $gG->IsMember);
		$MemberRankNum = $MemberData[0];
		$gG->IsMember = 1;
	}
	
	foreach ($TempGroupRanks as $GroupRank) {
		$GroupRank = explode('%', $GroupRank);
		$GroupRanks[$GroupRank[1]] = array($GroupRank[0], $GroupRank[2], $GroupRank[3], $GroupRank[4], $GroupRank[5], $GroupRank[6], $GroupRank[7], $GroupRank[8], $GroupRank[9], $GroupRank[10], $GroupRank[11], $GroupRank[12]);
	}
	krsort($GroupRanks);
	
	if ($GroupRanks[$MemberRankNum][5] == 0) {
		
		header("Location: ".$serverName."/groups/".$gG->ID."/".str_replace(' ', '-', $gG->Name)."/");
		die;
		
	}
	
	if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['on_sale']) && isset($_FILES['image']['name'])) {
		
		if (strlen($_POST['name']) < 3 || strlen($_POST['name']) > 70) {
			
			$errorMessage = 'Your item name must be between 3 and 70 characters.';
			
		} else if (isProfanity($_POST['name']) == 1) {
			
			$errorMessage = 'One or more words in your item name has triggered our profanity filter. Please update and try again.';
			
		} else if (strlen($_POST['description']) > 1024) {
			
			$errorMessage = 'Your item name must be can only be up to 1,024 characters.';
			
		} else if (isProfanity($_POST['description']) == 1) {
			
			$errorMessage = 'One or more words in your item description has triggered our profanity filter. Please update and try again.';
			
		} else if (!is_numeric($_POST['price']) || $_POST['price'] < 1 || $_POST['price'] > 1000000) { 
			
			$errorMessage = 'Your item price must be between 1 and 1,000,000 Bits.';
		
		} else if (!is_numeric($_POST['on_sale']) || ($_POST['on_sale'] != 1 && $_POST['on_sale'] != 2)) {
			
			$errorMessage = 'Invalid on sale option, please try again.';
			
		} else if (!preg_match('/^[a-z0-9 .\-!,\':;<>?()\[\]+=\/]+$/i', $_POST['name'])) {
			
			$errorMessage = 'Your item name can not contain characters that are not allowed.';
			
		} else if (empty($_FILES['image']['name'])) {
			
			$errorMessage = 'A image template is required.';
			
		} else if (exif_imagetype($_FILES['image']['tmp_name']) != 2 && exif_imagetype($_FILES['image']['tmp_name']) != 3) {
			
			$errorMessage = 'Invalid image template, the file is invalid.';
			
		} else if (!getimagesize($_FILES['image']['tmp_name'])) {
			
			$errorMessage = 'Invalid image template, the file is invalid.';
			
		} else {
			
			$FileName = uniqid(md5(microtime()));
			
			require $_SERVER['DOCUMENT_ROOT'].'/../private/class.upload.php';
			
			$modify_file = new Upload($_FILES['image']);
			
			if ($modify_file->uploaded) {
				
				if ($modify_file->image_src_x != 887 && $modify_file->image_src_y != 887) {
					
					$error = 'We\'re sorry, this type of template is not allowed.';
					
				} else {
				
					$modify_file->image_resize = true;
					$modify_file->image_x = 887;
					$modify_file->image_ratio_x = true;
					$modify_file->image_y = 887;
					$modify_file->file_overwrite = true;
					$modify_file->image_convert = 'png';
					
					$modify_file->Process('/tmp/');
					
					if ($modify_file->processed) {
						
						$checksum = checksumImage('/tmp/'.$modify_file->file_dst_name, $FileName.'.png');
						
						if ($checksum == 0) {
							uploadAsset($FileName.'.png', '/tmp/'.$modify_file->file_dst_name);
							$PreviewImage = 'pending.png';
							$BackendFile = $FileName.'.png';
						}
						else {
							$checksum_split = explode(':DIVIDER:', $checksum);
							
							switch ($checksum_split[0]) {
								case 0:
									$PreviewImage = 'pending.png';
									$BackendFile = $checksum_split[1];
									break;
								case 1:
									$JustRender = true;
									$PreviewImage = 'pending.png';
									$BackendFile = $checksum_split[1];
									break;
								case 2:
									$PreviewImage = 'rejected.png';
									$BackendFile = $checksum_split[1];
									break;
							}
						}

						$Insert = $db->prepare("INSERT INTO Item (ItemType, Name, Description, CreatorID, CreatorType, TimeCreated, TimeUpdated, Cost, SaleActive, PreviewImage, BackendFile) VALUES(5, ?, ?, ".$gG->ID.", 1, ".time().", ".time().", ?, ?, '".$PreviewImage."', '".$BackendFile."')");
						$Insert->bindValue(1, $_POST['name'], PDO::PARAM_STR);
						$Insert->bindValue(2, $_POST['description'], PDO::PARAM_STR);
						$Insert->bindValue(3, $_POST['price'], PDO::PARAM_INT);
						$Insert->bindValue(4, $_POST['on_sale'], PDO::PARAM_INT);
						$Insert->execute();
						
						$ID = $db->lastInsertId();
						
						if (isset($JustRender)) {
							renderItem($ID);
						}
						
						header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
						die;
					
					} else {
					
						$errorMessage = 'An unexpected error has occurred, please try again.';
					
					}
				
				}
				
			} else {
				
				$errorMessage = 'An unexpected error has occurred, please try again.';
				
			}
		
		}
	}
	
	echo '
	<script>
	document.title = "Create Group Shirt - Brick Create";
	function uploadLogo(file) {
		document.getElementById("new-input-text").innerHTML = "<div class=\"push-15\"></div>" + file.files[0].name;
	}
	</script>
	<div class="grid-x grid-margin-x">
		<div class="large-12 cell">
			';
			
			if (isset($errorMessage)) {
				
				echo '<div class="error-message">'.$errorMessage.'</div>';
				
			}
			
			echo '
			<div class="grid-x grid-margin-x align-middle">
				<div class="auto cell no-margin">
					<h4>Create a new group shirt</h4>
				</div>
				<div class="shrink cell right no-margin">
					<a href="'.$serverName.'/groups/'.$gG->ID.'/'.str_replace(' ', '-', $gG->Name).'/" class="button button-grey" style="padding: 8px 15px;font-size:14px;line-height:1.25;">Return to Group</a>
				</div>
			</div>
			<div class="push-10"></div>
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="container border-r md-padding">
					<div class="grid-x grid-margin-x">
						<div class="large-7 cell">
							<input type="text" class="normal-input" name="name" placeholder="Name">
							<div class="push-15"></div>
							<textarea class="normal-input" name="description" placeholder="Description" style="height:125px;"></textarea>
							<div class="push-15"></div>
							<input type="text" class="normal-input" name="price" placeholder="Price (Bits)">
							<div class="push-15"></div>
							<select class="normal-input" name="on_sale">
								<option value="1" selected>On Sale</option>
								<option value="0">Off Sale</option>
							</select>
							<div class="push-15"></div>
							<input type="file" name="image" id="image" class="new-input-file" onchange="uploadLogo(this)">
							<label for="image" class="new-file">
								<i class="material-icons">add</i>
								<span>Choose an image...</span>
							</label>
							<div id="new-input-text"></div>
						</div>
						<div class="large-5 cell">
							<h5><strong>Template (click to enlarge)</strong></h5>
							<a href="'.$cdnName.'templates/ShirtTemplate.png" target="_blank"><img src="'.$cdnName.'templates/ShirtTemplate.png" style="width:100%;height:auto;"></a>
						</div>
					</div>
				</div>
				<div class="push-25"></div>
				<input type="submit" class="button button-green" value="Create">
			</form>
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
