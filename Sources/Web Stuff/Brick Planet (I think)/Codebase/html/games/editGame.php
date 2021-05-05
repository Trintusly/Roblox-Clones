<?php
$page = 'games';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireLogin();
	
	$GameId = (!empty($_GET['GameId'])) ? $_GET['GameId'] : null;
	
	if (!$GameId) {
		
		header("Location: ".$serverName."/games/");
		die;
		
	}
	
	$GetUserGame = $db->prepare("SELECT UserGame.ID, UserGame.Name, UserGame.Description FROM game.UserGame WHERE ID = ? AND UserID = ".$myU->ID);
	$GetUserGame->bindValue(1, $GameId, PDO::PARAM_INT);
	$GetUserGame->execute();
	
	if ($GetUserGame->rowCount() == 0) {
		
		header("Location: ".$serverName."/games/");
		die;
		
	}
	
	$gG = $GetUserGame->fetch(PDO::FETCH_OBJ);
	
	$Name = (!empty($_POST['name'])) ?  htmlentities(strip_tags(trim(preg_replace('/\s+/',' ', $_POST['name'])))) : NULL;
	$Description = (!empty($_POST['description'])) ? htmlentities(strip_tags($_POST['description'])) : NULL;
	$CSRFToken = (!empty($_POST['csrf_token'])) ? $_POST['csrf_token'] : NULL;
	$errorMessage = null;
	
	if ($Name) {
		
		if ($CSRFToken != $_SESSION['csrf_token']) {
			$errorMessage = 'We\'re sorry, we couldn\'t verify your request. Please try updating again.';
		} else if (strlen($Name) < 1 || strlen($Name) > 64) {
			$errorMessage = 'We\'re sorry, your game name should have between 1 and 64 characters. Please try again.';
		} else if ($Description && strlen($Description) > 1024) {
			$errorMessage = 'We\'re sorry, your game description should have no more than 1,024 characters. Please try again.';
		} else if (isProfanity($Name) == 1) {
			$errorMessage = 'We\'re sorry, your game name triggered our profanity filter. Please try again.';
		} else if (isProfanity($Description) == 1) {
			$errorMessage = 'We\'re sorry, your game description triggered our profanity filter. Please try again.';
		} else {
			
			$SEOName = str_replace(' ', '-', str_replace('/', '--', $Name));
			
			$UpdateUserGame = $db->prepare("UPDATE game.UserGame SET Name = ?, SEOName = ?, Description = ? WHERE UserGame.ID = ".$gG->ID);
			$UpdateUserGame->bindValue(1, $Name, PDO::PARAM_STR);
			$UpdateUserGame->bindValue(2, $SEOName, PDO::PARAM_STR);
			$UpdateUserGame->bindValue(3, $Description, PDO::PARAM_STR);
			$UpdateUserGame->execute();
			
			$cache->delete($myU->Username.'_Profile');
			
			header("Location: ".$serverName."/games/editGame.php?GameId=".$gG->ID);
			die;
			
		}
	}
	
	echo '
	<script>
	document.title = "Edit '.htmlentities($gG->Name).' - Brick Planet";
	</script>
	<div class="grid-x grid-margin-x align-middle">
		<div class="auto cell no-margin">
			<h4>Edit "'.$gG->Name.'"</h4>
		</div>
		<div class="shrink cell no-margin right">
			<a href="'.$serverName.'/games/viewGame.php?GameId='.$gG->ID.'" class="button button-grey" style="padding: 8px 15px;font-size:13px;line-height:1.25;">Return to Game</a>
		</div>
	</div>
	<div class="push-15"></div>
	';
	if ($errorMessage) {
		echo '<div class="error-message">'.$errorMessage.'</div>';
	}
	echo '
	<div class="container border-r md-padding">
		<form action="" method="POST">
			<label for="name"><strong>Name</strong></label>
			<input maxlength="64" type="text" name="name" id="name" class="normal-input" value="'.$gG->Name.'">
			<div class="push-25"></div>
			<label for="description"><strong>Description</strong></label>
			<textarea maxlength="1024" name="description" id="description" class="normal-input" rows="4">'.$gG->Description.'</textarea>
			<div class="push-25"></div>
			<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
			<input type="submit" name="submit" value="Update" class="button button-blue">
		</form>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");