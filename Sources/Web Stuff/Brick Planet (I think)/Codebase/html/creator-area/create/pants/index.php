<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireLogin();
	
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
			
			$errorMessage = 'Your item price must be between 1 and 1,000,000 Coins.';
		
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
					
					$errorMessage = 'We\'re sorry, this type of template is not allowed. It must be 887x887.';
					
				}
				
				else {
				
					$modify_file->image_resize = true;
					$modify_file->image_x = 887;
					$modify_file->image_ratio_x = true;
					$modify_file->image_y = 887;
					$modify_file->file_overwrite = true;
					$modify_file->image_convert = 'png';
					
					$modify_file->Process('/tmp/');
					
					if ($modify_file->processed) {
						
						$checksum = checksumImage('/tmp/'.$modify_file->file_dst_name, $FileName.'.png');
						$checksum_split = ($checksum != 0) ? explode(':DIVIDER:', $checksum) : NULL;
						
						$CountItem = $db->prepare("SELECT COUNT(*) FROM Item WHERE BackendFile = '".$checksum_split[1]."' AND Item.CreatorType = 0 AND Item.CreatorID = ".$myU->ID);
						$CountItem->execute();
						
						if ($CountItem->fetchColumn() > 0) {
							
							$errorMessage = 'We\'re sorry, you can not upload this asset template again.';
							
						} else {
						
							if ($checksum == 0) {
								uploadAsset($FileName.'.png', '/tmp/'.$modify_file->file_dst_name);
								$PreviewImage = 'pending.png';
								$BackendFile = $FileName.'.png';
							}
							else {
								
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

							$_POST['name'] = htmlentities(strip_tags($_POST['name']));
							$_POST['description'] = htmlentities(strip_tags($_POST['description']));
							
							$Insert = $db->prepare("INSERT INTO Item (ItemType, Name, Description, CreatorID, TimeCreated, TimeUpdated, Cost, SaleActive, PreviewImage, BackendFile) VALUES(6, ?, ?, ".$myU->ID.", ".time().", ".time().", ?, ?, '".$PreviewImage."', '".$BackendFile."')");
							$Insert->bindValue(1, $_POST['name'], PDO::PARAM_STR);
							$Insert->bindValue(2, $_POST['description'], PDO::PARAM_STR);
							$Insert->bindValue(3, $_POST['price'], PDO::PARAM_INT);
							$Insert->bindValue(4, $_POST['on_sale'], PDO::PARAM_INT);
							$Insert->execute();
							
							$ID = $db->lastInsertId();
							
							$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
							$InsertUserActionLog->bindValue(1, 'Created a pair of pants (Item ID: '.$ID.')', PDO::PARAM_STR);
							$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
							$InsertUserActionLog->execute();
							
							if (isset($JustRender)) {
								renderItem($ID);
							}
							
							header("Location: ".$serverName."/store/view/".$ID."/");
							die;
						
						}
					
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
	document.title = "Create Pants - Brick Create";
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
			<h4>Create new pants</h4>
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="container border-r md-padding">
					<div class="grid-x grid-margin-x">
						<div class="large-7 cell">
							<input type="text" class="normal-input" name="name" placeholder="Name">
							<div class="push-15"></div>
							<textarea class="normal-input" name="description" placeholder="Description" style="height:125px;"></textarea>
							<div class="push-15"></div>
							<input type="text" class="normal-input" name="price" placeholder="Price (bits)">
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
							<a href="'.$cdnName.'templates/PantsTemplate.png" target="_blank"><img src="'.$cdnName.'templates/PantsTemplate.png" style="width:100%;height:auto;"></a>
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