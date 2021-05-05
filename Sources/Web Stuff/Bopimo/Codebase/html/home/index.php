<?php
$ads = true;
include '/var/www/html/site/bopimo.php';
if(!$bop->logged_in())
{
	die(header("location: /account/login"));
}
$pageName = "Dashboard";
include '/var/www/html/site/header.php';

$avatar = $bop->avatar($_SESSION['id']);

$user = $bop->local_info(["username", "status", "id"]);
?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-9016364683167219",
enable_page_level_ads: true
});
</script>
<div class="banner success hidden">
	[Success]
</div>
<div class="banner danger hidden">
	[Error]
</div>

<div class="content">
	<h1>Welcome back, <?=htmlentities($user->username)?>.</h1>
	<div class="col-4-12 centered">
		<div class="card b">
			<div class="top">
				Your Avatar
			</div>
			<div class="body">
				<image src="https://storage.bopimo.com/avatars/<?=$avatar->cache?>.png" class="image">
					<br>
					<a href="/profile/<?=$user->id?>">Your Profile</a>
			</div>
		</div>
		<div class="card b">
			<div class="top centered" style="background-color:#f3c133;">
				Announcements
			</div>
			<div style="padding: 20px;font-size:1.2rem;">
			<a style="color:#000;" href="https://blog.bopimo.com/bopimo-video-contest/">Bopimo Video Contest</a>
			</div>
		</div>
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Generic Square Ad -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6691594709216274"
     data-ad-slot="9367246644"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
	</div>
	
	<div class="col-8-12">
		<div class="card b">
			<div class="top centered">
				Your Status
			</div>
			<div class="body centered">
				<input class="width-80" id="statusText" value="<?=htmlentities($user->status)?>">
				<a href="#"><div class="button warning" id="statusUpdate">Update</div></a>
			</div>
		</div>
	</div>
	<div class="col-8-12">
		<div class="card b" style="margin-bottom:0px;">
			<div class="top centered">
				Your Friends' Statuses
			</div>
		</div>
		<?php
		$sql = $bop->query("SELECT dashboard.* FROM friends INNER JOIN dashboard ON friends.to = dashboard.user OR friends.from = dashboard.user WHERE (friends.to = ? OR friends.from = ?) AND friends.status = 1 AND dashboard.user != ? ORDER BY `id` DESC LIMIT 0, 7", [$user->id, $user->id, $user->id]);

		if($sql->rowCount() == 0)
		{
			?>
			<div class="card border" style="margin: 5 0px;">
				No results
			</div>
			<?php
		} else {
			foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $d)
			{
				$d = (object) $d;
				$getDashUser = $bop->get_user($d->user);
				$avatar = $bop->avatar($getDashUser->id);
				?>
				<div class="card border" style="margin: 5 0px;">
					<div class="col-2-12 centered">
						<a href="/profile/<?=$getDashUser->id?>">
							<img src="https://storage.bopimo.com/heads/<?=$avatar->headshot?>.png" class="image" style="border-radius:100px;">
							<?=htmlentities($getDashUser->username)?>
						</a>
					</div>
					<div class="col-10-12">
						<?=$bop->bbCode($d->text)?>
					</div>
					<div class="col-10-12" style="font-size:12px;color:grey;">
						<b>Posted: <?=$bop->timeAgo($d->time)?></b>
					</div>
				</div>
				<?php
			}
		}
		?>

	</div>
</div>
<script src="home.js?r=<?=time()?>"></script>
<?php
$bop->footer();
?>
