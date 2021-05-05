<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "admin.php";

if (isset($_POST["token"]) && isset($_POST["userId"]) && isset($_POST["itemId"])) {
	if ($bop->checkToken($_POST["token"])) {
		if ($admin->isAllowed($_SESSION['id'])) {
			$shop->addItem($_POST["itemId"], $_POST["userId"], "0", $_SESSION['id'], false);
			$admin->log($_SESSION['id'], $_POST["userId"], "gifted ", "item " . $_POST['itemId']);
		}
	}
}