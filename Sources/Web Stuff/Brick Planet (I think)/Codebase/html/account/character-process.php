<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	requireLogin();
	
	if ($SiteSettings->AllowEditCharacter == 0) {

		die;

	}

	if (isset($_POST['action']) && $_POST['action'] == 'refresh') {

		$cache->delete($myU->ID);

		updateAvatar($myU->ID);

	}

	if (isset($_POST['action']) && isset($_POST['orientation']) && $_POST['action'] == 'orientation') {

		$Orientation = (!is_numeric($_POST['orientation']) && $_POST['orientation'] != 0 && $_POST['orientation'] != 1) ? $myU->AvatarOrientation : (int)$_POST['orientation'];

		if ($Orientation != $myU->AvatarOrientation) {

			$Update = $db->prepare("UPDATE User SET AvatarOrientation = ? WHERE ID = ".$myU->ID."");
			$Update->bindValue(1, $Orientation, PDO::PARAM_INT);
			$Update->execute();

			$cache->delete($myU->ID);

			updateAvatar($myU->ID);

		}

	}

	if (isset($_POST['action']) && $_POST['action'] == 'wear' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$verifyOwnership = $db->prepare("SELECT Item.ItemType, Item.BackendFile, (SELECT COUNT(*) FROM UserEquipped WHERE UserID = ".$myU->ID." AND InventoryID = ?) AS CheckWearing FROM Item WHERE ID = (SELECT ItemID FROM UserInventory WHERE ID = ? AND UserID = ".$myU->ID.") AND ItemType != 7 AND PreviewImage != 'pending.png' AND PreviewImage != 'rejected.png'");
		$verifyOwnership->bindValue(1, $_POST['id'], PDO::PARAM_INT);
		$verifyOwnership->bindValue(2, $_POST['id'], PDO::PARAM_INT);
		$verifyOwnership->execute();

		if ($verifyOwnership->rowCount() > 0) {

			$vO = $verifyOwnership->fetch(PDO::FETCH_OBJ);

			if ($vO->CheckWearing == 1) {
				die;
			}

			if ($vO->ItemType == 1) {

				if ($myU->NumEquippedHats >= 3) {

					$delete = $db->prepare("DELETE FROM UserEquipped WHERE UserID = ".$myU->ID." AND ItemType = 1 ORDER BY ID DESC LIMIT 1");
					$delete->execute();

				}

				$insert = $db->prepare("INSERT INTO UserEquipped (UserID, ItemType, InventoryID) VALUES(".$myU->ID.", 1, ?)");
				$insert->bindValue(1, $_POST['id'], PDO::PARAM_INT);
				$insert->execute();

				$update = 1;

			}

			else if ($vO->ItemType == 2) {

				$delete = $db->prepare("DELETE FROM UserEquipped WHERE UserID = ".$myU->ID." AND ItemType = 2");
				$delete->execute();

				$insert = $db->prepare("INSERT INTO UserEquipped (UserID, ItemType, InventoryID) VALUES(".$myU->ID.", 2, ?)");
				$insert->bindValue(1, $_POST['id'], PDO::PARAM_INT);
				$insert->execute();

				$update = 1;

			}

			else if ($vO->ItemType == 3) {

				$delete = $db->prepare("DELETE FROM UserEquipped WHERE UserID = ".$myU->ID." AND ItemType = 3");
				$delete->execute();

				$insert = $db->prepare("INSERT INTO UserEquipped (UserID, ItemType, InventoryID) VALUES(".$myU->ID.", 3, ?)");
				$insert->bindValue(1, $_POST['id'], PDO::PARAM_INT);
				$insert->execute();

				$update = 1;

			}

			else if ($vO->ItemType == 4) {

				$delete = $db->prepare("DELETE FROM UserEquipped WHERE UserID = ".$myU->ID." AND ItemType = 4");
				$delete->execute();

				$insert = $db->prepare("INSERT INTO UserEquipped (UserID, ItemType, InventoryID) VALUES(".$myU->ID.", 4, ?)");
				$insert->bindValue(1, $_POST['id'], PDO::PARAM_INT);
				$insert->execute();

				$update = 1;

			}

			else if ($vO->ItemType == 5) {

				$delete = $db->prepare("DELETE FROM UserEquipped WHERE UserID = ".$myU->ID." AND ItemType = 5");
				$delete->execute();

				$insert = $db->prepare("INSERT INTO UserEquipped (UserID, ItemType, InventoryID) VALUES(".$myU->ID.", 5, ?)");
				$insert->bindValue(1, $_POST['id'], PDO::PARAM_INT);
				$insert->execute();

				$update = 1;

			}

			else if ($vO->ItemType == 6) {

				$delete = $db->prepare("DELETE FROM UserEquipped WHERE UserID = ".$myU->ID." AND ItemType = 6");
				$delete->execute();

				$insert = $db->prepare("INSERT INTO UserEquipped (UserID, ItemType, InventoryID) VALUES(".$myU->ID.", 6, ?)");
				$insert->bindValue(1, $_POST['id'], PDO::PARAM_INT);
				$insert->execute();

				$update = 1;

			}

			if (isset($update)) {

				$cache->delete($myU->ID);

				updateAvatar($myU->ID);

			}

		}

		else {

			echo 'Something went wrong. Ty again.1';

		}

	}

	else if (isset($_POST['action']) && $_POST['action'] == 'remove' && isset($_POST['id']) && is_numeric($_POST['id'])) {

		$delete = $db->prepare("DELETE FROM UserEquipped WHERE UserID = ".$myU->ID." AND InventoryID = ?");
		$delete->bindValue(1, $_POST['id'], PDO::PARAM_INT);
		$delete->execute();

		if ($delete->rowCount() > 0) {

			$cache->delete($myU->ID);

			updateAvatar($myU->ID);

		} else {
			echo 'fail';
		}

	}

	else if (isset($_POST['action']) && $_POST['action'] == 'color' && isset($_POST['type']) && isset($_POST['hex'])) {

		$_POST['hex'] = strtoupper(str_replace('#', '', $_POST['hex']));

		$allowedTypes = array('head', 'leftarm', 'torso', 'rightarm', 'leftleg', 'rightleg');
		$allowedHex = array('FFE0BD' => '1','666666' => '2','CCCCCC' => '3','FFE0BD' => '4','FFCD94' => '5','EAC086' => '6','FFAD60' => '7','FFE39F' => '8','9C7248' => '9','926A2D' => '10','876127' => '11','7C501A' => '12','6F4F1D' => '13','000000' => '14','191919' => '15','323232' => '16','4C4C4C' => '17','666666' => '18','7F7F7F' => '19','999999' => '20','B2B2B2' => '21','CCCCCC' => '22','E5E5E5' => '23','FBE8B0' => '24','E1D98F' => '25','B5BA63' => '26','7F9847' => '27','40832B' => '28','0076B6' => '29','0E325B' => '30','7F6AB6' => '31','610059' => '32','9A003F' => '33','FF8D00' => '34','FF05C1' => '35','AB0000' => '36','FFADB9' => '37','FFBF00' => '38');

		if (in_array($_POST['type'], $allowedTypes) && array_key_exists($_POST['hex'], $allowedHex)) {

			$update = $db->prepare("UPDATE User SET Hex".$_POST['type']." = ".$allowedHex[$_POST['hex']]." WHERE ID = ".$myU->ID."");
			$update->execute();

			$cache->delete($myU->ID);

			updateAvatar($myU->ID);

		}

	}

	else {

		echo 'Something went wrong. Try again.';

	}
