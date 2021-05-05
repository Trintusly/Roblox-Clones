<?php
$page = 'games';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	$GameId = (!empty($_GET['GameId'])) ? $_GET['GameId'] : null;
	$SeoName = (!empty($_GET['SeoName'])) ? $_GET['SeoName'] : null;
	
	if (!$GameId) {
		
		header("Location: ".$serverName."/games/");
		die;
		
	}
	
	$GetUserGame = $db->prepare("SELECT UserGame.ID, UserGame.UserID, UserGame.Name, UserGame.SEOName, UserGame.Description, UserGame.Thumbnail, UserGame.ThumbnailSuccess, UserGame.TimeCreated, UserGame.TimeLastUpdated, UserGame.NumVisits, UserGame.NumInGame, UserGame.AdminLocked, User.Username, User.AvatarURL FROM game.UserGame JOIN User ON UserGame.UserID = User.ID WHERE UserGame.ID = ?");
	$GetUserGame->bindValue(1, $GameId, PDO::PARAM_INT);
	$GetUserGame->execute();
	
	if ($GetUserGame->rowCount() == 0) {
		
		header("Location: ".$serverName."/games/");
		die;
		
	}
	
	$gG = $GetUserGame->fetch(PDO::FETCH_OBJ);
	
	if (!$SeoName) {
		header("Location: ".$serverName."/games/".$gG->ID."/".$gG->SEOName."/");
		die;
	}
	
	$ThumbnailImg = ($gG->ThumbnailSuccess == 1 && $gG->AdminLocked == 0 && !empty($gG->Thumbnail)) ? 'game/thumbnails/'.$gG->Thumbnail : 'game-rejected.png';
	
	echo '
	<meta property="og:title" content="'.htmlentities($gG->Name).'">
	<meta property="og:type" content="game">
	<meta property="og:url" content="'.$serverName.'/games/'.$gG->ID.'/'.$gG->SEOName.'/">
	<meta property="og:image" content="'.$cdnName . $ThumbnailImg.'">
	<meta property="og:site_name" content="Brick Planet">
	<meta property="og:description" content="\''.htmlentities(strip_tags($gG->Name)).'\' is a game on Brick Planet, a user generated content sandbox game with tens of thousands of active players. Play today!">
	<script>
	document.title = "'.htmlentities($gG->Name).' - Brick Planet";
	
	function playGameByType(loadType) {
		$.get("'.$serverName.'/API/Engine/generateGameAuthToken.php?gameId='.$gG->ID.'", function(res, status) {
			var token = res.token;
			loadType = (loadType == "Client" || loadType == "Workshop") ? loadType : "Client";
			window.location.assign("brickplanet:" + loadType + "_" + token);
		});
	}
	</script>
	<div class="success-message">Our game files are now digitally signed, which should resolve common installation and antivirus issues. If you have been unable to install the game, try the new link below.</div>
	<div class="container border-r md-padding">
		<h5 class="text-center">Games are now out in alpha for Windows! To download, <a href="'.$cdnName.'install/1.3/BrickplanetSetup.exe">click here.</a></h5>
		<p style="font-size:13px;text-align:center;font-style:italic;">We are planning on adding support for Mac OS X and Linux in the coming days.</p>
	</div>
	<div class="push-25"></div>
	<div class="grid-x grid-margin-x align-middle">
		<div class="shrink cell no-margin">
			<h3>'.$gG->Name.'</h3>
		</div>
		';
		if ($gG->UserID == $myU->ID) {
			echo '
			<div class="shrink cell no-margin">
				<a href="'.$serverName.'/games/edit/'.$gG->ID.'" class="my-game-settings"><i class="material-icons">settings</i></a>
			</div>
			';
		}
		echo '
	</div>
	<div class="push-10"></div>
	<div class="container border-r lg-padding">
		<div class="grid-x grid-margin-x align-middle">
			<div class="large-8 cell">
				<div class="user-game-large-thumb relative" style="background-image:url('.$cdnName . $ThumbnailImg.');">
				';
				if ($gG->NumInGame > 0) {
					echo '<div class="user-game-ingame"><span>'.shortNum($gG->NumInGame).' In Game</span></div>';
				}
				echo '
				</div>
			</div>
			<div class="large-4 cell text-center">
				<a href="'.$serverName.'/users/'.$gG->Username.'/"><div class="user-game-creator-thumb" style="background-image:url('.$cdnName . $gG->AvatarURL.'-thumb.png);"></div></a>
				<a href="'.$serverName.'/users/'.$gG->Username.'/" class="user-game-creator-name">'.$gG->Username.'</a>
				<div class="push-50"></div>
				<div class="text-center">
					';
					
					if ($AUTH) {
						
						if ($gG->AdminLocked == 0) {
							echo '
							<a class="button button-green user-game-play" onclick="playGameByType(\'Client\')">Play Game</a>
							';
						} else {
							echo 'This game has been locked by a moderator.';
						}

						if ($gG->UserID == $myU->ID) {
							
							echo '
							<div class="push-15"></div>
							<a onclick="playGameByType(\'Workshop\')" class="button button-blue user-game-workshop">Edit in Workshop</a>
							';
							
						}
					
					} else {
						
						if ($gG->AdminLocked == 0) {
							echo '
							<div class="user-game-play" onclick="window.location.assign(\''.$serverName.'/log-in/\')">Play</div>
							';
						}
					}
					
					echo '
				</div>
			</div>
		</div>
		<div class="push-25"></div>
		<div class="grid-x grid-margin-x">
			<div class="large-8 cell">
				<div class="grid-x grid-margin-x align-middle">
					<div class="large-4 cell text-center">
						<div class="item-info-content">'.number_format($gG->NumVisits).'</div>
						<div class="item-info-title">GAME VISITS</div>
					</div>
					<div class="large-4 cell text-center">
						<div class="item-info-content">'.date('M d, Y', $gG->TimeCreated).'</div>
						<div class="item-info-title">CREATED</div>
					</div>
					<div class="large-4 cell text-center">
						<div class="item-info-content">'.date('M d, Y', $gG->TimeLastUpdated).'</div>
						<div class="item-info-title">LAST UPDATED</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	';
	
	if (!empty($gG->Description)) {
		
		echo '
		<div class="push-25"></div>
		<h6>Description</h6>
		<div class="container border-r md-padding">
			'.nl2br($gG->Description).'
		</div>
		';
		
	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");