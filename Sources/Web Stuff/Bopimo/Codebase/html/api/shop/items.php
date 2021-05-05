<?php 
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
require("shop.php");
header("Content-type: application/json");

if ($shop->checkGetValues(["query", "category"])) {
	/*
	1 - Hat
	2 - Tool
	3 - Faces
	4 - Shirts
	5 - Pants
	6 - T Shirt
	7 - Bundles
	*/
	$query = (isset($_GET["query"])) ? (is_string($_GET["query"])) ? $_GET["query"] : "" : "";
	if ($_GET["category"] == "threeo") {
		$category = "threeo";
	} else {
		$category = (isset($_GET["category"])) ? (is_numeric($_GET["category"])) ? $_GET["category"] : "all" : "all";
	}
	$sort = (isset($_GET["sort"])) ? (is_string($_GET["sort"])) ? $_GET["sort"] : "" : "";
	$perPage = 12;
	
	if (isset($_GET["perPage"])) {
		if (is_numeric($_GET["perPage"])) {
			if ($_GET["perPage"] <= 50 && $_GET["perPage"] > 0) {
				$perPage = $_GET["perPage"];
			}
		}
	}
	
	$additional = [];
	
	if (isset($_GET["page"])) {
		if (is_numeric($_GET["page"]) && !empty($_GET["page"])) {
			$page = $_GET["page"];
		} else {
			$page = 1;
		}
	} else {
		$page = 1;
	}
	
	$verified = true;
	
	$additional["verified"] = 1;
	
	if (isset($_GET["showVerified"])) {
		if ($_GET["showVerified"] == 1) {
			unset($additional["verified"]);
		} else if ($_GET["showVerified"] == 2) {
			$additional["verified"] = 0;
		}
	}
	
	if (isset($_GET["creator"])) {
		if (!empty($_GET["creator"]) && is_string($_GET["creator"])) {
			$username = $shop->usernameToId($_GET["creator"]);
			
			if ($username) {
				$additional["creator"] = $username;
			}
		}
	}
	if (isset($_GET["min"])) {
		if (is_numeric($_GET["min"]) && !empty($_GET["min"])) {
			$additional[] = ["price",">=", $_GET["min"]];
		}
	}
	if (isset($_GET["max"])) {
		if (is_numeric($_GET["max"]) && !empty($_GET["max"])) {
			$additional[] = ["price","<=", $_GET["max"]];
		}
	}
	
	if($category == "threeo") {
		//$category = 1;
		//$additional["sale_type"] = 1;
	}
	
	$data = $shop->search($query, $category, $sort, $page, $additional, false, $perPage);
//die($data);
	$total = $shop->search($query, $category, $sort, $page, $additional, true, 12);
	$result = [];
	if (!empty($data)) {
	//	die($data);
	
	if (!is_array($data)) {
		var_dump($data);
		die;
		//die(json_encode(["debug" => $data]));
	}
		foreach($data as $index => $item) {
			$data[$index]["image"] = $item["id"];
			if ($item["category"] == "7") {
				$data[$index] = $shop->getBundle($item['id']);
				if (count($data[$index]['items']) > 0) {
					$data[$index]["image"] = $data[$index]['items'][0]['item_id'];
				}
			}
			$data[$index]["categoryName"] = $shop->cat2dir($item["category"]);
			$data[$index]["username"] = $shop->trueUsername($item["creator"]);
			if ($item['tradeable'] == "1") {
				$stock = $shop->getStock($item['id']);
				$data[$index]['price'] = $stock['text'];
			}
		}
		
		array_walk_recursive($data, function (&$value) {$value = htmlentities($value);});
		$result["result"] = $data;
		$result["status"] = "ok";
		$result["total"] = $total[0]["total"];
		$result["page"] = $page;
	} else {
		$result = ["error" => "No results", "status" => "error"];
	}

	echo json_encode($result, JSON_PRETTY_PRINT);

}

?>