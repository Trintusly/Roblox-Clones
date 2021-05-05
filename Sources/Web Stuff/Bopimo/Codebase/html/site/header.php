<?php
require_once("/var/www/html/site/bopimo.php");

if (isset($nogrid)) {
	if ($nogrid) {
		$nogrid = true;
	} else {
	$nogrid = false;
	}
} else {
	$nogrid = false;
}
?>
<html>
	<head>
		<title><?=(isset($pageName)) ? $pageName . " - Bopimo" : "Bopimo"?></title>
		<!-- CSS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		<link rel="icon" type="image/png" href="https://www.bopimo.com/favicon.png">
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

			<script src="/js/admin.js"></script>
		
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-146849607-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-146849607-1');
</script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-6691594709216274",
    enable_page_level_ads: true
  });
</script>

		<!-- Misc. -->
	<!--	<meta content="" name="token" /> -->
	<meta charset="UTF-8">
	<meta property="og:site_name" content="bopimo.com">
	<meta property="og:image" content="https://www.bopimo.com/css/logo-small.png">
	<meta name="description" content="Welcome to Bopimo, the free community-based sandbox game. Sign up and play today!">
	<meta name="keywords" content="Bopimo, Bopimo thread, Bopimo Game">
	<meta name="author" content="Bopimo">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta content="<?=$bop->getCsrfToken()?>" name="token" />
	
	</head>

	<div class="entire-site" style="min-height:100%;">
	<?php
	if($bop->logged_in())
	{
		$localUser = $bop->local_info();
		$user = $localUser;
		if(intval($localUser->nextreward) < time())
		{
			$bop->update_("users", ["nextreward" => time() + 86400, "bop" => $localUser->bop + 5, "rewarded" => time()], ["id" => $localUser->id]);
		}
		/*
		=======VERIFICATION CHECKER
		if(!$bop->isVerified($localUser->id) && !isset($ignore))
		{
			die(header("location: /verification"));
		}
		*/
		if(!$bop->user_exists($_SESSION['id']))
		{
			die(header("/account/logout.php"));
		}
		if($bop->isBanned($localUser->id) && !isset($bannedPage))
		{
			require("/var/www/html/account/banned.php");
			die();
		}
		$bop->update_("users", ["lastseen" => time()], ["id" => $localUser->id]);
		$localAvatar = $bop->avatar($localUser->id);
		$notifications = $bop->query("SELECT COUNT(*) FROM notifications WHERE user=? AND `read`=0", [$_SESSION['id']])->fetchColumn();
		$pages_top = array(
			"left" => [
				"Dashboard" => "/home",
				"Users" => "/users",
				"Forum" => "/forum",
				"Shop" => "/shop",
				"Communities" => "/community"
			],
			"right" => [
				($notifications > 0) ? "Notifications ({$notifications})" : "Notifications" => "/notifications",
				"Invites" => "/invites",
				"Customize" => "/customize",
				"Settings" => "/account/",
				"Logout" => "/account/logout.php"
			]
		);
		$pendingCount = $bop->query("SELECT COUNT(id) as total FROM friends WHERE friends.to = ? AND friends.status = 0;", [$_SESSION["id"]])->fetchColumn();
		$friendsText = ($pendingCount > 0) ? "Friends (".$pendingCount.")" : "Friends";
		$tradeCount = $bop->query("SELECT COUNT(*) as count FROM trades WHERE status = 0 AND to_user = ?", [$_SESSION['id']])->fetchColumn(0);
		$msgCount = $bop->query("SELECT COUNT(id) FROM messages WHERE messages.to = ? AND messages.read = 0;", [$_SESSION["id"]])->fetchColumn();
		$pages_bottom = array(
			"left" => [
					"Profile" => "/profile/{$localUser->id}",
					"Inventory" => "/inventory/{$localUser->id}",
					$friendsText => "/friends",

				],
			"right" => [
				$localUser->username => "#",
				"{$localUser->bop} B$" => "#",
				($tradeCount > 0) ? "Trades ({$tradeCount})" : "Trades" => "/trades",
				($msgCount > 0) ? "Messages ({$msgCount})" : "Messages" => "/messages",
				"Upgrade" => "/membership",
				'img' => "#",
			]
		);
		if ($bop->isAdmin()) {
			$pendingCount = $bop->query("SELECT COUNT(id) AS pending FROM items WHERE verified = ?", [0])->fetchColumn();
			$adminText = ($pendingCount > 0) ? "Admin (".$pendingCount.")" : "Admin";
			$pages_bottom["left"][$adminText] = "/admin/";
		}
	} else {
		$pages_top = array(
			"left" => [
				"Landing" => "/",
				"Users" => "/users",
				"Shop" => "/shop",
				"Communities" => "/community"
			],
			"right" => [
				"Login" => "/account/login",
				"Register" => "/account/register"
			]
		);
	}
	?>
	<body>
			<nav3>
				<ul class='primary'>
					<div class="grid">
						<li><a class='logo'><img style='height: 30px;' src="https://www.bopimo.com/images/logo.png" alt=""></a></li>
						<?php
						foreach($pages_top as $class => $links)
						{
							?>
							<div class="<?=$class?>">
								<?php
								foreach($links as $name => $url)
								{
									?>
									<li><a href='<?=$url?>'><?=$name?></a></li>
									<?php
								}
								?>
							</div>
							<?php
						}
						?>
					</div>
				</ul>
				<?php
				if($bop->logged_in())
				{
					$localUser = $bop->local_info();
					$localAvatar = $bop->avatar($localUser->id);
					?>
					<ul class='secondary'>
						<div class="grid">
						<?php
						foreach($pages_bottom as $class => $links)
						{
							?>
							<div class="<?=$class?>">
							<?php
							foreach($links as $name => $url)
							{
								if($name == "img")
								{
									?>
									<img style="height: 43px;margin-top:3.5px;margin-left:5px;float:left;border-radius:100px;float:left;" src="https://storage.bopimo.com/heads/<?=$localAvatar->headshot?>.png" alt="">
									<?php
								} else {
									?>
									<li><a href='<?=$url?>'><?=$name?></a></li>
									<?php
								}
								?>
								<?php
							}
							?>
							</div>
							<?php
						}
						?>
						</div>
					</ul>
					<?php
				}
				?>
			</nav3>
	<?php 
	if (!$nogrid) {
	?>
	<div class="grid grid-pad" style="padding-bottom: 150px;padding-right:0px;">
	<?php } ?>
<div style='width:100%;padding-bottom:10px;text-align:center;'>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Horizontal -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-6691594709216274"
     data-ad-slot="2221601403"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
	<?php
	if($bop->logged_in())
	{
		if(time() - $localUser->nextreward > 60)
		{
			?>
			<div class="banner success">
				You have received 5 bopibits! Thank you for using our website.
			</div>
			<?php
		}
	}
	?>
