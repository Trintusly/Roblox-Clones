<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");
require_once($_SERVER['DOCUMENT_ROOT']."/../private/memcached.php");

	header('Content-Type: application/json');
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	
	$Token = (!empty($_GET['Token']) && ctype_alnum($_GET['Token'])) ? $_GET['Token'] : NULL;
	if (!$Token || strlen($Token) != 36) die;
	$TokenData = $cache->get('GameAuthToken_' . $Token);
	if (!$TokenData) die;
	
	header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK', true, 200);
	echo json_encode($TokenData);