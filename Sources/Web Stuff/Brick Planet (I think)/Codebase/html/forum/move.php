<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	if ($myU->Admin == 0) {
		
		header("Location: ".$serverName."/forum/");
		die;
		
	}
	
	$getThread = $db->prepare("SELECT ForumThread.ID, ForumThread.TopicID, ForumThread.UserID, ForumThread.Title FROM ForumThread WHERE ID = ?");
	$getThread->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getThread->execute();
	
	if ($getThread->rowCount() == 0) {
		
		header("Location: ".$serverName."/forum/");
		die;
		
	}
	
	$gT = $getThread->fetch(PDO::FETCH_OBJ);
	
	if (isset($_POST['move'])) {
		
		$update = $db->prepare("UPDATE ForumThread SET TopicID = ? WHERE ID = ".$gT->ID."");
		$update->bindValue(1, $_POST['move'], PDO::PARAM_INT);
		$update->execute();
		
		$log = $db->prepare("INSERT INTO ForumAdminLog (ForumType, ForumID, AdminID, UserID, TimeAction, ActionIP, ActionDescription) VALUES(4, ".$gT->ID.", ".$myU->ID.", ".$gT->UserID.", ".time().", '".$_SERVER['REMOTE_ADDR']."', '".$gT->TopicID.":?')");
		$log->bindValue(1, $_POST['move'], PDO::PARAM_INT);
		$log->execute();
		
		header("Location: ".$serverName."/forum/thread/".$gT->ID."/");
		die;
		
	}
	
	echo '
	<div class="container-header md-padding">
		<strong>'.$gT->Title.'</strong>
	</div>
	<div class="container md-padding border-wh">
		<p>Move thread to...</p>
		<form action="" method="POST">
			<select name="move" class="normal-input">
				';
				
				$getTopics = $db->prepare("SELECT ForumTopic.ID, ForumTopic.Name FROM ForumTopic ORDER BY ID ASC");
				$getTopics->execute();
				
				while ($getT = $getTopics->fetch(PDO::FETCH_OBJ)) {
					
					echo '<option value="'.$getT->ID.'"'; if ($gT->TopicID == $getT->ID) { echo ' selected'; } echo '>'.$getT->Name.'</option>';
					
				}
				
				echo '
			</select>
			<div class="push-25"></div>
			<input type="submit" value="Move" class="button button-green">
		</form>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");