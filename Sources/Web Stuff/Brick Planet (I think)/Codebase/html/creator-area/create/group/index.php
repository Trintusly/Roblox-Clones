<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	switch ($myU->VIP) {
		case 0:
			$Limit = 5;
			break;
		case 1:
			$Limit = 15;
			break;
		case 2:
			$Limit = 30;
			break;
		case 3:
			$Limit = 50;
			break;
	}
	
	if (isset($_POST['name']) && isset($_POST['description']) && isset($_FILES['logo']['name'])) {
		
		$Name = htmlentities(strip_tags(trim(preg_replace('/\s+/',' ', $_POST['name']))));
		$Description = htmlentities(strip_tags($_POST['description']));
		
		if (strlen($Name) < 3 || strlen($Name) > 60) {
			
			$errorMessage = 'Your group name must be between 3 and 60 characters.';
			
		} else if ($myU->CurrencyCoins < 5) {
			
			$errorMessage = 'You need <font class="coins-text strong">'.(5 - $myU->CurrencyCoins).'</font> more Bits to create a group.';
			
		} else if (!preg_match('/^[a-z0-9 .\-!,\':;<>?\[\]()\+=\/]+$/i', $Name)) {
			
			$errorMessage = 'Your group can not contain characters that are not allowed.';
			
		} else if (isProfanity($Name) == 1) {
			
			$errorMessage = 'Your group name has triggered our profanity filter. Please correct and try again.';
			
		} else if (isProfanity($Description) == 1) {
			
			$errorMessage = 'Your group description has triggered our profanity filter. Please correct and try again.';
			
		} else if (empty($_FILES['logo']['name'])) {
			
			$errorMessage = 'A group logo is required.';
			
		} else if (exif_imagetype($_FILES['logo']['tmp_name']) != 2 && exif_imagetype($_FILES['logo']['tmp_name']) != 3) {
			
			$errorMessage = 'Invalid group logo, the file is invalid.';
			
		} else if (!getimagesize($_FILES['logo']['tmp_name'])) {
			
			$errorMessage = 'Invalid group logo, the file is invalid.';
			
		} else {
			
			$CountGroupName = $db->prepare("SELECT COUNT(*) FROM UserGroup WHERE Name = ?");
			$CountGroupName->bindValue(1, $Name, PDO::PARAM_STR);
			$CountGroupName->execute();
			
			if ($CountGroupName->fetchColumn() > 0) {
				
				$errorMessage = 'This group name is not available.';
				
			} else {
			
				$FileName = uniqid(md5(microtime()));
				
				require $_SERVER['DOCUMENT_ROOT'].'/../private/class.upload.php';
				
				$modify_file = new Upload($_FILES['logo']);
				
				if ($modify_file->uploaded) {
					
					$modify_file->image_resize = true;
					$modify_file->image_x = 512;
					$modify_file->image_ratio_x = true;
					$modify_file->image_y = 512;
					$modify_file->file_overwrite = true;
					$modify_file->image_convert = 'png';
					
					$modify_file->Process('/var/www/cdn/');
				
					if ($modify_file->processed) {
						
						$checksum = checksumImage('/var/www/cdn/'.$modify_file->file_dst_name, $FileName.'.png');
						
						if ($checksum == 0) {
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
						
						$SEOName = str_replace('/', '--', $Name);
						$SEOName = str_replace(' ', '-', $SEOName);
						
						$Insert = $db->prepare("INSERT INTO UserGroup (Name, SEOName, Description, OwnerID, TimeCreate, LogoImage) VALUES(?, ?, ?, ".$myU->ID.", ".time().", ?)");
						$Insert->bindValue(1, $Name, PDO::PARAM_STR);
						$Insert->bindValue(2, $SEOName, PDO::PARAM_STR);
						$Insert->bindValue(3, $Description, PDO::PARAM_STR);
						$Insert->bindValue(4, $BackendFile, PDO::PARAM_STR);
						$Insert->execute();
						
						$cache->delete($myU->ID.'Cache_Groups');
						
						$ID = $db->lastInsertId();
						
						$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
						$InsertUserActionLog->bindValue(1, 'Created a group (Group ID: '.$ID.')', PDO::PARAM_STR);
						$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
						$InsertUserActionLog->execute();
						
						if (isset($JustRender)) {
							renderItem($ID);
						}
						
						header("Location: ".$serverName."/groups/".$db->lastInsertId()."/".str_replace(' ', '-', $Name)."/");
						die;
						
						
					} else {
					
						$errorMessage = 'An unexpected error has occurred, please try again.';
					
					}
					
					
				} else {
					
					$errorMessage = 'An unexpected error has occurred, please try again.';
					
				}
			
			}
			
		}
		
	}
	
	echo '
	<script>
	document.title = "Create Group - Brick Create";
	function uploadLogo(file) {
		document.getElementById("new-input-text").innerHTML = "<div class=\"push-15\"></div>" + file.files[0].name;
	}
	</script>
	<div class="grid-x grid-margin-x">
		<div class="large-8 large-offset-2 cell">
			';
			
			if (isset($errorMessage)) {
				
				echo '<div class="error-message">'.$errorMessage.'</div>';
				
			}
			
			echo '
			<h4>Create a new group</h4>
			<div class="container border-r md-padding">
				<form action="" method="POST" enctype="multipart/form-data">
				';
				
				if ($myU->NumGroups >= $Limit) {
					
					echo 'We\'re sorry, you are only allowed to join/create up to <strong>'.$Limit.'</strong> groups.<br />Please <a href="'.$serverName.'/upgrade/">upgrade your account</a> to gain more slots.';
					
				} else {
				
					echo '
					<input type="text" class="normal-input" name="name" placeholder="Name">
					<div class="push-15"></div>
					<textarea class="normal-input" name="description" placeholder="Description" style="height:125px;"></textarea>
					<div class="push-15"></div>
					<input type="file" name="logo" id="logo" class="new-input-file" onchange="uploadLogo(this)">
					<label for="logo" class="new-file">
						<i class="material-icons">add</i>
						<span>Choose a logo...</span>
					</label>
					<div id="new-input-text"></div>
					<div class="push-15"></div>
					Creating a group will cost <font class="coins-text">5 Bits</font>
					';
				
				}
				
				echo '
			</div>
			';
			
			if ($myU->NumGroups < $Limit) {
			
				echo '
				<div class="push-25"></div>
				<input type="submit" class="button button-green" value="Create">
				';
			
			}
			
			echo '
			</form>
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");