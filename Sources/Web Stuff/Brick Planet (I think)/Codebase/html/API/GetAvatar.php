<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-type: application/json');
	
	if (!isset($_GET['UserID'])) {
		
		$error = array('error' => 'Invalid User.');
		echo json_encode($error);
		
	}

	else {
		
		$getUser = $db->prepare("SELECT AvatarURL FROM new.User WHERE ID = ?");
		$getUser->bindValue(1, $_GET['UserID'], PDO::PARAM_INT);
		$getUser->execute();
		
		if ($getUser->rowCount() == 0) {
			
			$error = array('error' => 'Invalid User.');
			echo json_encode($error);
			
		}
		
		else {
			
			$gU = $getUser->fetch(PDO::FETCH_OBJ);
			
			$results = array('avatar' => ''.$cdnName.''.$gU->AvatarURL.'');
			
			echo json_encode($results);
		
		}
		
	}