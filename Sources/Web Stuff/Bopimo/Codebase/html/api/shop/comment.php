<?php 

require("../rest.php");
require("shop.php");
/*
if (isset($_GET["item_id"])) {
	if (!is_array($_GET["item_id"])) {
		
	} else {
		$rest->error("Invalid parameter values");
	}
} else {
	$rest->error("Missing parameters");
}