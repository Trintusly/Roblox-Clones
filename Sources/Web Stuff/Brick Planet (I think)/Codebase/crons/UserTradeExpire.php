<?php
	require_once('/var/www/html/root/private/db.php');
	
	$Query = $db->prepare("UPDATE UserTrade SET Status = 3 WHERE Expires < ".time()."");
	$Query->execute();