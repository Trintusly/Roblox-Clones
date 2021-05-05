<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	$GroupID = (int)$_GET['id'];
	
	$countDivisions = $db->prepare("SELECT DivisionCount FROM UserGroup WHERE ID = ? AND IsDisabled = 0");
	$countDivisions->bindValue(1, $GroupID, PDO::PARAM_INT);
	$countDivisions->execute();
	$countDivision = $countDivisions->fetch(PDO::FETCH_OBJ);
	
	if ($countDivisions->rowCount() == 0 || $countDivision->DivisionCount == 0) {
		
		echo '
		<div class="grid-x grid-margin-x">
			<div class="auto cell">
				No divisions found.
			</div>
		</div>
		';
		
	} else {
		
		$limit = 8;
		
		$pages = ceil($countDivision->DivisionCount / $limit);
			
		$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
			
		$offset = ($page - 1)  * $limit;
		if ($offset < 0) { $offset = 0; }
	
		$getDivisionsByGroupId = $db->prepare("SELECT UserGroup.ID, UserGroup.Name, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage FROM UserGroup WHERE UserGroup.OwnerID = ? AND UserGroup.OwnerType = 1 LIMIT ? OFFSET ?");
		$getDivisionsByGroupId->bindValue(1, $GroupID, PDO::PARAM_INT);
		$getDivisionsByGroupId->bindValue(2, $limit, PDO::PARAM_INT);
		$getDivisionsByGroupId->bindValue(3, $offset, PDO::PARAM_INT);
		$getDivisionsByGroupId->execute();
		
		echo '<div class="grid-x grid-margin-x view-group-division">';
		
		while ($gD = $getDivisionsByGroupId->fetch(PDO::FETCH_OBJ)) {
		
			echo '
			<div class="large-3 cell">
				<a href="'.$serverName.'/groups/'.$gD->ID.'/'.str_replace(' ', '-', $gD->Name).'/"><img src="'.$cdnName . $gD->LogoImage.'"></a>
				<a href="'.$serverName.'/groups/'.$gD->ID.'/'.str_replace(' ', '-', $gD->Name).'/" class="view-group-division-name">'.$gD->Name.'</a>
			</div>
			';
		
		}
		
		echo '</div>';
		
		if ($pages > 1) {
		
			echo '
			<div class="push-25"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="#" onclick="getDivisions('.($page-1).')">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
				';

				for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
					
					if ($i <= $pages) {
					
						echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="#" onclick="getDivisions('.($i).')">'.$i.'</a></li>';

					}
					
				}

				echo '
				<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="#" onclick="getDivisions('.($page+1).')">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
			</ul>
			';
		
		}
		
	}