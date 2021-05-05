<?php
//$session = false;
require("/var/www/html/site/bopimo.php");

class shop extends bopimo {

	/* Favorites */

	function getFavorites ($itemId) {
		$itemId = (int) $itemId;
		return $this->query("SELECT COUNT(*) as total FROM favorite WHERE item_id = ? AND active = 1", [$itemId])->fetchAll()[0]['total'];
	}

	function getFavorite ($itemId, $userId, bool $active = false) {
		$sql = ($active) ? "SELECT * FROM favorite WHERE item_id = ? AND user_id = ? AND active = 1" : "SELECT * FROM favorite WHERE item_id = ? AND user_id = ?";
		$favorite = $this->query($sql, [$itemId, $userId]);
		if ($favorite) {
			return $favorite->fetchAll();
		}
		return false;
	}

	function addFavorite ($itemId, $userId) {
		if ($this->getItem($itemId)) {
			if ($this->getFavorite($itemId, $userId, false)) {
				$this->update_("favorite", ["active" => "1"], ["user_id" => $userId, "item_id" => $itemId]);
			} else {
				$this->insert("favorite", ["user_id" => $userId, "item_id" => $itemId, "active" => 1]);
			}
		} else {
			throw new Exception("Invalid item");
		}

		return false;
	}

	function removeFavorite ($itemId, $userId) {

		if ($this->getFavorite($itemId, $userId, false)) {
			$this->update_("favorite", ["active" => "0"], ["user_id" => $userId, "item_id" => $itemId]);
			return true;
		}

		throw new Exception("Favorite not found");
	}
	
	/* Tradables */
	
	function getStock($itemId) {
		$item = $this->getItem($itemId);
		if ($this->isTradeable($itemId)) {
			$stock = $item['stock'];
			$sold = $this->getSold($itemId);
			$remaining = $stock - $sold;
			if ($sold > 0 && $stock == 0) {
				$remaining = 0;
			}
			return [
			'stock' => $stock,
			'sold' => $sold,
			'remaining' => $remaining,
			'text' => ($remaining == 0) ? "Sold Out" : $sold . "/" . $stock
			];
		}
		return 0;
	}
	
	/* Other Sellers */

	function getOtherSellers( $itemId, $page, $perPage = 5 ) {
		if ($this->isTradeable($itemId)) {
		$query = $this->query("SELECT * FROM item_other_sellers WHERE item_id = ? AND active = 1 ORDER BY price", [$itemId])->fetchAll();
			if ($query) {

				return $query;
			}
		}
		throw new Exception("Empty");
	}
	
	function makeTradeable($itemId) {
		$item = $this->getItem($itemId);
		if ($item['category'] == 1 || $item['category'] == 2 || $item['category'] == 3) {
			$this->updateItem($itemId, ["tradeable" => "1", "sale_type" => "1"]);
		}
	}
	
	function addOtherSeller ($itemId, $serial, $sellerId, $price) {

		if ($serial == 0) {
			throw new Exception("You cannot put your own item on sale.");
		}
		
		if (!$this->isTradeable($itemId)) {
			throw new Exception("This item is not a tradeable");
		}
		
		if (!$this->hasItem($itemId, $sellerId, $serial)) {
			throw new Exception("You don't own this item");
		}

		if ($this->query("SELECT COUNT(*) FROM item_other_sellers WHERE item_id = ? AND serial_id = ? AND seller_id = ? AND active = 1", [$itemId, $serial, $sellerId])->fetchColumn(0) > 0) {
			throw new Exception("This item is already on sale");
		}

		if (!$this->isValidPrice($price)) {
			throw new Exception("Invalid price");
		}
		$e = $this->query("SELECT id as count FROM item_other_sellers WHERE item_id = ? AND serial_id = ? AND seller_id = ? AND active = 0", [$itemId, $serial, $sellerId]);
		if ($e->rowCount() > 0) {
			$a = $e->fetchColumn(0);
			return $this->editSale($a, $sellerId, $price, 0);
		}

		$query = $this->insert("item_other_sellers", ["seller_id" => $sellerId, "item_id" => $itemId, "price" => $price, "serial_id" => $serial]);
		return $query;
	}

	function findOtherSale($sql, $values) {
		$query = $this->query("SELECT * FROM item_other_sellers WHERE " . $sql, $values);
		if ($query) {
			return $query->fetchAll();
		}
		return false;
	}

	function getOtherSale($saleId, $active = 1) {
		$query = $this->query("SELECT * FROM item_other_sellers WHERE id = ? AND active = ?", [$saleId, $active])->fetch();
		if ($query) {
			return $query;
		}
		throw new Exception("Invalid saleE");
	}

	function offsaleSale($saleId, $userId) {
		$sale = $this->getOtherSale($saleId);

		if ($sale) {
			if ($sale['seller_id'] == $userId) {
				$this->update_('item_other_sellers', ['active' => '0'], ['id' => $sale['id']]);
				return true;
			}
		}
		throw new Exception("Invalid sale");
	}

	function editSale($saleId, $userId, $price, $active = 1) {
		$sale = $this->getOtherSale($saleId, $active);

		if ($sale) {
			if ($sale['seller_id'] == $userId) {
				if ($this->isValidPrice($price)) {
					$this->update_('item_other_sellers', ['price' => $price], ['id' => $sale['id']]);
					if ($active == 0) {
						$this->update_('item_other_sellers', ['active' => '1'], ['id' => $sale['id']]);
					}
					return true;
				}
				throw new Exception("Invalid price");
			}
		}
		throw new Exception("Invalid sale");
	}

	function buyFromOtherSeller ($saleId, $userId) {
		$sale = $this->getOtherSale($saleId);

		if ($sale) {

			$user = $this->get_user($userId);
			$creator = $this->get_user($sale["seller_id"]);

			if ($user->id == $sale["seller_id"]) {
				throw new Exception("You can't buy your own item");
			}
			//($item, $user, $serial = null)
			if (!$this->hasItem( $sale["item_id"], $sale["seller_id"], $sale["serial_id"])) {
				// if seller doesn't have item
				$this->update_("item_other_sellers", ['active' => 0], ["id" => $sale['id']]);
				throw new Exception ("Unknown error (2)");
			}
			
			if(!$this->isTradeable($sale["item_id"])) {
				throw new Exception("This item is no longer a tradeable.");
			}

			if ($user->bop >= $sale["price"]) {
				$priceTaxed = floor($sale["price"] / 1.25);
				$pay = $this->update_("users", ["bop" => $user->bop - $sale["price"]], ["id" => $userId]);
				if ($pay) {
					$user = $this->get_user($userId);
					$this->update_("users", ["bop" => $creator->bop + $priceTaxed ], ["id" => $creator->id]);
					//	function itemInventory           ($item, $user, $serial) {
					$inventoryItem = $this->itemInventory($sale["item_id"], $sale["seller_id"], $sale["serial_id"]);

					if ($inventoryItem) {
						//"switch" ownership
						$this->update_("item_other_sellers", ['active' => 0], ["id" => $sale['id']]);
						//addItem ( $item, $user, $price, $fromId, $sameSerial = false )
						$this->addItem($sale["item_id"], $userId, $sale["price"], $sale["seller_id"], $sale["serial_id"]);
						$this->update_("inventory", ['own' => '0'], ['id' => $inventoryItem[0]['id']]);
						return true;
					}

				}
				throw new Exception("Unknown error");
			}

			throw new Exception("You don't have enough bopibits to purchase this");


		}
		throw new Exception("Invalid sale");
	}

	function getNextSerial($itemId) {
		$query = $this->query("SELECT COUNT(*) FROM inventory WHERE item_id = ?", [$itemId])->fetchColumn(0);
		return $query;
	}

	function updateSerials($item) {
		$query = $this->query("SELECT * FROM inventory WHERE item_id = ? ORDER BY date ASC", [$item])->fetchAll();
		$serial = 0;
		foreach ($query as &$row) {
			$row["serial"] = $serial;
			//$this->update_("wishlist", ["active" => "1"], ["user_id" => $userId, "item_id" => $itemId]);
			$this->update_("inventory", ["serial" => $serial] , ["id" => $row["id"]]);
			$serial++;
		}

		return true;
	}
	
	/* Item Bundles */
	
	
	// we merge bundle items and the bundle itself in this function
	function getBundle($bundleId) {
		$bundle = $this->getItem($bundleId);
		$items = ["items" => $this->getBundleItems($bundleId)];
		return array_merge($bundle, $items);
	}
	
	// function only gets the bundle row from item_bundles
	public function getBundleOnly ($bundleId) {
		$query = $this->query("SELECT * FROM items WHERE id = ?", [$bundleId]);
		return ($query->rowCount() > 0) ? $query->fetch(PDO::FETCH_ASSOC) : false;
	}
	
	public function inBundle($itemId) {
		$query = $this->query("SELECT bundle_id FROM item_bundles_items WHERE item_id = ?", [$itemId]);
		return ($query->rowCount() > 0) ? $query->fetchAll(PDO::FETCH_ASSOC) : false;
		return false;
	}
	
	public function getBundleItems($bundleId, $active = 1) {
		$query = $this->query("SELECT * FROM item_bundles_items WHERE bundle_id = ? AND active = ?", [$bundleId, $active]);

		return ($query->rowCount() > 0) ? $query->fetchAll(PDO::FETCH_ASSOC) : false;
	}
	
	public function addToBundle ( $bundleId, $itemId ) {
		$bundle = $this->getBundle($bundleId);
		if ($bundle) {
			if ($this->query("SELECT * FROM item_bundles_items WHERE bundle_id = ? AND item_id = ?", [$bundleId, $itemId])->rowCount() > 0) {
				
				return $this->update_("item_bundles_items", ["active" => "1"], ["bundle_id" => $bundleId, "item_id" => $itemId]);
			} else {
			
			$item = $this->getItem($itemId);
			$insert = $this->insert("item_bundles_items", ["bundle_id" => $bundle['id'],"active"=>"1", "item_id" => $item['id']]);
			
			return ($insert) ? true : false;
			}
		}
		throw new Exception("Unable to find bundle");
	}
	
	public function removeFromBundle( $bundleId, $itemId ) {
		return $this->update_("item_bundles_items", ["active" => "0"], ["bundle_id" => $bundleId, "item_id" => $itemId]);
	}
	
	public function updateBundle ($bundleId, array $values) {
		if (isset($values["name"])) {
			if (empty(trim($values["name"]))) {
				$name = "Unnamed Bundle";
			}
		}
		if (isset($values["name"])) {
			if (strlen($values["name"]) > 50) {
				throw new Exception("Name muse be shorter than 50 characters");
			}
		}

		
		if (isset($values["description"])) {
			if (strlen($description) > 750) {
				throw new Exception("Description muse be shorter than 750 characters");
			}
		}
		
		if (isset($values["price"])) {
			if (empty(trim($values["price"])) || !is_numeric($values["price"]) || $values["price"] < 0) {
				$values["price"] = 0;
			}
		}

		$values["updated"] = date('Y-m-d H:i:s');
		return $this->update_("item_bundles", $values, ["id" => 1]);
	}
	
	public function itemName($itemId) {
		$query = $this->query("SELECT name FROM items WHERE id = ?", [$itemId]);
		return ($query->rowCount() > 0) ? $query->fetchColumn() : false;
	}

	public function createBundle ( $name, $description, $price, $userId, $sale ) {
		if (empty(trim($name))) {
			$name = "Unnamed Bundle";
		}

		if (strlen($name) > 50) {
			throw new Exception("Name muse be shorter than 50 characters");
		}

		if (strlen($description) > 750) {
			throw new Exception("Description muse be shorter than 750 characters");
		}

		if (empty(trim($price)) || !is_numeric($price) || $price < 0) {
			$price = 0;
		}
		
		return $this->insert("items", ["name" => $name, "description" => $description, "price" => $price, "creator" => $userId, "category" => "7", "sale_type" => $sale, "verified" => "-2"]);
	}
	
	public function hasBundle($bundleId, $userId) {
		$bundle = $this->getBundle($bundleId);
		
		if ($bundle['items']) {
			foreach ($bundle['items'] as $i => $item) {
				if (!$this->hasItem($item['item_id'], $userId)) {
					return false;
				}
			}
		}
		
		return true;
	}
	
	/*
	function buy ($itemId, $userId) {
		$item = $this->getItem($itemId);
		if ($item) {
			$user = $this->get_user($userId);
			$creator = $this->get_user($item["creator"]);

			if ($user && $item['sale_type'] == 0) {

				if (!$this->hasItem($item['id'],$userId)) {
					if ($item["price"] <= $user->bop) {
						$add = $this->addItem($itemId, $userId, $item['price'], $item['creator']);
						if ($add) {
							// recieve
							$priceTaxed = floor($item["price"] / 1.25);
							$pay = $this->update_("users", ["bop" => $user->bop - $item["price"]], ["id" => $userId]);
							if ($pay) {
								$user = $this->get_user($userId);
								$this->update_("users", ["bop" => $creator->bop + $priceTaxed ], ["id" => $creator->id]);
							}
						return true;
						}
					} else {
						throw new Exception("You do not have enough bopibits to buy this item");
					}
				} else {
					throw new Exception("You already own this item");
				}

			} else {
				throw new Exception("Item is offsale");
			}

		} else {
			throw new Exception("Invalid item");
		}
		return false;
	}
	*/
	
	public function buyBundle ($bundleId, $userId) {
		$bundle = $this->getBundle($bundleId);
		
		
		if ($bundle) {
			$creator = $this->get_user($bundle['creator']);
			$user = $this->get_user($userId);
			
			if ($user && $bundle['sale_type'] == 0) {
				if (!$this->hasBundle($bundleId, $userId)) {
					if ($bundle["price"] <= $user->bop) {
						$priceTaxed = floor($bundle["price"] / 1.25);
						$pay = $this->update_("users", ["bop" => $user->bop - $bundle["price"]], ["id" => $userId]);
						if ($pay) {
							$this->update_("users", ["bop" => $creator->bop + $priceTaxed ], ["id" => $creator->id]);
							foreach ($bundle['items'] as $i => $item) {
								if (!$this->hasItem($item['item_id'], $userId)) {
									$item = $this->getItem($item['item_id']);
									$add = $this->addItem($item['id'], $userId, $bundle['price'], $item['creator']);
								}
							}
							return true;
						}
					}
					throw new Exception("You don't have enough bopibits to buy this bundle");
				} 
				throw new Exception("You already own all the items in this bundle");
			}
			throw new Exception("This item is offsale");
		} else {
			throw new Exception("Invalid bundle");
		}
		
	}
	
	/* Purchase Function */
	
	public function purchase() {
		
	}
	
	/* Transactions */
	
	function logTransaction($id, $type, $purchaserId, $sellerId, $price, $serial = 0) {
		
	}
	
	/* Wishlists */

	function getWishlistCount ($itemId) {
		$itemId = (int) $itemId;
		return $this->query("SELECT COUNT(*) as total FROM wishlist WHERE item_id = ? AND active = 1", [$itemId])->fetchAll()[0]['total'];
	}

	function getWishlist ($userId, bool $active = false) {
		$sql = ($active) ? "SELECT * FROM wishlist WHERE user_id = ? AND active = 1" : "SELECT * FROM wishlist WHERE user_id = ?";
		$wishlist = $this->query($sql, [$userId]);
		if ($wishlist) {
			return $wishlist->fetchAll();
		}
		return false;
	}

	function getWishlistBoth ($itemId, $userId, bool $active = false) {
		$sql = ($active) ? "SELECT * FROM wishlist WHERE item_id = ? AND user_id = ? AND active = 1" : "SELECT * FROM wishlist WHERE item_id = ? AND user_id = ?";
		$favorite = $this->query($sql, [$itemId, $userId]);
		if ($favorite) {
			return $favorite->fetchAll();
		}
		return false;
	}

	function addToWishlist ($itemId, $userId) {
		if ($this->getItem($itemId)) {
			if ($this->getWishlistBoth($itemId, $userId, true)) {
				$this->update_("wishlist", ["active" => "1"], ["user_id" => $userId, "item_id" => $itemId]);
			} else {
				$this->insert("wishlist", ["user_id" => $userId, "item_id" => $itemId, "active" => 1]);
			}
		} else {
			throw new Exception("Invalid item");
		}

		return false;
	}

	function removeFromWishlist ($itemId, $userId) {

		if ($this->getWishlistBoth($itemId, $userId, false)) {
			$this->update_("wishlist", ["active" => "0"], ["user_id" => $userId, "item_id" => $itemId]);
			return true;
		}

		throw new Exception("Wishlist not found");
	}

	function getSold ($itemId) {
		$itemId = (int) $itemId;
		$query = $this->query("SELECT COUNT(*) as sold FROM inventory WHERE item_id = ? AND own = 1", [$itemId]);
		return ($query) ? ($query->fetchAll()[0]['sold'] - 1) : 0;
	}

	/*function getWishlistCount () {
		$itemId = (int) $itemId;
		$query = $this->query("SELECT COUNT(*) as sold FROM inventory WHERE item_id = ? AND own = 1", [$itemId]);
		return ($query) ? $query->fetchAll()[0]['sold'] : 0;
	}*/

	function itemExists ($id) {
		if (is_numeric($id)) {
			$results = $this->query("SELECT COUNT(*)as results FROM items WHERE id = ?", [$id])->fetchAll()[0]['results'];
			return ($results == 0) ? false : true;
		}
		return false;
	}

	function buy ($itemId, $userId) {
		$item = $this->getItem($itemId);
		if ($item) {
			$user = $this->get_user($userId);
			$creator = $this->get_user($item["creator"]);

			if ($user && $item['sale_type'] == 0) {
				if ($this->isTradeable($itemId)) {
					$stock = $this->getStock($item['id']);
					if ($stock['remaining'] == 0) {
						throw new Exception("This item is sold out.");
					}
				}
				if (!$this->hasItem($item['id'],$userId)) {
					if ($item["price"] <= $user->bop) {
						$add = $this->addItem($itemId, $userId, $item['price'], $item['creator']);
						if ($add) {
							// recieve
							$priceTaxed = floor($item["price"] / 1.25);
							$pay = $this->update_("users", ["bop" => $user->bop - $item["price"]], ["id" => $userId]);
							if ($pay) {
								$user = $this->get_user($userId);
								$this->update_("users", ["bop" => $creator->bop + $priceTaxed ], ["id" => $creator->id]);
							}
						return true;
						}
					} else {
						throw new Exception("You do not have enough bopibits to buy this item");
					}
				} else {
					throw new Exception("You already own this item");
				}

			} else {
				throw new Exception("Item is offsale");
			}

		} else {
			throw new Exception("Invalid item");
		}
		return false;
	}

	function isValidPrice($price) {
		if (!intval($price)) {
			return false;
		}
		if (trim(empty($price)) || intval($price) < 0 || intval($price) > 10000000) {
			return false;
		}
		return true;
	}

	function getSerials($item, $user) {
		return $this->query("SELECT * FROM inventory WHERE item_id = ? AND user_id = ?", [$item, $user])->fetchAll();
	}

	function hasItem ($item, $user, $serial = null) {
		if (is_null($serial)) {
		$own = ($this->query("SELECT count(*) as count FROM inventory WHERE user_id = ? AND item_id = ? AND own = 1", [ $user, $item ])->fetchAll(PDO::FETCH_ASSOC)[0]["count"] > 0) ? true : false;
		} else {
			$own = ($this->query("SELECT count(*) as count FROM inventory WHERE user_id = ? AND item_id = ? AND serial = ? AND own = 1", [ $user, $item, $serial ])->fetchAll(PDO::FETCH_ASSOC)[0]["count"] > 0) ? true : false;
		}
		return $own;
	}

	function isTradeable($itemId) {
		if ($this->getItem($itemId)) {
			$item = $this->getItem($itemId);
			if ($item['tradeable'] == "1" && $item['verified'] == "1") {
				return true;
			}
		}
		return false;
	}

	function itemInventory ($item, $user, $serial) {
		$query = $this->query("SELECT * FROM inventory WHERE user_id = ? AND item_id = ? AND serial = ? AND own = 1", [ $user, $item, $serial ])->fetchAll(PDO::FETCH_ASSOC);
		if ($query) {
			return $query;
		}
		return false;
	}

	function addItem ( $item, $user, $price, $fromId, $sameSerial = false ) {
		$serial = ($sameSerial) ? $sameSerial : $this->getNextSerial($item);
		$add = $this->insert("inventory", ["item_id" => $item, "serial" => $serial, "user_id" => $user, "price" => $price, "from_id" => $fromId, "own" => 1]);
		return true;

	}

	function transferItem ( $item, $user, $newUser ) {

	}
	/* Trading */

	function getTrade( $id ) {
		$trade = $this->look_for("trades", ['id' => $id]);
		if ($trade) {
			$trade = $this->parseTrade($trade);
			return $trade;
		}
		return false;
	}

	function getTrades ($query, $values) {
		$trades = $this->query($query, $values);

		if ($trades) {
			if ($trades->rowCount() > 0) {
				return $trades->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		throw new Exception("No results");
	}

	function parseTrade ($trade) {
		$trade->sending = json_decode($trade->sending);
		$trade->asking_for = json_decode($trade->asking_for);
		foreach ($trade->sending as &$item) {
			$item = ["id" => $item[0], "serial" => $item[1]];
		}
		foreach ($trade->asking_for as &$item) {
			$item = ["id" => $item[0], "serial" => $item[1]];
		}
		return $trade;
	}

	function getTradeProtected ( $tid, $userId ) {
		$trade = $this->getTrade($tid);
		if ($trade) {
			if ($userId == $trade->from_user || $userId == $trade->to_user) {
				return $trade;
			}
		}
		throw new Exception("Invalid Trade");
	}

	function tradeInfo($uid) {
		return [
		"recieved" => $this->query("SELECT COUNT(*) as count FROM trades WHERE status = 0 AND to_user = ?", [$uid])->fetchColumn(0),
		"outgoing" => $this->query("SELECT COUNT(*) as count FROM trades WHERE status = 0 AND from_user = ?", [$uid])->fetchColumn(0),
		"history" => $this->query("SELECT COUNT(*) as count FROM trades WHERE status != 0 AND (to_user = ? OR from_user = ?)", [$uid, $uid])->fetchColumn(0)
		];
	}

	function sendTrade ($from, $to, $sendingItems, $asking_for) {
		if($this->tooFast()) //Too Fast Locally
		{
			throw new Exception("You are sending too many trades.");
		}
		$this->updateFast();
		if (count($asking_for) < 9 || count($sendingItems) < 9) {
			foreach ($sendingItems as $item) {
				if (!$this->isTradeable($item['id'])) {
					throw new Exception("One of the items is not tradeable");
				}
				if (!$this->hasItem($item['id'], $from, $item['serial'])) {
					throw new Exception("Missing Item(s) [] " . $item['id'] . "#" . $item['serial']);
				}
			}
			foreach ($asking_for as $item) {
				if (!$this->isTradeable($item['id'])) {
					throw new Exception("One of the items is not tradeable");
				}
				if (!$this->hasItem($item['id'], $to, $item['serial'])) {
					throw new Exception("Missing Item(s)");
				}
			}

			$insert = $this->insert("trades", [ "from_user" => $from, "to_user" => $to, "sending" => $this->tradeFormatValues($sendingItems), "asking_for" => $this->tradeFormatValues($asking_for), "status" => "0" ]);
			if ($insert) {
				return true;
			}

		} else {
			throw new Exception("Only 1-8 items are allowed for trading");
		}
	}

	function tradeFormatValues(array $items) {
		$result = [];
		foreach ($items as $item) {
			$result[] = [$item['id'], $item['serial']];
		}
		return json_encode($result);
	}

	function acceptTrade ($tid) {
		$trade = (array) $this->getTrade($tid);
		//Transfer Items
		// Check if both users still own the items

		foreach ($trade["sending"] as $item) {
			if (!$this->hasItem($item['id'], $trade['from_user'], $item['serial'])) {
				$this->update_("trades", ['status' => '-3'], ['id' => $tid]);
				throw new Exception("Missing item(s)");
			}
		}
		foreach ($trade["asking_for"] as $item) {
			if (!$this->hasItem($item['id'], $trade['to_user'], $item['serial'])) {
				$this->update_("trades", ['status' => '-3'], ['id' => $tid]);
				throw new Exception("Missing item(s)");
			}
		}

		foreach ($trade["sending"] as $item) {
			$this->update_("inventory", ["own" => "0"], ['item_id' => $item['id'], 'serial' => $item['serial'], 'user_id' => $trade['from_user']]);
			$this->addItem($item['id'], $trade["to_user"], "0", $trade["from_user"], $item['serial']);
		}

		foreach ($trade["asking_for"] as $item) {
			$this->update_("inventory", ["own" => "0"], ['item_id' => $item['id'], 'serial' => $item['serial'], 'user_id' => $trade['to_user']]);
			$this->addItem($item['id'], $trade["from_user"], "0", $trade["to_user"], $item['serial']);
		}

		$this->update_("trades", ["status" => "1"], ["id" => $tid]);

		return true;
	}

	function declineTrade () {

	}

	function updateTrades () {

	}
	/* misc */
	public function getThumbnail() {
		
	}
	/* Comments */

	function getComments($item_id) {
		if ($this->itemExists($item_id)) {
			$query = $this->query("SELECT comments.id, comments.user_id, comments.posted, comments.item_id, comments.body FROM comments WHERE item_id = ? AND comments.deleted = 0 ORDER BY id DESC", [$item_id]);
			if ($query->rowCount() > 0 ) {
				return $query->fetchAll(PDO::FETCH_ASSOC);
			}
			throw new Exception("No Results");
		}
		throw new Exception("Invalid Item");
	}

	function getComment($commentId) {
		$query = $this->query("SELECT comments.id, comments.user_id, comments.item_id, comments.posted, comments.body, comments.deleted FROM comments WHERE id = ?", [$commentId]);
		if ($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		throw new Exception("No Result");
	}

	function postComment($user_id, $item_id, $body) {
		if (!empty(trim($body))) {
			if (strlen($body) <= 250) {
				if ($this->itemExists($item_id)) {
					$query = $this->insert("comments", [ "user_id" => $user_id, "item_id" => $item_id, "body" => $body, "deleted" => "0" ]);
					if ($query) {
						return true;
					} else {
						throw new Exception("Could not post comment");
					}
				} else {
					throw new Exception("Invalid item");
				}
			} else {
				throw new Exception("Comment is too long");
			}
		} else {
			throw new Exception("Comment cannot be empty");
		}
	}

	// category to name

	function isImage ($img) {
		return (getimagesize($img)) ? true : false;
	}

	function createItem ( $name, $description, $price, $creator, $category, $sale, $texture, $model = false, $tradeable = 0, $stock = 0 ) {

		if ($this->logged_in()) {

			$pdo = $this->pdo;

			$path = "/var/www/storage/assets/";
			if (empty(trim($price)) || !is_numeric($price)) {
				$price = 0;
			}
			
			if ($category == "7") {
				goto afterimage;
			}
			
			if ($this->isImage($texture["tmp_name"]) && $texture["size"] < 1000000 && is_numeric($sale) && strlen($name) <= 30 && strlen($description) <= 750) {
				afterimage:

				$cat = $this->cat2dir($category);
				if ($cat) {
					$path .= $cat . "/";


					if (empty(trim($name))) {
						$name = "Unnamed";
					}

					if (strlen($name) > 30) {
						throw new Exception("Name muse be shorter than 30 characters");
					}

					if (strlen($description) > 750) {
						throw new Exception("Description muse be shorter than 750 characters");
					}

					if (empty(trim($price)) || !is_numeric($price) || $price < 0) {
						$price = 0;
					}
					
					if (!in_array($category, [1,2,3])) {
						$stock = 0;
						$tradeable = 0;
					}
					$insert = $pdo->prepare("INSERT INTO items (`id`, `name`, `description`, `price`, `creator`, `uploaded`, `updated`, `category`, `sale_type`, `tradeable`, `stock`) VALUES(NULL, ?, ?, ?, ?, now(), now(), ?, ?, ?, ?);");
					$insert->execute([$name, $description, $price, $creator, $category, $sale, $tradeable, $stock]);

					$filename = $this->pdo->lastInsertId();
					if ($insert) {

						$moveTex = move_uploaded_file($texture["tmp_name"], $path . $filename . ".png");
						if ($model) {
							move_uploaded_file($model["tmp_name"], $path . $filename . ".obj");
						}

						return $filename;

						}

				} else {
					throw new Exception("Invalid category.");
				}

			}

		}

		return false;

	}

	function checkGetValues (array $parameters) {
		foreach ($parameters as $parameter) {
			if (!isset($_GET[$parameter])) {
				return false;
			}
		}
		return true;
	}

	function page ($page, $perPage) {

		if (is_numeric ($perPage)) {
			$page = ($page - 1) * $perPage;
			return [$page, $perPage];
		}

	}

	function isCreator ($itemId, $userId) {
		$sql = "SELECT COUNT(id) as owns FROM items WHERE id = ? AND creator = ?";
		return ($this->query($sql, [$itemId, $userId])->fetchColumn() > 0);
	}

	function updateItem ($itemId, array $values) {



		if (isset($values["name"])) {
			if (empty(trim($values["name"]))) {
				$name = "Unnamed";
			}
			if (strlen($values["name"]) > 30) {
				throw new Exception("Name muse be shorter than 30 characters");
			}
		}

		if (isset($values["price"])) {
			if ($values["price"] < 0) {
				throw new Exception("Price must be less than or equal to 0");
			}
		}

		if (isset($values["description"])) {
			if (strlen($values["description"]) > 750) {
				throw new Exception("Description muse be shorter than 750 characters");
			}
		}

		$update = $this->update_("items", $values, ["id" => $itemId]);
		if ($update) {
			return true;
		} else {
			throw new Exception("Error updating");
		}
	}
	
	
	
	function search ($query, $category = "all", $sort = "", $page, $additionalSort = false, $totalCount = false, $perPage = 12) {

		$values = [];
		$page = $this->page($page,$perPage);
		if ($totalCount) {
			$sql = "SELECT COUNT(*) as total FROM items ";
		} else {
			switch ($sort) {
				case "most_bought":
					$sql="SELECT count(inventory.item_id) as sales, items.id, items.tradeable, items.stock, items.name, items.price, items.creator, items.category, items.sale_type, items.verified FROM items LEFT JOIN inventory ON items.id = inventory.item_id ";
					//$sql = "SELECT items.id, items.name, items.price, items.creator, items.category, items.sale_type, items.verified FROM items,inventory ";
					break;
				case "most_favorites":
					$sql="SELECT count(favorite.item_id) as favorites, items.id, items.tradeable, items.stock, items.name, items.price, items.creator, items.category, items.sale_type, items.verified FROM items LEFT JOIN favorite ON items.id = favorite.item_id ";
					//$sql = "SELECT items.id, items.name, items.price, items.creator, items.category, items.sale_type, items.verified FROM items,inventory ";
					break;
				default:
				$sql = "SELECT items.id, items.tradeable, items.stock, items.name, items.price, items.creator, items.category, items.sale_type, items.verified FROM items ";
					break;
			}
		}

		if (!empty(trim($query))) {
			$sql .= "WHERE items.name LIKE ? ";
			$values[] = "%" . $query . "%";
		} else {
			$sql .= "WHERE items.id > 0 ";
		}

			if ($category !== "all" && $category !== "threeo") {
				if (is_array($category)) {
					foreach($category as $index => $singularCategory) {
						$sql .= ($index == 0) ? "AND items.category = ? " : "OR items.category = ? ";
						$values[] = $singularCategory;

					}
				} else {
					$sql .="AND items.category = ? ";
					$values[] = $category;
				}
			}
			//echo $category;
			if ($category == "threeo") {
				$sql .="AND (items.category = 1 OR items.category = 2 OR items.category = 3 OR items.category = 7) ";
			}

			if ($additionalSort) {
				foreach ($additionalSort as $column => $value) {
					if (is_array($value)) {
						$sql .= "AND items." . $value[0] . " ".$value[1]." ? ";
						$values[] = $value[2];
					} else {
						$sql .= "AND items." . $column . " = ? ";
						$values[] = $value;
					}
				}
			}


			if (!$totalCount) {
				if  (!empty(trim($sort))) {
					$sortSQL = "";
					$sortArray = [
					"expensive" => "ORDER BY items.price DESC, items.sale_type ASC",
					"cheap" => "ORDER BY items.price ASC, items.sale_type DESC",
					"most_bought" => " GROUP BY id ORDER BY sales DESC",
					"most_favorites" => " GROUP BY id ORDER BY favorites DESC"
					];
					$sortSQL = (array_key_exists($sort, $sortArray)) ? $sortArray[$sort] : "";
					$sql .= $sortSQL;
				} else {
					$sql .= "ORDER BY items.id DESC";
				}
			}
		if (!$totalCount) {
			$sql .= " LIMIT ?,?;";
			$values[] = $page[0];
			$values[] = $page[1];
		}

		$this->pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

		if ($totalCount) {
			return $this->query($sql, $values)->fetchAll(PDO::FETCH_ASSOC);
		} else {
			//return $this->pdo->query("SELECT count(inventory.item_id) as sales, items.id, items.name, items.price, items.creator, items.category, items.sale_type, items.verified FROM items LEFT JOIN inventory ON items.id = inventory.item_id WHERE items.id > 0 AND items.category = 6 AND verified = 1  GROUP BY id ORDER BY sales DESC LIMIT 0,12;")->fetchAll();
			return $this->query($sql, $values)->fetchAll(PDO::FETCH_ASSOC);
		}

	}

}

class shopRender extends blender {

	public $categoryList = [
		1 => "hats",
		2 =>  "faces",
		3 => "shirts",
		4 => "pants",
		5 => "decals",
		6 => "faces"
	];

	public function renderItem ($id, $category, $preview = false) {

		$path = ($preview) ?  $preview : "/var/www/storage/assets/".$this->cat2dir($category)."/";

		switch ($category) {
			case 1:
				//hat
				$this->mainBlend( "/var/www/html/render-testing/avatarEXTRA.blend" );
				$this->obj( $path . $id . ".obj", $path . $id . ".png", "hat" );
				$this->focus(["hat", "Head"]);
				break;
			case 2:
				//tool
				//arm stuff
				$this->mainBlend( "/var/www/html/render-testing/avatarEXTRA.blend" );
				$this->obj( $path . $id . ".obj", $path . $id . ".png", "tool" );
				$this->position("LeftArm", ['x' => -3.46774, 'y' => -0.9958, 'z' => 5.00153]);
				$this->rotate("LeftArm", [-90, -90, 0]);
				$this->focus(["tool", "LeftArm"]);
				break;
			case 3:
				//face
				$this->mainBlend( "/var/www/html/render-testing/avatarEXTRA.blend" );
				$this->applyTexture( "Face", $path . $id . ".png" );
				$this->focus("Head");
				break;
			case 4:
				//shirt
				$this->mainBlend( "/var/www/html/render-testing/avatar.blend" );
				$this->applyTexture( "Shirt", $path. $id . ".png" );
				$this->focus();
				break;
			case 5:
				//pants
				$this->mainBlend( "/var/www/html/render-testing/avatar.blend" );
				$this->applyTexture( "Pants", $path. $id . ".png" );
				$this->focus();
				break;
			case 6:
				//decals
				$this->mainBlend( "/var/www/html/render-testing/avatar.blend" );
				$this->applyTexture( "Texture", $path. $id . ".png" );
				$this->focus();
				break;
		}
		// If it's not face apply face!
		if ($category != 3) {
			$this->applyTexture( "Face", "/var/www/html/render-testing/coolface.png" );
		}
		//var_dump($this->py);
	}

	public function exportI ($filename, $filepath, $size) {
		$this->export($filename, $size,$filepath,"");
	}

}

$shop = new shop;
$shopRender = new shopRender;
