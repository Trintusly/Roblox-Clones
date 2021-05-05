<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Access-Control-Allow-Origin: *');
	header('HTTP/1.0 404 Not Found', true, 404);
	
	$SearchMD5 = (!empty($_GET['q'])) ? md5($_GET['q']) : NULL;
	$GETQuery = (!empty($_GET['q'])) ? $_GET['q'] : NULL;
	
	if (empty($SearchMD5) || empty($GETQuery)) {
		die;
	}
	
	if (!$cache->get('search-' . $SearchMD5)) {
	
		if ($AUTH) {
			
			$Search = $db->prepare("
			SELECT * FROM ((SELECT 1 AS ContentType, User.ID AS ContentID, CONCAT(User.AvatarURL, '-thumb.png') AS Image, User.Username AS ResultName, GROUP_CONCAT(UsernameHistory.Username) AS PreviousNames FROM User JOIN UsernameHistory UH ON User.ID = UH.UserID JOIN UsernameHistory ON User.ID = UsernameHistory.UserID WHERE UH.Username = ? AND User.AccountRestricted = 0)
			UNION (SELECT * FROM (SELECT USH.ContentType, USH.ContentID, CASE WHEN USH.ContentType = 0 THEN UserGame.Thumbnail WHEN USH.ContentType = 1 THEN CONCAT(User.AvatarURL, '-thumb.png') WHEN USH.ContentType = 2 THEN Item.PreviewImage WHEN USH.ContentType = 3 THEN UserGroup.LogoImage END AS Image, CASE WHEN USH.ContentType = 0 THEN UserGame.Name WHEN USH.ContentType = 1 THEN User.Username WHEN USH.ContentType = 2 THEN Item.Name WHEN USH.ContentType = 3 THEN UserGroup.Name END AS ResultName, NULL AS PreviousNames FROM UserSearchHistory AS USH JOIN game.UserGame ON UserGame.ID = CASE WHEN USH.ContentType != 0 THEN 1 ELSE USH.ContentID END JOIN User ON User.ID = CASE WHEN USH.ContentType != 1 THEN 1 ELSE USH.ContentID END JOIN Item ON Item.ID = CASE WHEN USH.ContentType != 2 THEN 1 ELSE USH.ContentID END JOIN UserGroup ON UserGroup.ID = CASE WHEN USH.ContentType != 3 THEN 1 ELSE USH.ContentID END WHERE USH.UserID = ".$myU->ID." AND User.AccountRestricted = 0 ORDER BY USH.TimeSearch DESC LIMIT 10) x WHERE ResultName = ?)
			UNION (SELECT 1 AS ContentType, User.ID AS ContentID, CONCAT(User.AvatarURL, '-thumb.png') AS Image, User.Username AS ResultName, NULL AS PreviousNames FROM User WHERE MATCH(User.Username) AGAINST(?) AND User.AccountRestricted = 0)
			UNION (SELECT 2 AS ContentType, Item.ID AS ContentID, Item.PreviewImage AS Image, Item.Name AS ResultName, NULL AS PreviousNames FROM Item WHERE MATCH(Item.Name) AGAINST(?) AND Item.PublicView = 1)
			UNION (SELECT 3 AS ContentType, UserGroup.ID AS ContentID, UserGroup.LogoImage AS Image, UserGroup.Name AS ResultName, UserGroup.SEOName AS PreviousNames FROM UserGroup WHERE MATCH(UserGroup.Name) AGAINST(?))
			UNION (SELECT 0 AS ContentType, UserGame.ID AS ContentID, UserGame.Thumbnail AS Image, UserGame.Name AS ResultName, NULL AS PreviousNames FROM game.UserGame WHERE MATCH(UserGame.Name) AGAINST(?))) x GROUP BY ContentType, ContentID, ResultName
			");
			$Search->bindValue(1, $_GET['q'], PDO::PARAM_STR);
			$Search->bindValue(2, $_GET['q'], PDO::PARAM_STR);
			$Search->bindValue(3, $_GET['q'], PDO::PARAM_STR);
			$Search->bindValue(4, $_GET['q'], PDO::PARAM_STR);
			$Search->bindValue(5, $_GET['q'], PDO::PARAM_STR);
			$Search->bindValue(6, $_GET['q'], PDO::PARAM_STR);
			$Search->execute();
			
			$cache->set('search-' . $SearchMD5, array('results' => $Search->fetchAll(PDO::FETCH_OBJ), 'count' => $Search->rowCount()), 86400);
			
		} else {
			
			$Search = $db->prepare("
			SELECT * FROM ((SELECT 1 AS ContentType, User.ID AS ContentID, CONCAT(User.AvatarURL, '-thumb.png') AS Image, User.Username AS ResultName, GROUP_CONCAT(UsernameHistory.Username) AS PreviousNames FROM User JOIN UsernameHistory UH ON User.ID = UH.UserID JOIN UsernameHistory ON User.ID = UsernameHistory.UserID WHERE UH.Username = ?)
			UNION (SELECT 1 AS ContentType, User.ID AS ContentID, CONCAT(User.AvatarURL, '-thumb.png') AS Image, User.Username AS ResultName, NULL AS PreviousNames FROM User WHERE MATCH(User.Username) AGAINST(?))
			UNION (SELECT 2 AS ContentType, Item.ID AS ContentID, Item.PreviewImage AS Image, Item.Name AS ResultName, NULL AS PreviousNames FROM Item WHERE MATCH(Item.Name) AGAINST(?) AND Item.PublicView = 1)
			UNION (SELECT 3 AS ContentType, UserGroup.ID AS ContentID, UserGroup.LogoImage AS Image, UserGroup.Name AS ResultName, UserGroup.SEOName AS PreviousNames FROM UserGroup WHERE MATCH(UserGroup.Name) AGAINST(?))
			UNION (SELECT 0 AS ContentType, UserGame.ID AS ContentID, UserGame.Thumbnail AS Image, UserGame.Name AS ResultName, NULL AS PreviousNames FROM game.UserGame WHERE MATCH(UserGame.Name) AGAINST(?))) x GROUP BY ContentType, ContentID, ResultName
			");
			$Search->bindValue(1, $_GET['q'], PDO::PARAM_STR);
			$Search->bindValue(2, $_GET['q'], PDO::PARAM_STR);
			$Search->bindValue(3, $_GET['q'], PDO::PARAM_STR);
			$Search->bindValue(4, $_GET['q'], PDO::PARAM_STR);
			$Search->bindValue(5, $_GET['q'], PDO::PARAM_STR);
			$Search->execute();
			
			$cache->set('search-' . $SearchMD5, array('results' => $Search->fetchAll(PDO::FETCH_OBJ), 'count' => $Search->rowCount()), 86400);
			
		}
	
	}
	
	$Search = $cache->get('search-' . $SearchMD5);
	$ResultsArray = array();
	$MatchArray = array();
	
	if ($Search['count'] == 0) {
		
		echo '
		<div class="search-dropdown-error">No results found.</div>
		';
		
	} else {
		
		if ($AUTH) {
			$_SESSION['Search_RecordNextPage'] = 1;
		}
		
		foreach ($Search['results'] as $S) {
			similar_text($S->ResultName, $_GET['q'], $percentage);
			if ($percentage > 20 || $S->ContentType == 1 && !empty($S->PreviousNames)) {
				$ResultsArray[] = array('ContentType' => $S->ContentType, 'ContentID' => $S->ContentID, 'Image' => $S->Image, 'Name' => $S->ResultName, 'Match' => $percentage, 'PreviousNames' => $S->PreviousNames);
				$MatchArray[] = $percentage;
			}
		}
		
		array_multisort($MatchArray, SORT_DESC, $ResultsArray);
		
		if (count($ResultsArray) == 0) {
			
			echo '
			<div class="search-dropdown-title">QUICK RESULTS</div><ul>
			<div class="search-dropdown-error">No results found.</div>
			';
			
		} else {
			
			header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK', true, 200);
			
			echo '
			<ul class="see-all">
				<li>
					<a href="'.$serverName.'/search/?q='.htmlentities(strip_tags($_GET['q'])).'">
						<div class="grid-x grid-margin-x align-middle">
							<div class="shrink cell no-margin">
								<span class="name"><i class="material-icons search-search-icon">search</i></span>
							</div>
							<div class="auto cell no-margin">
								<span class="name">See All Search Results</span>
							</div>
							<div class="shrink cell no-margin right">
								<span class="name"><i class="material-icons">chevron_right</i></span>
							</div>
						</div>
					</a>
				</li>
			</ul>
			<div class="push-10"></div>
			<div class="search-dropdown-title">QUICK RESULTS</div><ul>
			';
		
			$ForLoopCounter = 0;
			
			foreach ($ResultsArray as $key => $Result) {
				
				$ForLoopCounter++;
				
				switch ($Result['ContentType']) {
					case 0:
						$URL = '/games/view/'.$Result['ContentID'].'/'; # To change, depending on final URL link
						break;
					case 1:
						$URL = '/users/'.$Result['Name'].'/';
						break;
					case 2:
						$URL = '/store/view/'.$Result['ContentID'].'/';
						break;
					case 3:
						$URL = '/groups/'.$Result['ContentID'].'/'.$Result['PreviousNames'].'/';
						break;
				}
				
				echo '
				<li>
					<a href="'.$serverName . $URL.'">
						<div class="grid-x grid-margin-x align-middle">
							<div class="shrink cell no-margin">
								<img src="'.$cdnName . $Result['Image'] .'">
							</div>
							<div class="auto cell no-margin">
								<span class="name">'.$Result['Name'].'</span>
								';
								
								if (!empty($Result['PreviousNames']) && $Result['ContentType'] == 1) {
									echo '<span class="previous-names">';
									
									$PreviousNames = explode(',', $Result['PreviousNames']);
									if (($key = array_search($Result['Name'], $PreviousNames)) !== false) {
										unset($PreviousNames[$key]);
									}
									$PreviousNames = array_slice($PreviousNames, 0, 4);
									$PreviousNames = implode(', ', $PreviousNames);
									
									echo 'Previously: '.$PreviousNames.'</span>';
								}
								
								echo '
							</div>
							<div class="shrink cell no-margin right">
								<span class="name"><i class="material-icons">chevron_right</i></span>
							</div>
						</div>
					</a>
				</li>
				';
				
				if ($key >= 9 || $Result['ContentType'] == 1 && $ForLoopCounter == 1) {
					break;
				}
				
			}
		
		}
		
		echo '</ul>';
		
	}