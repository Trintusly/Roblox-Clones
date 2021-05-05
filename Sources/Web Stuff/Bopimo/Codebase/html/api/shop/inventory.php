<?php 

error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
require("../rest.php");
require("shop.php");

if (isset($_GET['page']) && isset($_GET['category']) && isset($_GET['userId'])) {
	
	if (intval($_GET['page'])) {
		
		$perPage = 20;
		if (isset($_GET['perPage'])) {
			if ($_GET['perPage'] == "18") {
				$perPage = 18;
			}
		}
		$page = $shop->page($_GET['page'],$perPage);
		if ($_GET['category'] == 'tradeable') {
			if (isset($_GET['query'])) {
				$total = $shop->query("SELECT count(i.id) FROM inventory as i, items as s WHERE i.user_id = ? AND i.own = 1 AND s.tradeable = 1 AND s.category IN (1,2,3) AND s.id = i.item_id AND i.serial > 0  AND s.name LIKE ?", [$_GET['userId'], "%".$_GET['query']."%"])->fetchColumn(0);	
				$inventory = $shop->query("SELECT s.id, s.name, i.serial, s.price FROM inventory as i, items as s WHERE i.user_id = ? AND i.own = 1 AND s.tradeable = 1 AND s.category IN (1,2,3) AND i.serial > 0 AND s.id = i.item_id  AND s.name LIKE ? LIMIT $page[0],$page[1]", [$_GET['userId'], "%".$_GET['query']."%"]);	
			} else {
				$total = $shop->query("SELECT count(i.id) FROM inventory as i, items as s WHERE i.user_id = ? AND i.own = 1 AND s.sale_type = 1 AND s.category IN (1,2,3) AND i.serial > 0 AND s.id = i.item_id", [$_GET['userId']])->fetchColumn(0);
				$inventory = $shop->query("SELECT s.id, s.name, i.serial, s.price FROM inventory as i, items as s WHERE i.user_id = ? AND i.own = 1 AND s.sale_type = 1 AND s.category IN (1,2,3) AND s.id = i.item_id AND i.serial_id > 0 LIMIT $page[0],$page[1]", [$_GET['userId']]);
			}
		} else {
			if ($_GET["category"] == "all") {
				$total = $shop->query("SELECT count(i.id) FROM inventory as i, items as s WHERE i.user_id = ? AND i.own = 1 AND s.id = i.item_id", [$_GET['userId']])->fetchColumn(0);
				$inventory = $shop->query("SELECT s.id, s.verified, s.name, i.serial, s.price FROM inventory as i, items as s WHERE i.user_id = ? AND i.own = 1 AND s.id = i.item_id LIMIT $page[0],$page[1]", [$_GET['userId']]);

			} else {
				$total = $shop->query("SELECT count(i.id) FROM inventory as i, items as s WHERE i.user_id = ? AND s.category = ? AND i.own = 1 AND s.id = i.item_id", [$_GET['userId'], $_GET['category']])->fetchColumn(0);
				$inventory = $shop->query("SELECT s.id, s.name, s.verified, i.serial, s.price FROM inventory as i, items as s WHERE i.user_id = ? AND s.category = ? AND i.own = 1 AND s.id = i.item_id LIMIT $page[0],$page[1]", [$_GET['userId'], $_GET['category']]);
			}
		}
		if ($inventory->rowCount() > 0) {
			$data = $inventory->fetchAll(PDO::FETCH_ASSOC);
			foreach ($data as $e => &$a) {
				foreach ($a as &$ae) {
					$ae = htmlentities($ae);
				}
			}
			$rest->success(["data" => $data, "total" => $total, "totalPages" => ceil($total/$perPage)]);
			die();
		} else {
			$rest->error("No results");
			die();
		}
		
	}
	
}

$rest->error();