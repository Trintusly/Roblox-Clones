<?php
	try {

		$db = new PDO('mysql:host=localhost;dbname=test', 'root', 'gQwb0eqoeK9CeScB');
		$db->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, TRUE);
	}
	
	catch (PDOException $e) {
	
		die('We are currently undergoing database maintenance. We\'ll be back momentarily!');
	
	}
	

