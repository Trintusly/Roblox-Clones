<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("shop.php");

//var_dump($shop->createBundle(4, "Test Bundle", "ben shapiro touched me", 25));

$result = $shop->createBundle("Flag Bundle","2 Flags for the price of one and a half!", 15, "-1", 4);

var_dump($result);
