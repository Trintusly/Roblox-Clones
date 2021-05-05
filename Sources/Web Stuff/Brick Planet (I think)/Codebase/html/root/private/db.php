<?php
	try {

		$db = new PDO('mysql:host=localhost;dbname=test', 'root', 'DA92vza5McgCXX6b');
		$db->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, TRUE);
	}
	
	catch (PDOException $e) {
	
		die('We are currently undergoing database maintenance. We\'ll be back momentarily!');
	
	}
	

