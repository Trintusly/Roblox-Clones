<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	if (!$AUTH) { die; }
	
	if (!empty($_GET['q'])) {
		$_GET['q'] = preg_replace('/\s+/', ' ', $_GET['q']);
	}

	if (!empty($_GET['q']) && strlen($_GET['q']) >= 3) {
		
		echo '
		<div class="push-15"></div>
		<div class="emoji-dropdown-heading-text">SEARCH RESULTS</div>
		<div class="emojis-list">
		';
		
		$getEmojis = $db->prepare("SELECT Name, Description FROM EmojiList WHERE Description LIKE ?");
		$getEmojis->bindValue(1, '%'.$_GET['q'].'%', PDO::PARAM_STR);
		$getEmojis->execute();
		
		while ($gE = $getEmojis->fetch(PDO::FETCH_OBJ)) {
			
			$gE->Description = preg_replace('/\s+/', ' ', $gE->Description);
			$gE->Description = trim($gE->Description);
			
			echo '<img title="'.ucfirst($gE->Description).'" draggable="false" class="emoji" src="https://twemoji.maxcdn.com/2/72x72/'.$gE->Name.'.png" onclick="addToTextBox(\''.$gE->Name.'\', \''.$gE->Description.'\')">';
			
		}
		
		echo '</div>';
		
	}
	
	else {
		
		echo '<div class="push-15"></div>';
		
		$getRecentEmojis = $db->prepare("SELECT UserEmojiHistory.Name, EmojiList.Description FROM UserEmojiHistory JOIN EmojiList ON EmojiList.Name = UserEmojiHistory.Name WHERE UserEmojiHistory.UserID = ".$myU->ID." ORDER BY UserEmojiHistory.TimeLastUsed DESC LIMIT 12");
		$getRecentEmojis->execute();
		
		if ($getRecentEmojis->rowCount() > 0) {
		
			echo '
			<div class="emoji-dropdown-heading-text">RECENTLY USED</div>
			<div class="emoji-divider"></div>
			<div class="emoji-push"></div>
			';
			
			while ($gR = $getRecentEmojis->fetch(PDO::FETCH_OBJ)) {
				
				$gR->Description = preg_replace('/\s+/', ' ', $gR->Description);
				$gR->Description = trim($gR->Description);
				
				echo '<img style="font-size:20px;" title="'.ucfirst($gR->Description).'" draggable="false" class="emoji" src="https://twemoji.maxcdn.com/2/72x72/'.$gR->Name.'.png" onclick="addToTextBox(\''.$gR->Name.'\', \''.$gR->Description.'\')">';
				
			}
			
			echo '<div class="emoji-push"></div>';
		
		}
		
		echo '
		<div class="emoji-dropdown-heading-text">ALL</div>
		<div class="emoji-divider"></div>
		<div class="emoji-push"></div>
		<div class="emojis-list">
		';
		
		$getEmojis = $db->prepare("SELECT Name, Description FROM EmojiList");
		$getEmojis->execute();
		
		while ($gE = $getEmojis->fetch(PDO::FETCH_OBJ)) {
			
			$gE->Description = preg_replace('/\s+/', ' ', $gE->Description);
			$gE->Description = trim($gE->Description);
			
			echo '<img title="'.ucfirst($gE->Description).'" draggable="false" class="emoji" src="https://twemoji.maxcdn.com/2/72x72/'.$gE->Name.'.png" onclick="addToTextBox(\''.$gE->Name.'\', \''.$gE->Description.'\')">';
			
		}
		
		echo '</div>';
		
	}