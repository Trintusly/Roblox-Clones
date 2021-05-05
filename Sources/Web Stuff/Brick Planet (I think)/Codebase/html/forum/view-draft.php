<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	$viewDraft = $db->prepare("SELECT ForumThreadDraft.ID, ForumThreadDraft.Title, ForumThreadDraft.Post, ForumThreadDraft.TopicID FROM ForumThreadDraft WHERE ID = ? AND UserID = ".$myU->ID."");
	$viewDraft->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$viewDraft->execute();
	
	if ($viewDraft->rowCount() == 0) {
		
		header("Location: ".$serverName."/forum/");
		die;
		
	}
	
	else {
		
		$vD = $viewDraft->fetch(PDO::FETCH_OBJ);
		
		$_SESSION['DraftID'] = $vD->ID;
		$_SESSION['DraftTitle'] = $vD->Title;
		$_SESSION['DraftPost'] = $vD->Post;
		
		header("Location: ".$serverName."/forum/new/".$vD->TopicID."/");
		die;
		
	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");