<?php
$page = 'search';
$SearchQuery = (!empty($_GET['q'])) ? htmlspecialchars(strip_tags($_GET['q'])) : NULL;
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	if (!empty($SearchQuery)) {
	
		$getMostRelevant = $db->prepare("
		SELECT * FROM (
		SELECT 0 AS Type, User.Username AS Name, NULL AS PreviousNames FROM User WHERE MATCH(User.Username) AGAINST(?)
		UNION SELECT 1 AS Type, User.Username AS Name, 1 AS PreviousNames FROM UsernameHistory JOIN User ON UsernameHistory.UserID = User.ID WHERE MATCH(UsernameHistory.Username) AGAINST(?)
		UNION SELECT 2 AS Type, UserGame.Name AS Name, NULL AS PreviousNames FROM game.UserGame WHERE MATCH(UserGame.Name) AGAINST(?)
		UNION SELECT 3 AS Type, Item.Name AS Name, NULL AS PreviousNames FROM Item WHERE MATCH(Item.Name) AGAINST(?)
		UNION SELECT 4 AS Type, UserGroup.Name AS Name, NULL AS PreviousNames FROM UserGroup WHERE MATCH(UserGroup.Name) AGAINST(?)
		)x GROUP BY Type
		");
		$getMostRelevant->bindValue(1, $SearchQuery, PDO::PARAM_STR);
		$getMostRelevant->bindValue(2, $SearchQuery, PDO::PARAM_STR);
		$getMostRelevant->bindValue(3, $SearchQuery, PDO::PARAM_STR);
		$getMostRelevant->bindValue(4, $SearchQuery, PDO::PARAM_STR);
		$getMostRelevant->bindValue(5, $SearchQuery, PDO::PARAM_STR);
		$getMostRelevant->execute();
		$countMostRelevant = $getMostRelevant->rowCount();
		
		if ($countMostRelevant == 0) {
			
			$Category = 1;
			
		} else {
		
			$MatchArray = array();
			$i = 0;
		
			while ($S = $getMostRelevant->fetch(PDO::FETCH_OBJ)) {
				similar_text($S->Name, $SearchQuery, $percentage);
				if ($percentage == 100) {
					if ($S->Type == 0 || $S->Type == 1) {
						$MatchArray = array();
						$MatchArray[$percentage] = $S->Type;
					} else if ($S->Type == 2) {
						$MatchArray = array();
						$MatchArray[$percentage] = $S->Type;
					} else if ($S->Type == 4) {
						$MatchArray = array();
						$MatchArray[$percentage] = $S->Type;
					} else if ($S->Type == 3) {
						$MatchArray = array();
						$MatchArray[$percentage] = $S->Type;
					}
					break;
				} else if ($percentage > 20 || $S->Type == 1 && !empty($S->PreviousNames)) {
					$i++;
					$MatchArray[$percentage] = $S->Type;
				}
			}
			
			krsort($MatchArray);
			$MatchArray = array_slice($MatchArray, 0, 1);
			
			$Category = ($MatchArray[0] != 0) ? $MatchArray[0] : 1;
		
		}
	
		echo '
		<style>

		</style>
		<script>
			document.title = "Search - Brick Create";
			var searchQuery = "'.$SearchQuery.'";
			function searchByCategory(Query, Category, Page) {
				if (Page == undefined) { Page = 1; }
				var http = new XMLHttpRequest();
				http.onreadystatechange = function() { 
					if (http.readyState == 4 && http.status == 200) {
						document.getElementById(Category).innerHTML = http.responseText;
					}
				}
				http.open("GET", "'.$serverName.'/search/category/" + Category + "/" + Page + "/" + Query, true);
				http.send(null);
			}
			
			window.onload = function() {
				searchByCategory(searchQuery, '.$Category.');
			}
		</script>
		<h4>Search results for "<strong>'.$SearchQuery.'</strong>"</h4>
		<div class="push-10"></div>
		<ul class="tabs grid-x grid-margin-x search-tabs" data-tabs id="tabs">
			<li class="no-margin tabs-title cell'; if ($Category == 1) { echo ' is-active'; } echo '" aria-selected="true"><a href="#users" onclick="searchByCategory(searchQuery, 1, 1)">Users</a></li>
			<li class="no-margin tabs-title cell'; if ($Category == 2) { echo ' is-active'; } echo '"><a href="#games" onclick="searchByCategory(searchQuery, 2, 1)">Games</a></li>
			<li class="no-margin tabs-title cell'; if ($Category == 3) { echo ' is-active'; } echo '"><a href="#items" onclick="searchByCategory(searchQuery, 3, 1)">Items</a></li>
			<li class="no-margin tabs-title cell'; if ($Category == 4) { echo ' is-active'; } echo '"><a href="#groups" class="no-right-border" onclick="searchByCategory(searchQuery, 4, 1)">Groups</a></li>
		</ul>
		<div class="tabs-content" data-tabs-content="tabs">
			<div id="users" class="tabs-panel'; if ($Category == 1) { echo ' is-active'; } echo '">
				<div id="1"></div>
			</div>
			<div id="games" class="tabs-panel'; if ($Category == 2) { echo ' is-active'; } echo '">
				<div id="2"></div>
			</div>
			<div id="items" class="tabs-panel'; if ($Category == 3) { echo ' is-active'; } echo '">
				<div id="3"></div>
			</div>
			<div id="groups" class="tabs-panel'; if ($Category == 4) { echo ' is-active'; } echo '">
				<div id="4"></div>
			</div>
		</div>
		';
	
	} else {
		
		header("Location: /");
		die;
		
	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");