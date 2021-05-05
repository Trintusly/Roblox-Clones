<?php
//header("window.location = 'https://hentaihaven.org'");
if(!isset($bop) || $bop == false)
{
	require_once("/var/www/html/site/bopimo.php");
}
if(!$bop->logged_in())
{
	if($bop->look_for("website", ["id" => 1])->custom == "true" && !isset($ignore))
	{
		die("test");
	}
}

?>
<html>
	<head>
		<title>Bopimo</title>
		<!-- CSS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		<link rel="icon" type="image/png" href="https://www.bopimo.com/css/logo-small.png">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/css/main.css?c=<?=filemtime("/var/www/html/css/main.css")?>" />
		<link rel="stylesheet" type="text/css" href="/css/simplegrid.css?<?=filemtime("/var/www/html/css/simplegrid.css")?>" />
		<link rel="stylesheet" type="text/css" href="/css/tooltipster.bundle.css?<?=filemtime("/var/www/html/css/tooltipster.bundle.css")?>" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700" rel="stylesheet">
		<!-- JS -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="/js/api.js?c=<?=filemtime("/var/www/html/js/api.js")?>"></script>
		<script src="/js/tooltipster.bundle.min.js"></script>
		<script src="/js/main.js"></script>
		<?php if ($bop->isAdmin()) { ?>
			<script src="/js/admin.js"></script>
		<?php } ?>
		<!-- Misc. -->
		<meta content="<?=$bop->getCsrfToken()?>" name="token" />
	</head>
	<body>
		<div class="entire-site" style="min-height:100%;">
		<?php

		if($bop->logged_in())
		{
			$user = $bop->local_info(["username", "id", "admin", "bop"]);
			$username = htmlentities($user->username);
			$blender = new blender;
			$avatar = $bop->look_for("avatar", ["user_id" => $user->id]);
			$test = ($avatar->rendered == "false") ? $blender->renderAvatar($_SESSION['id']) : false;
			$pages = [
			// Name => Link
			"Home" => "/home",
			"Games" => "/games",
			"Forums" => "/forum",
			"Shop" => "/shop",
			"Customize" => "/customize",
			"{$username}" => "/profile/{$user->id}",
			"Bopibits: {$user->bop}" => "/currency",
			"Friends" => "/friends",
			"Settings" => "/account/",
			"Logout" => "/account/logout.php"

			];
		} else {
			$pages = [
			// Name => Link
			"Home" => "/home",
			"Games" => "/games",
			"Forums" => "/forum",
			"Shop" => "/shop",

			"Register" => "/account/register",
			"Login" => "/account/login"
			];
		}

		$middle = round(count($pages)/2);

		?>
		<nav>
			<ul>
				<?php

				$count = 0;
				foreach ($pages as $name => $link) {
					// if count >
					echo ($count == $middle) ?  '<li class="logo"><img src="/images/logo.png"></li>' : '';
					echo '<li><a href="'.$link.'">'.$name.'</a></li>';
					$count++;
				}
				?>
			</ul>
		</nav>
		<div class="grid grid-pad" style="padding-bottom: 150px;padding-right:0px;">
