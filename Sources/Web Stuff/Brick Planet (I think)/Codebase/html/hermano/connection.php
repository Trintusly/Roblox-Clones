<?php

	try {
		$db = new PDO('mysql:host=localhost;dbname=test', 'root', 'DA92vza5McgCXX6b');
		$db->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, TRUE);
	} catch (PDOException $e) {
		die('We are currently undergoing database maintenance. We\'ll be back momentarily!');
	}

	$SiteName = 'http://brickcreate.com/hermano/';
	
	session_id();
	session_start();
	ob_start();
	
	if (!empty($_SESSION['UserID'])) {
		$AUTH = true;
	} else {
		$AUTH = false;
	}
	
	if ($AUTH) {
		$GetUser = $db->prepare("SELECT * FROM users WHERE users.id = ?");
		$GetUser->bindValue(1, $_SESSION['UserID'], PDO::PARAM_INT);
		$GetUser->execute();
		
		if ($GetUser->rowCount() == 0) {
			session_destroy();
			header("Location: " . $SiteName);
			die;
		} else {
			$gU = $GetUser->fetch(PDO::FETCH_OBJ);
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>MOOSE OUTFITTERS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="./DOC/Main.css" media="screen">
    <link rel="stylesheet" href="./DOC/Ext.css">
    <script src="http://bootswatch.com/_vendor/jquery/dist/jquery.min.js"></script>
    <script src="http://bootswatch.com/_vendor/popper.js/dist/umd/popper.min.js"></script>
    <script src="http://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="http://bootswatch.com/_assets/js/custom.js"></script>
  </head>