<?php
$page = 'games';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	$Page = (!empty($_GET['p']) && is_numeric($_GET['p']) && floor((int)$_GET['p']) == (int)$_GET['p']) ? (int)$_GET['p'] : 1;
	
	$GetUserGamesCache = $cache->get('Games_GetGames');
	if (!$GetUserGamesCache) {
		$GetUserGames = $db->prepare("SELECT UserGame.ID, UserGame.Name, UserGame.SEOName, UserGame.ThumbnailMicro, UserGame.ThumbnailSuccess, UserGame.NumInGame, UserGame.AdminLocked, User.Username, User.AvatarURL FROM game.UserGame JOIN User ON User.ID = UserGame.UserID WHERE UserGame.NumInGame > 0 AND User.AccountRestricted = 0 ORDER BY UserGame.NumInGame DESC");
		$GetUserGames->execute();
		$GetUserGamesCache = $GetUserGames->fetchAll(PDO::FETCH_OBJ);
		$cache->set('Games_GetGames', $GetUserGamesCache, 30);
	}
	
	$Limit = 12;
	$Pages = intval(count($GetUserGamesCache)/$Limit);
	
	echo '
	<div class="success-message">Our game files are now digitally signed, which should resolve common installation and antivirus issues. If you have been unable to install the game, try the new link below.</div>
	<div class="container border-r md-padding">
		<h5 class="text-center">Games are now out in alpha for Windows! To download, <a href="'.$cdnName.'install/1.3/BrickplanetSetup.exe">click here.</a></h5>
		<p style="font-size:13px;text-align:center;font-style:italic;">We are planning on adding support for Mac OS X and Linux in the coming days.</p>
	</div>
	<div class="push-15"></div>
	<script>
	document.title = "Games - Brick Planet";
	</script>
	<div class="grid-x grid-margin-x">
		<div class="auto cell">
			<h3>Games</h3>
		</div>
	</div>
	<div class="push-15"></div>
	<div class="grid-x grid-margin-x">
	';
	
	foreach (array_slice($GetUserGamesCache, ($Page-1)*$Limit, $Limit) as $gG) {
	
		$ThumbnailImg = ($gG->ThumbnailSuccess == 1 && $gG->AdminLocked == 0 && !empty($gG->ThumbnailMicro)) ? 'game/thumbnails/'.$gG->ThumbnailMicro : 'game-rejected-micro.png';
	
		echo '
		<div class="large-3 cell">
			<a href="'.$serverName.'/games/'.$gG->ID.'/'.$gG->SEOName.'/">
			<div style="width:100%;height:250px;background-image:url('.$cdnName . $ThumbnailImg.');background-size:cover;background-color:#17171C;" class="relative">
			';
			if ($gG->NumInGame > 0) {
				echo '<div class="user-game-ingame"><span>'.shortNum($gG->NumInGame).' In Game</span></div>';
			}
			echo '
			</div>
			</a>
			<div class="container sm-padding">
				<div class="grid-x grid-margin-x align-middle">
					<div class="shrink cell no-margin">
						<a href="'.$serverName.'/users/'.$gG->Username.'/">
							<div class="user-game-user-thumbnail relative" style="background-image:url('.$cdnName . $gG->AvatarURL.'-thumb.png);"></div>
						</a>
					</div>
					<div class="auto cell no-margin">
						<div class="user-game-info">
							<a href="'.$serverName.'/games/viewGame.php?GameId='.$gG->ID.'" class="ug-info-title">'.$gG->Name.'</a>
							<div class="ug-info-creator">By <a href="'.$serverName.'/users/'.$gG->Username.'/">'.$gG->Username.'</a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="push-25"></div><div class="push-10"></div>
		</div>
		';
	
	}
	
	echo '</div>';
	
	if ($Pages > 1) {

		echo '
		<div class="push-25"></div>
		<ul class="pagination" role="navigation" aria-label="Pagination">
			<li class="pagination-previous'; if ($Page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/games/?p='.($Page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
			';

			for ($i = max(1, $Page - 5); $i <= min($Page + 5, $Pages); $i++) {

				if ($i <= $Pages) {

					echo '<li'; if ($Page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/games/?p='.($i).'">'.$i.'</a></li>';

				}

			}

			echo '
			<li class="pagination-next'; if ($Page == $Pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/games/?p='.($Page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
		</ul>
		';

	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
