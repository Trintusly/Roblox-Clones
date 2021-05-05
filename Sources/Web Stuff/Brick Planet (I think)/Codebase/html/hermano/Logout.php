<?php

	include './connection.php';
	
	if ($AUTH) {
		session_destroy();
	}
	
	header("Location: " . $SiteName);
	die;