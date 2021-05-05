<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");
	
	$Category = (!empty($_GET['c']) && ($_GET['c'] == 1 || $_GET['c'] == 2 || $_GET['c'] == 3 || $_GET['c'] == 4)) ? (int)$_GET['c'] : 1;
	$SearchQuery = (!empty($_GET['q'])) ? htmlentities(strip_tags($_GET['q'])) : NULL;
	$Page = (!empty($_GET['p']) && is_numeric($_GET['p']) && floor((int)$_GET['p']) == (int)$_GET['p']) ? (int)$_GET['p'] : 1;
	
	if ($Category == 1) {
		
		$CountQuery = $db->prepare("
		SELECT COUNT(*) FROM ((SELECT User.ID, User.AvatarURL, User.Username, User.About, GROUP_CONCAT(UsernameHistory.Username) AS PreviousNames FROM User JOIN UsernameHistory UH ON User.ID = UH.UserID JOIN UsernameHistory ON User.ID = UsernameHistory.UserID WHERE MATCH(UH.Username) AGAINST(?) AND User.AccountRestricted = 0 GROUP BY User.ID)
		UNION (SELECT User.ID, User.AvatarURL, User.Username, User.About, NULL AS PreviousNames FROM User WHERE MATCH(User.Username) AGAINST(?) AND User.AccountRestricted = 0 GROUP BY User.ID)
		) x GROUP BY ID
		");
		$CountQuery->bindValue(1, $SearchQuery, PDO::PARAM_STR);
		$CountQuery->bindValue(2, $SearchQuery, PDO::PARAM_STR);
		$CountQuery->execute();
		$QueryRowCount = $CountQuery->fetchColumn();
		
		$Limit = 15;
		$Pages = ceil($QueryRowCount / $Limit);
		$Offset = ($Page - 1) * $Limit;
		if ($Offset < 0) { $Offset = 0; }
		
		$Query = $db->prepare("
		SELECT * FROM ((SELECT User.ID, User.AvatarURL, User.Username, User.About, GROUP_CONCAT(UsernameHistory.Username) AS PreviousNames, User.TimeLastSeen FROM User JOIN UsernameHistory UH ON User.ID = UH.UserID JOIN UsernameHistory ON User.ID = UsernameHistory.UserID WHERE MATCH(UH.Username) AGAINST(?) AND User.AccountRestricted = 0 GROUP BY User.ID)
		UNION (SELECT User.ID, User.AvatarURL, User.Username, User.About, NULL AS PreviousNames, User.TimeLastSeen FROM User WHERE MATCH(User.Username) AGAINST(?) AND User.AccountRestricted = 0 GROUP BY User.ID)
		) x GROUP BY ID LIMIT ? OFFSET ?
		");
		$Query->bindValue(1, $SearchQuery, PDO::PARAM_STR);
		$Query->bindValue(2, $SearchQuery, PDO::PARAM_STR);
		$Query->bindValue(3, $Limit, PDO::PARAM_INT);
		$Query->bindValue(4, $Offset, PDO::PARAM_INT);
		$Query->execute();
		
		if ($QueryRowCount == 0) {
			
			echo '<div class="search-no-results">We\'re sorry, no results were found.</div>';
			
		} else {
		
			echo '<div class="grid-x grid-margin-x">';
			
			while ($Q = $Query->fetch(PDO::FETCH_OBJ)) {
				
				if (empty($Q->ID)) {
					continue;
				}
				
				$UserOnlineColor = ($Q->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
				$StatusSpan = '<div class="user-online-status no-margin" style="background:#'.$UserOnlineColor.';display:block;" title="Last seen '.get_timeago($Q->TimeLastSeen).'"></div>';
				
				echo '
				<div class="large-4 cell">
					<div class="container border-r md-padding">
						<div class="grid-x grid-margin-x">
							<div class="large-5 cell">
								<a href="'.$serverName.'/users/'.$Q->Username.'/"><img src="'.$cdnName . $Q->AvatarURL.'.png"></a>
							</div>
							<div class="large-7 cell">
								<div class="grid-x grid-margin-x align-middle">
									<div class="auto cell no-margin">
										<a href="'.$serverName.'/users/'.$Q->Username.'/" class="search-user-name">'.$Q->Username.'</a>
									</div>
									<div class="shrink cell no-margin right">
										'.$StatusSpan.'
									</div>
								</div>
								<div class="search-user-about">'.LimitTextByCharacters($Q->About, 128).'</div>
							</div>
						</div>
					</div>
					<div class="push-25"></div>
				</div>
				';
				
			}
			
			echo '</div>';
			
			if ($Pages > 1) {

				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($Page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.($Page - 1).')">Previous <span class="show-for-sr">page</span>'; } echo '</li>
					';

					for ($i = max(1, $Page - 5); $i <= min($Page + 5, $Pages); $i++) {

						if ($i <= $Pages) {

							echo '<li'; if ($Page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.$i.')">'.$i.'</li>';

						}

					}

					echo '
					<li class="pagination-next'; if ($Page == $Pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.($Page + 1).')">Next <span class="show-for-sr">page</span>'; } echo '</li>
				</ul>
				';

			}
		
		}
		
		
	} else if ($Category == 2) {
		
		$CountQuery = $db->prepare("SELECT COUNT(*) FROM game.UserGame WHERE MATCH(UserGame.Name) AGAINST(?)");
		$CountQuery->bindValue(1, $SearchQuery, PDO::PARAM_STR);
		$CountQuery->execute();
		$QueryRowCount = $CountQuery->fetchColumn();
		
		$Limit = 15;
		$Pages = ceil($QueryRowCount / $Limit);
		$Offset = ($Page - 1)  * $Limit;
		if ($Offset < 0) { $Offset = 0; }
		
		$Query = $db->prepare("SELECT UserGame.ID, UserGame.Thumbnail, UserGame.Name, UserGame.Description FROM game.UserGame WHERE MATCH(UserGame.Name) AGAINST(?) LIMIT ? OFFSET ?");
		$Query->bindValue(1, $SearchQuery, PDO::PARAM_STR);
		$Query->bindValue(2, $Limit, PDO::PARAM_INT);
		$Query->bindValue(3, $Offset, PDO::PARAM_INT);
		$Query->execute();
		
		if ($QueryRowCount == 0) {
			
			echo '<div class="search-no-results">We\'re sorry, no results were found.</div>';
			
		} else {
		
			echo '<div class="grid-x grid-margin-x">';
			
			while ($Q = $Query->fetch(PDO::FETCH_OBJ)) {
				
				echo '
				<div class="large-4 cell">
					<div class="container border-r md-padding">
						<div class="grid-x grid-margin-x">
							<div class="large-5 cell">
								<a href="#"><img src="'.$cdnName . $Q->Thumbnail.'"></a>
							</div>
							<div class="large-7 cell">
								<a href="#" class="search-item-name">'.$Q->Name.'</a>
								<div class="search-item-about">'.LimitTextByCharacters($Q->Description, 128).'</div>
							</div>
						</div>
					</div>
					<div class="push-25"></div>
				</div>
				';
				
			}
			
			echo '</div>';
			
			if ($Pages > 1) {

				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($Page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.($Page - 1).')">Previous <span class="show-for-sr">page</span>'; } echo '</li>
					';

					for ($i = max(1, $Page - 5); $i <= min($Page + 5, $Pages); $i++) {

						if ($i <= $Pages) {

							echo '<li'; if ($Page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.$i.')">'.$i.'</li>';

						}

					}

					echo '
					<li class="pagination-next'; if ($Page == $Pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.($Page + 1).')">Next <span class="show-for-sr">page</span>'; } echo '</li>
				</ul>
				';

			}
		
		}
		
	} else if ($Category == 3) {
		
		$CountQuery = $db->prepare("SELECT COUNT(Item.ID) FROM Item JOIN User ON Item.CreatorID = User.ID WHERE MATCH(Item.Name) AGAINST(?) AND Item.PublicView = 1");
		$CountQuery->bindValue(1, $SearchQuery, PDO::PARAM_STR);
		$CountQuery->execute();
		$QueryRowCount = $CountQuery->fetchColumn();
		
		$Limit = 15;
		$Pages = ceil($QueryRowCount / $Limit);
		$Offset = ($Page - 1)  * $Limit;
		if ($Offset < 0) { $Offset = 0; }
		
		$Query = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.TimeUpdated, Item.Cost, Item.CostCredits, Item.SaleActive, Item.PreviewImage, User.Username FROM Item JOIN User ON Item.CreatorID = User.ID WHERE MATCH(Item.Name) AGAINST(?) AND Item.PreviewImage NOT IN('pending.png', 'rejected.png') AND Item.PublicView = 1 ORDER BY Item.NumberCopies DESC, Item.TimeUpdated DESC LIMIT ? OFFSET ?");
		$Query->bindValue(1, $SearchQuery, PDO::PARAM_STR);
		$Query->bindValue(2, $Limit, PDO::PARAM_INT);
		$Query->bindValue(3, $Offset, PDO::PARAM_INT);
		$Query->execute();
		
		if ($QueryRowCount == 0) {
			
			echo '<div class="search-no-results">We\'re sorry, no results were found.</div>';
			
		} else {
		
			echo '<div class="container border-wh"><div class="grid-x grid-margin-x">';
			
			while ($Q = $Query->fetch(PDO::FETCH_OBJ)) {
				
				echo '
				<div class="large-custom-2-4 medium-4 small-6 cell">
					<div class="border-r store-item-card">
						<div class="card-image" style="position:relative;">
							';
							
							if ($Q->Username == "Brick Create") {
								echo '
								<div class="official-item-parent">
									<div class="official-item-image" title="Official item sold by Brick Create"></div>
								</div>
								';
							}
							
							echo '
							<a href="'.$serverName.'/store/view/'.$Q->ID.'/"><img src="'.$cdnName . $Q->PreviewImage.'"></a>	
						</div>
						<div class="card-divider"></div>
						<div class="card-body">
							<div class="grid-x grid-margin-x">
								<div class="auto cell">
									<div class="card-item-name"><a href="'.$serverName.'/store/view/'.$Q->ID.'/" title="'.htmlentities(strip_tags($Q->Name)).'">'.LimitTextByCharacters($Q->Name, 22).'</a></div>
								</div>
							</div>
							<div class="grid-x grid-margin-x align-middle">
								<div class="auto cell text-left">
									<div class="card-item-creator">
										<a href="'.$serverName.'/users/'.$Q->Username.'/">'.$Q->Username.'</a>
									</div>
								</div>
								<div class="shrink cell text-right">
									';
									if ($Q->SaleActive == 1 && $Q->Cost > 0 && $Q->ItemType != 7) {
										echo '
										<div class="card-item-price" title="'.number_format($Q->Cost).' Bits"><span><img src="'.$serverName.'/assets/images/bits-sm.png"></span><span>'.number_format($Q->Cost).'</span></div>
										';
									} else if ($Q->SaleActive == 1 && $Q->Cost < 1 && $Q->ItemType != 7) {
										echo '
										<div class="card-item-price"><font class="coins-text">Free</font></div>
										';
									} else if ($Q->ItemType == 7) {
										echo '
										<div class="card-item-price" title="'.number_format($Q->CostCredits).' Credits"><span><img src="'.$serverName.'/assets/images/credits-sm.png"></span><span>'.number_format($Q->CostCredits).'</span></div>
										';
									}
									echo '
								</div>
							</div>
						</div>
					</div>
				</div>
				';
				
			}
			
			echo '</div>';
			
			if ($Pages > 1) {

				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($Page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.($Page - 1).')">Previous <span class="show-for-sr">page</span>'; } echo '</li>
					';

					for ($i = max(1, $Page - 5); $i <= min($Page + 5, $Pages); $i++) {

						if ($i <= $Pages) {

							echo '<li'; if ($Page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.$i.')">'.$i.'</li>';

						}

					}

					echo '
					<li class="pagination-next'; if ($Page == $Pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.($Page + 1).')">Next <span class="show-for-sr">page</span>'; } echo '</li>
				</ul>
				<div class="push-25"></div>
				';

			}
			
			echo '</div>';
		
		}
		
	} else if ($Category == 4) {
		
		$CountQuery = $db->prepare("SELECT COUNT(*) FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) WHERE MATCH(UserGroup.Name) AGAINST(?)");
		$CountQuery->bindValue(1, $SearchQuery, PDO::PARAM_STR);
		$CountQuery->execute();
		$QueryRowCount = $CountQuery->fetchColumn();
		
		$Limit = 15;
		$Pages = ceil($QueryRowCount / $Limit);
		$Offset = ($Page - 1)  * $Limit;
		if ($Offset < 0) { $Offset = 0; }
		
		$Query = $db->prepare("SELECT UserGroup.ID, UserGroup.Name, UserGroup.SEOName, UserGroup.Description, UserGroup.IsVerified, (CASE WHEN UserGroup.OwnerType = 0 THEN User.Username ELSE UG.Name END) AS OwnerName, UserGroup.OwnerID, UserGroup.OwnerType, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, UserGroup.JoinType, UserGroup.MemberCount FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) WHERE MATCH(UserGroup.Name) AGAINST(?) ORDER BY UserGroup.MemberCount DESC LIMIT ? OFFSET ?");
		$Query->bindValue(1, $SearchQuery, PDO::PARAM_STR);
		$Query->bindValue(2, $Limit, PDO::PARAM_INT);
		$Query->bindValue(3, $Offset, PDO::PARAM_INT);
		$Query->execute();
		
		if ($QueryRowCount == 0) {
			
			echo '<div class="search-no-results">We\'re sorry, no results were found.</div>';
			
		} else {
		
			echo '<div class="container md-padding border-r">';
			
			$i = 0;
			
			while ($Q = $Query->fetch(PDO::FETCH_OBJ)) {
				
				$i++;

				if ($i > 1) {
					echo '<div class="group-divider"></div>';
				}
				
				echo '
				<div class="grid-x grid-margin-x group-table">
					<div class="large-2 medium-3 small-4 cell center-text">
						<a href="'.$serverName.'/groups/'.$Q->ID.'/'.str_replace(' ', '-', $Q->Name).'/" class="gt-link">
							<img src="'.$cdnName . $Q->LogoImage.'">
						</a>
						<div class="clearfix gt-info">
							<div class="left">
								<strong>Owner:</strong>
							</div>
							<div class="right">
								';

								if ($Q->OwnerID == -1) {

									echo '<strong>No One</strong>';

								} else if ($Q->OwnerType == 0) {

									echo '<a href="'.$serverName.'/users/'.$Q->OwnerName.'/">'.$Q->OwnerName.'</a>';

								} else {

									echo '<a href="'.$serverName.'/groups/'.$Q->OwnerID.'/'.str_replace(' ', '-', $Q->OwnerName).'/">'.$Q->OwnerName.'</a>';

								}

								echo '
							</div>
						</div>
						<div class="clearfix gt-info">
							<div class="left">
								<strong>Members:</strong>
							</div>
							<div class="right">
								'.number_format($Q->MemberCount).'
							</div>
						</div>
					</div>
					<div class="large-10 medium-9 small-8 cell">
						<div class="gt-title"><a href="'.$serverName.'/groups/'.$Q->ID.'/'.$Q->SEOName.'/"><span>'.$Q->Name.'</span>'; if ($Q->IsVerified == 1) { echo '<span><a href="https://helpme.brickcreate.com/hc/en-us/articles/115003048633" target="_BLANK"><div style="display:inline;padding-left:7px;"><span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" title="This group is verified."><img src="/assets/images/groups/verified-ico32x32.png" style="height:20px;width:20px;"></span></div></a></span>'; } echo '</a></div>
						<div class="gt-description">'.LimitTextByWords($Q->Description, 100).'</div>
					</div>
				</div>
				';
				
			}
			
			echo '</div>';
			
			if ($Pages > 1) {

				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($Page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.($Page - 1).')">Previous <span class="show-for-sr">page</span>'; } echo '</li>
					';

					for ($i = max(1, $Page - 5); $i <= min($Page + 5, $Pages); $i++) {

						if ($i <= $Pages) {

							echo '<li'; if ($Page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.$i.')">'.$i.'</li>';

						}

					}

					echo '
					<li class="pagination-next'; if ($Page == $Pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '" onclick="searchByCategory(\''.$SearchQuery.'\', '.$Category.', '.($Page + 1).')">Next <span class="show-for-sr">page</span>'; } echo '</li>
				</ul>
				';

			}
		
		}
		
	}
	
	