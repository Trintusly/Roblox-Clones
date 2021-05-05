<?php

require("../shop/shop.php");

class avatar extends shop {

	public $columnArray = [
		"faces" => "face",
		"shirts" => "shirt",
		"pants" => "pants",
		"hats" => "hat",
		"tools" => "tool",
		"tshirts" => "tshirt"
	];

	public function ownsItem ($userId, $itemId) {
		return ($this->query("SELECT COUNT(*) as owns FROM inventory WHERE user_id = ? AND item_id = ?", [$userId, $itemId])->fetchAll(PDO::FETCH_COLUMN)[0] == "0") ? false : true ;
	}

	public function getAvatarRow($userId) {
		return $this->query("SELECT * FROM avatar WHERE user_id = ?", [$userId])->fetch();
	}

	public function isWearing ( $type, $id, $userId ) {
		switch ($type) {
			case "hat":
				return ($this->query("SELECT COUNT(*) as wearing FROM avatar WHERE user_id = ? AND (hat1 = ? OR hat2 = ? OR hat3 = ?)", [$userId,$id,$id,$id])->fetchAll(PDO::FETCH_COLUMN)[0] == "0") ? false : true;
				break;
			default:
				$column = $type;
				return ($this->query("SELECT COUNT(*) as wearing FROM avatar WHERE $column = ? AND user_id = ?", [$id, $userId])->fetchAll(PDO::FETCH_COLUMN)[0] == "0") ? false : true;
				break;
		}
	}

	public function getHatColumn  ( $userId, $itemId ) {
		$hats = $this->query("SELECT hat1,hat2,hat3 FROM avatar WHERE user_id = ?", [$userId])->fetch(PDO::FETCH_ASSOC);
		return array_search($itemId, $hats);
	}

	public function equip ( $userId, $itemId ) {
		if ($this->ownsItem($userId, $itemId) && $this->user_exists($userId)) {

			$type = $this->columnArray[$this->cat2dir($this->getItem($itemId)["category"])];

			if (!$this->isWearing($type,$itemId, $userId )) {
			switch ($type) {
				case "hat":
					$row = $this->getAvatarRow($userId);
						if ($row["hat1"] == "0") {
							$column = "hat1";
						} else if ($row["hat2"] == "0") {
							$column = "hat2";
						} else {
							$column = "hat3";
						}
					break;
				default:
					$column = $type;
					break;
			}

			$update = $this->update_("avatar", [$column => $itemId], ["user_id" => $userId]);
			return ($update) ? true : false;
			}
			else {
				throw new Exception("You are already wearing this item");
			}
		} else {
			throw new Exception("User doens't own item");
		}
	}

	public function itemType($item) {
		if ($this->itemExists($item)) {
			return $this->columnArray[$this->cat2dir($this->getItem($item)["category"])];
		}
	}

	public function unequip ( $userId, $itemId ) {
		if ($this->user_exists($userId) && $this->itemExists($itemId)) {
			//$item = $this->getItem($itemId);
			$type =$this->itemType($itemId);
			$column = ($type == "hat") ? $this->getHatColumn($userId,$itemId) : $type;
			if ($column) {
				try {
					//echo $column;
				$update = $this->update_("avatar", [$column => 0
				], ["user_id" => $userId]);
				} catch (Exception $e) {
					return $e;
				}
			} else {
				throw new Exception("User is not wearing this item");
			}
		} else {
			throw new Exception("Item doesn't exist");
		}
	}

	public function getInventory($userId, $showWearing, $category = false, $query = false, $showUnapproved) {
		$values = [$userId];
		$sql = "SELECT i.item_id, i.user_id, s.name FROM `inventory` as i, `items` as s WHERE i.item_id = s.id AND i.user_id = ? AND own = 1";

		if (!$showUnapproved) {
			$sql .= " AND s.verified = 1";
		}

		if ($category) {
			$sql .= " AND s.category = ?";
			$values[] = $category;
		}

		if ($query) {
			$sql .= " AND s.name LIKE ?";
			$values[] = "%".$query."%";
		}

		$query = $this->query($sql, $values);
		if ($query) {
			if ($query->rowCount() > 0) {
				return $query->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		return false;
	}

	public function getWearing($userId) {
		if ($this->user_exists($userId)) {
			$query = $this->query("SELECT i.hat1,i.hat2,i.hat3,i.face,i.shirt,i.pants,i.head_color,i.torso_color,i.left_arm_color,i.right_arm_color,i.left_leg_color,i.right_leg_color,i.tshirt,i.tool FROM avatar as i WHERE user_id = ?", [$userId]);
			if ($query) {
				if ($query->rowCount() > 0) {
					return $query->fetch(PDO::FETCH_ASSOC);
				}
			}
		}
		return false;
	}

	public function changeColor ($userId, $limb, $hex) {

		$limbs = [
		"head",
		"torso",
		"right_arm",
		"left_arm",
		"right_leg",
		"left_leg"
		];

		//if (!empty(preg_match("/([a-fA-F0-9]{3}){1,2}\b/", $hex))) {
		if(ctype_xdigit($hex)) {
			if (in_array($limb,$limbs)) {

				$update = $this->update_("avatar", [ $limb . "_color" => $hex ], ["id" => $userId]);
				if ($update) {
					return true;
				}
				throw new Exception("Error updating");
			}
			throw new Exception("Invalid limb");
		}
		throw new Exception("Invalid hex color");

	}

}

$avatar = new avatar;

?>
