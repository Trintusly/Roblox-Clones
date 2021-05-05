<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");
	
	requireLogin();
	
	$NotificationId = (!empty($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : NULL;
	if (!$NotificationId || $_SERVER['REQUEST_METHOD'] != 'POST' || $_POST['csrf_token'] != $_SESSION['csrf_token']) { die; }
	
	$UpdateUserNotification = $db->prepare("UPDATE UserNotification SET TimeRead = UNIX_TIMESTAMP() WHERE ID = ? AND ReceiverID = ".$myU->ID);
	$UpdateUserNotification->bindValue(1, $NotificationId, PDO::PARAM_INT);
	$UpdateUserNotification->execute();
	
	if ($UpdateUserNotification->rowCount() > 0) {
		echo json_encode(array('status' => 'ok'));
		$cache->delete($myU->ID);
	}