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
		die(header("location: /maintenance.php"));
	}
} else {
	$user = $bop->local_info();
	if(!$bop->user_exists($_SESSION['id']))
	{
		die(header("/account/logout.php"));
	}
	if($bop->isBanned($user->id) && !isset($bannedPage))
	{
		require("/var/www/html/account/banned.php");
		die();
	}
	/*
	if($user->admin == "0" && !isset($ignore))
	{
		die(header("location: /maintenance.php"));
	}*/
	if(intval($user->nextreward) < time())
	{
		$bop->update_("users", ["nextreward" => time() + 86400, "bop" => $user->bop + 5, "rewarded" => time()], ["id" => $user->id]);
	}
	$bop->update_("users", ["lastseen" => time()], ["id" => $user->id]);
	$nextRewardd = $user->nextreward;
	$nextReward = $user->rewarded;
}
?>
<html>
	<head>
		<title><?=(isset($pageName)) ? $pageName . " - Bopimo" : "Bopimo"?></title>
		<?php
		if(isset($ads)) {
			?>
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<script>
			  (adsbygoogle = window.adsbygoogle || []).push({
			    google_ad_client: "ca-pub-9016364683167219",
			    enable_page_level_ads: true
			  });
			</script>
			<?php
		}
		?>
		<meta charset="UTF-8">
		<meta property="og:site_name" content="bopimo.com">
		<meta property="og:image" content="https://www.bopimo.com/css/logo-small.png">
		<meta name="description" content="Welcome to Bopimo, the free community-based sandbox game. Sign up and play today!">
		<meta name="keywords" content="Bopimo, Bopimo thread, Bopimo Game">
		<meta name="author" content="Bopimo">
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
		<meta name="viewport" content="width=device-width, initial-scale=1">
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
				"left" => [
					"Home" => "/home",
					"Users" => "/users/",
					"Forums" => "/forum",
					"Shop" => "/shop",
					"Community" => "/community",
					"Upgrade" => "/membership",
				],
				"right" => [
					"Invites" => "/invites",
					"Customize" => "/customize",
					"Settings" => "/account/",
					"bop" => "#",
					"Logout" => "/account/logout.php"
				]
			];

			$pendingCount = $bop->query("SELECT COUNT(id) as total FROM friends WHERE friends.to = ? AND friends.status = 0;", [$_SESSION["id"]])->fetchColumn();
			$friendsText = ($pendingCount > 0) ? "Friends (".$pendingCount.")" : "Friends";
			$pages["left"][$friendsText] = "/friends/";

			if ($bop->isAdmin()) {
				$pendingCount = $bop->query("SELECT COUNT(id) AS pending FROM items WHERE verified = ?", [0])->fetchColumn();
				$adminText = ($pendingCount > 0) ? "Admin (".$pendingCount.")" : "Admin";
				$pages["left"][$adminText] = "/admin/";
			}

		} else {
			$pages = [
				"left" => [
					"Home" => "/",
					"Forums" => "/forum",
					"Shop" => "/shop",
					"Users" => "/users",
					"Community" => "/community"
				],
				"right" => [
					"Register" => "/account/register",
					"Login" => "/account/login"
				]
			];
		}

		$middle = round(count($pages)/2);

		?>
		<nav2>
			<div class="logo">

				<img src="https://www.bopimo.com/bopimologochristmas2.png" />
			</div>
			<div class="container">
				<ul>
					<div class="grid">
						<?php
						foreach ($pages as $class => $links) {
						?>
						<div class="<?=$class?>">
						<?php
							foreach ($links as $name => $link) {
							?>
							<li><a href="<?=$link?>" class="<?=strtolower($name)?>"<?=($name == "bop" && $bop->logged_in()) ? " title='".$bop->timeLeft($nextRewardd)."'> Bopibits: {$user->bop}" : ">{$name}"?></a></li>
							<?php
							}
							?>
						</div>
							<?php
						}
						?>
					</div>
				</ul>
			</div>
		</nav2>

		<div class="grid grid-pad" style="padding-bottom: 150px;padding-right:0px;">
			<?php
			if(isset($nextReward)) {
				if(time() - $nextReward <= 60)
				{
					?>
					<div class="banner success">
				    You have received 5 bopibits! Thank you for using our website. (Received <?=time()-$nextReward?> seconds ago)
				  </div>
					<?php
				}
			}
			?>
