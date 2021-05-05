<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/db.php");

	header('Content-type: application/json');

	if (!isset($_GET['UserID'])) {
		
		$error = array('error' => 'Invalid User.');
		echo json_encode($error);
		
	}

	else {
		
		$getUser = $db->prepare("SELECT TimeLastSeen, InGame FROM Users WHERE ID = ?");
		$getUser->bindValue(1, $_GET['UserID'], PDO::PARAM_INT);
		$getUser->execute();
		
		if ($getUser->rowCount() == 0) {
			
			$error = array('error' => 'Invalid User.');
			echo json_encode($error);
			
		}
		
		else {
			
			$gU = $getUser->fetch(PDO::FETCH_OBJ);
			
			if ($gU->InGame == 0) {

				function get_timeago($ptime) {
					$estimate_time = time() - $ptime;
					
					if($estimate_time < 45) {
						return 'just now';
					}
					$condition = array(
						12 * 30 * 24 * 60 * 60 => 'year',
						30 * 24 * 60 * 60 => 'month',
						24 * 60 * 60 => 'day',
						60 * 60 => 'hour',
						60 => 'minute',
						1 => 'second'
					);
					foreach($condition as $secs => $str) {
							$d = $estimate_time / $secs;
						if($d >= 1) {
							$r = round( $d );
							return '' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
						}
					}
				}
				
				if (($gU->TimeLastSeen+300) < time()) {
					
					$status = 'offline';
					
				}
				
				else {
					
					$status = 'online';
					
				}
				
				$content = array('status' => $status, 'seen' => get_timeago($gU->TimeLastSeen));
				echo json_encode($content);
			
			}
			
			else {
				
				$content = array('status' => 'in-game');
				echo json_encode($content);
				
			}
			
		}
		
	}

?>