<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	$getItem = $db->prepare("SELECT Item.ID, Item.Name, Item.Description, Item.CreatorID, Item.CreatorType, Item.Cost, Item.SaleActive, Item.BackendFile, Item.PreviewImage, COUNT(UserInventory.ID) AS CheckCopy, (CASE Item.CreatorType WHEN 0 THEN NULL WHEN 1 THEN (SELECT GROUP_CONCAT(DISTINCT UserGroupRank.PermissionGroupStore, '%', UserGroup.Name) FROM UserGroupRank JOIN UserGroupMember ON UserGroupRank.Rank = UserGroupMember.Rank JOIN UserGroup ON UserGroup.ID = UserGroupMember.GroupID WHERE UserGroupMember.GroupID = Item.CreatorID AND UserGroupMember.UserID = ".$myU->ID." GROUP BY UserGroupMember.GroupID) END) AS GroupPermission FROM Item JOIN UserInventory ON Item.ID = UserInventory.ItemID WHERE Item.ID = ? AND Item.PublicView = 1 AND UserInventory.UserID = ".$myU->ID."");
	$getItem->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getItem->execute();
	$gI = $getItem->fetch(PDO::FETCH_OBJ);
	
	$GroupPermission = explode('%', $gI->GroupPermission);
	$GroupName = $GroupPermission[1];
	$gI->GroupPermission = $GroupPermission[0];
	
	if ($getItem->rowCount() == 0) {
		
		header("Location: ".$serverName."/store/");
		die;
		
	} else {
		
		if ($gI->CreatorType == 0 && ($gI->CreatorID != $myU->ID || $gI->CheckCopy == 0) || $gI->CreatorType == 1 && ($gI->GroupPermission == 0 || $gI->GroupPermission == NULL)) {
			
			header("Location: ".$serverName."/store/");
			die;
			
		}
		
		if (isset($_POST['submit']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
			
			$_POST['on_sale'] = ($_POST['on_sale'] != 0 && $_POST['on_sale'] != 1) ? $gI->SaleActive : $_POST['on_sale'];
			$_POST['price'] = (!is_numeric($_POST['price']) || $_POST['price'] < 1) ? $gI->Cost : $_POST['price'];

			if ($_POST['name'] != $gI->Name) {

				if (strlen($_POST['name']) < 3 || strlen($_POST['name']) > 70) {
					
					$errorMessage = 'Your item name must be between 3 and 70 characters.';
					
				} else if (isProfanity($_POST['name']) == 1) {
					
					$errorMessage = 'One or more words in your item name has triggered our profanity filter. Please update and try again.';
					
				} else {
			
					$_POST['name'] = htmlentities(strip_tags($_POST['name']));
					
					$update = $db->prepare("UPDATE Item SET Name = ? WHERE ID = ".$gI->ID."");
					$update->bindValue(1, $_POST['name'], PDO::PARAM_STR);
					$update->execute();
				
				}
				
			}
			
			if ($_POST['description'] != $gI->Description) {
				
				if (strlen($_POST['description']) > 1024) {
							
					$errorMessage = 'Your item name must be can only be up to 1,024 characters.';
							
				} else if (isProfanity($_POST['description']) == 1) {
					
					$errorMessage = 'One or more words in your item description has triggered our profanity filter. Please update and try again.';
					
				} else {
				
					$_POST['description'] = htmlentities(strip_tags($_POST['description']));
					
					$update = $db->prepare("UPDATE Item SET Description = ? WHERE ID = ".$gI->ID."");
					$update->bindValue(1, $_POST['description'], PDO::PARAM_STR);
					$update->execute();
				
				}
				
			}
			
			if ($_POST['on_sale'] != $gI->SaleActive) {
				
				$update = $db->prepare("UPDATE Item SET SaleActive = ? WHERE ID = ".$gI->ID."");
				$update->bindValue(1, $_POST['on_sale'], PDO::PARAM_INT);
				$update->execute();
				
			}
			
			if ($_POST['price'] != $gI->Cost) {
				
				$update = $db->prepare("UPDATE Item SET Cost = ? WHERE ID = ".$gI->ID."");
				$update->bindValue(1, $_POST['price'], PDO::PARAM_INT);
				$update->execute();
				
			}
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Edited item (Item ID: '.$gI->ID.')', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();
			
			header("Location: ".$serverName."/store/edit/".$gI->ID."/");
			die;
			
		}
		
		if (isset($_POST['delete_item']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gI->GroupPermission != 1) {
			
			$Delete = $db->prepare("DELETE FROM UserInventory WHERE UserID = ".$myU->ID." AND ItemID = ".$gI->ID."");
			$Delete->execute();
			
			$Update = $db->prepare("UPDATE Item SET SaleActive = 0 WHERE ID = ".$gI->ID."");
			$Update->execute();
			
			header("Location: ".$serverName."/store/");
			die;
			
		}
		
		echo '
		<script>document.title = "Edit Item - Brick Planet";</script>
		<div class="grid-x grid-margin-x align-middle">
			<div class="auto cell no-margin">
				<h4>Edit Item <a href="'.$serverName.'/store/view/'.$gI->ID.'/" style="color:#e3e3e3;"><strong>'.$gI->Name.'</strong></a></h4>
			</div>
			<div class="shrink cell right no-margin">
				';
				
				if ($gI->GroupPermission != 1) {
					
					echo '
					<a href="'.$serverName.'/store/view/'.$gI->ID.'/" class="button button-grey" style="padding: 8px 15px;font-size:14px;line-height:1.25;">Return to Item</a>
					';
					
				} else if ($gI->GroupPermission == 1) {
					
					echo '
					<a href="'.$serverName.'/groups/'.$gI->CreatorID.'/'.str_replace(' ', '-', $GroupName).'/" class="button button-grey" style="padding: 8px 15px;font-size:14px;line-height:1.25;">Return to Group</a>
					';
					
				}
				
				echo '
			</div>
		</div>
		<div class="push-10"></div>
		';
		
		if (isset($errorMessage)) {
			
			echo '<div class="error-message">'.$errorMessage.'</div>';
			
		}
		
		echo '
		<div class="container border-r md-padding">
			<div class="grid-x grid-margin-x align-middle">
				<div class="large-3 cell text-center">
					<a href="'.$serverName.'/store/view/'.$gI->ID.'/"><img src="'.$cdnName . $gI->PreviewImage.'"></a>
					<div class="push-25"></div>
					<a href="'.$cdnName . $gI->BackendFile.'" target="_blank" class="button button-grey" style="display:inline-block;">View Template</a>
				</div>
				<div class="large-9 cell">
					<form action="" method="POST">
						<label for="name"><strong>Name</label>
						<input maxlength="70" type="text" name="name" id="name" class="normal-input" value="'.$gI->Name.'">
						<div class="push-25"></div>
						<label for="description"><strong>Description</label>
						<textarea maxlength="1024" name="description" id="description" class="normal-input">'.$gI->Description.'</textarea>
						<div class="push-25"></div>
						<label for="on_sale"><strong>On Sale</label>
						<select name="on_sale" id="on_sale" class="normal-input">
							<option value="1"'; if ($gI->SaleActive == 1) { echo ' selected'; } echo '>Yes</option>
							<option value="0"'; if ($gI->SaleActive == 0) { echo ' selected'; } echo '>No</option>
						</select>
						<div class="push-25"></div>
						<label for="price"><strong>Price</label>
						<input type="text" name="price" id="price" class="normal-input" value="'.$gI->Cost.'">
						<div class="push-25"></div>
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						<div class="grid-x grid-margin-x">
							<div class="auto cell no-margin">
								<input type="submit" name="submit" value="Update" class="button button-blue">
							</div>
							';
							
							if ($gI-GroupPermission != 1) {
							
								echo '
								<div class="shrink cell no-margin right">
									<input type="button" class="button button-red right" value="Delete" data-open="DeleteModal">
								</div>
								';
							
							}
							
							echo '
						</div>
					</form>
				</div>
			</div>
		</div>
		';
		
		if ($gI->GroupPermission != 1) {
		
			echo '
			<div class="reveal item-modal" id="DeleteModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
				<form action="" method="POST">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="modal-title">Delete Item</div>
						</div>
						<div class="shrink cell no-margin">
							<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
					<div class="push-15"></div>
					<div>Are you sure you wish to delete this item? This action can not be undone.</div>
					<div class="push-25"></div>
					<div align="center">
						<input type="button" data-close class="button button-grey store-button inline-block" value="No, go back">
						<input type="submit" class="button button-red store-button inline-block" name="delete_item" value="Yes, delete">
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
					</div>
				</form>
			</div>
			';
		
		}
		
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");