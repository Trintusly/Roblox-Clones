<?php
$page = 'games';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	//$GetUserGames = $db->prepare("SELECT Name, Thumbnail, InGame FROM game.UserGame JOIN User ON User.ID = UserGame.UserID WHERE UserGame.InGame > 0 ORDER BY InGame DESC");
	$GetUserGames = $db->prepare("SELECT UserGame.Name, UserGame.Thumbnail, UserGame.NumInGame, User.Username, User.AvatarURL FROM game.UserGame JOIN User ON User.ID = UserGame.UserID ORDER BY UserGame.NumInGame DESC");
	$GetUserGames->execute();
	
	echo '
	<script>
	document.title = "Games - Brick Create";
	</script>
	<div class="grid-x grid-margin-x">
		<div class="auto cell">
			<h3>Games</h3>
		</div>
	</div>
	<div class="push-15"></div>
	<div class="grid-x grid-margin-x">
	';
	
	while ($gG = $GetUserGames->fetch(PDO::FETCH_OBJ)) {
	
		echo '
		<div class="large-3 cell">
			<div style="width:100%;height:250px;background-image:url(https://thumb.gyazo.com/thumb/1200/_490714a7299e283ce6c335cf125918bc-png.jpg);background-size:cover;background-color:#17171C;" class="relative">
			';
			if ($gG->NumInGame > 0) {
				echo '<div class="user-game-ingame"><span>'.shortNum($gG->NumInGame).' In-Game</span></div>';
			}
			echo '
			</div>
			<div class="container sm-padding">
				<div class="grid-x grid-margin-x align-middle">
					<div class="shrink cell no-margin">
						<a href="'.$serverName.'/users/'.$gG->Username.'/">
							<div class="user-game-user-thumbnail relative" style="background-image:url('.$cdnName . $gG->AvatarURL.'-thumb.png);"></div>
						</a>
					</div>
					<div class="auto cell no-margin">
						<div class="user-game-info">
							<a href="'.$serverName.'/users/'.$gG->Username.'/" class="ug-info-title">'.$gG->Name.'</a>
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

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
