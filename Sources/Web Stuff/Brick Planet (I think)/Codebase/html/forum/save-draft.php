<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	requireLogin();
	
	if (!empty($_POST['title']) && !empty($_POST['title']) && !empty($_POST['topicid'])) {
		
		$title = htmlentities($_POST['title']);
		$post = htmlentities($_POST['post']);
		$title = preg_replace('/( )+/', ' ', $title);
		$post = preg_replace('/( )+/', ' ', $post);
		$topicid = $_POST['topicid'];
		
		if ($myU->NumForumDrafts >= 50) {
			
			$message = 'Draft limit exceeded (50)';
			
		}
		
		else if (strlen($title) < 3 || strlen($title) > 40) {
			
			$message = 'Draft could not be saved, title is too short or too long.';
			
		}
		
		else if (strlen($post) < 3 || strlen($post) > 1000) {
			
			$message = 'Draft could not be saved, post is too short or too long.';
			
		}
		
		else {
			
			$query = $db->prepare("SELECT Post FROM ForumThreadDraft WHERE Title = ? AND UserID = ".$myU->ID." AND TopicID = ? AND TimePost > ".(time() - 3600)."");
			$query->bindValue(1, $post, PDO::PARAM_STR);
			$query->bindValue(2, $topicid, PDO::PARAM_INT);
			$query->execute();
			
			if ($query->rowCount() > 0 && $query->fetchColumn() == $post) {
				
				$message = 'Draft updated.';
				
			}
			
			else if ($query->rowCount() > 0) {
				
				$update = $db->prepare("UPDATE ForumThreadDraft SET Post = ?, TimePost = ".time()." WHERE Title = ? AND UserID = ".$myU->ID."");
				$update->bindValue(1, $post, PDO::PARAM_STR);
				$update->bindValue(2, $title, PDO::PARAM_STR);
				$update->execute();
				
				$message = 'Draft updated.';
				
			}
			
			else {
				
				$insert = $db->prepare("INSERT INTO ForumThreadDraft (Title, Post, UserID, TopicID, TimePost) VALUES(?, ?, ".$myU->ID.", ?, ".time().")");
				$insert->bindValue(1, $title, PDO::PARAM_STR);
				$insert->bindValue(2, $post, PDO::PARAM_STR);
				$insert->bindValue(3, $topicid, PDO::PARAM_INT);
				$insert->execute();
				
				$message = 'Draft saved.';
				
			}
			
		}
		
		echo $message;
		
	}
	
	else {
		
		echo 'A title and post are required to save a draft.';
		
	}