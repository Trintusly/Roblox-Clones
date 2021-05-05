<?php
$nogrid = true;
include "site/header.php";

/*
yes i yeeted your code from the other landing page because I was lazy
*/

$players = $bop->query("SELECT COUNT(*) FROM users", [])->fetchColumn();
$randPlayers = $bop->query("SELECT * FROM users WHERE hidden=0 AND lastseen > 0 ORDER BY RAND() LIMIT 0, 5", [], true);

$itemCount = $bop->query("SELECT COUNT(*) FROM items", [])->fetchColumn();
$randItems = $bop->query("SELECT * FROM items WHERE verified=1 ORDER BY RAND() LIMIT 0, 5", [], true);

$communities = $bop->query("SELECT COUNT(*) FROM community", [])->fetchColumn();
$randCommunities = $bop->query("SELECT * FROM community WHERE pending=1 ORDER BY members DESC LIMIT 0, 8", [], true);

?>
<div style="overflow:auto;margin-bottom:125px;">
<div class="landing-black">
	<div class="grid grid-pad" style="text-align:center;padding:1.5rem;">
		<div style="overflow:auto;padding-bottom:20px;">
			<img src="https://www.bopimo.com/beanlogo.png" style="min-width:200px;width:34%;" alt="Logo">
		</div>
		<div>
		<a href="/account/login/" class="landing-button" style="margin-right:20px">Login</a>
		<a href="/account/register/" class="landing-button blurple">Register</a>
		</div>
	</div>
</div>
<div class="grid grid-pad" style="padding:1.5rem;">
	<div class="col-1-3" style="text-align:right;">
		<div class="page-title">Shop</div>
		<div class="description">Buy, sell, and trade items with our shop</div>
	</div>
	<div class="col-2-3">
		<?php
		$items = [1832, 1854, 2109, 1893, 1147, 781, 611, 1802];
		?>
		<?php foreach($items as $id) { ?>
			<div class="col-3-12">
				<div class="shop-item">
					<img style="width:100%;" src="https://storage.bopimo.com/thumbnails/<?=$id?>.png" />
				</div>
			</div>
		<?php } ?>
		<div class="col-3-12"></div>
	</div>
</div>
<div class="landing-black">
	<div class="grid grid-pad" style="text-align:center;padding:1.5rem;">
		<div class="col-2-3">
			<?php foreach($randCommunities as $community) { ?>
				<div class="col-3-12">
					<div class="shop-item shop-item-dark">
						<img style="width:100%;" src="https://storage.bopimo.com/community/<?=$community['cache']?>.png" alt="">
					</div>
				</div>
			<?php } ?>
			<div class="col-3-12"></div>
		</div>
		<div class="col-1-3" style="text-align:left;">
			<div class="page-title">Communities</div>
			<div class="description">Discuss topics with the community by joining a community</div>
		</div>
	</div>
</div>
<div class="grid grid-pad" style="padding:1.5rem;text-align:center;">
	<div class="col-1-3">
		<div class="page-title"><?=$players?></div>
		<div>Users</div>
	</div>
	<div class="col-1-3">
		<div class="page-title"><?=$itemCount?></div>
		<div>Items</div>
	</div>
	<div class="col-1-3">
		<div class="page-title"><?=$communities?></div>
		<div>Communities</div>
	</div>
</div>
</div>
<div>
<?php
$bop->footer();
?>
