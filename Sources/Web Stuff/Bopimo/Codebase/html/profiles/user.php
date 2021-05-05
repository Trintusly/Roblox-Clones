<?php
$ads = true;

$uid = intval($_GET['id']);
if($uid == 0)
{
	require("/var/www/html/error/404.php");
	die();
}

require("../site/bopimo.php");

if(!$bop->user_exists($uid))
{
	require("/var/www/html/error/404.php");
	die();
}
$user = $bop->get_user($uid);
if($bop->isBanned($user->id))
{
	require("/var/www/html/error/404.php");
	die();
}

require("/var/www/html/api/shop/shop.php");
$pageName = htmlentities($bop->trueUsername($uid));
require("../site/header.php");

$localUser = $bop->local_info();
$wishlist = $shop->getWishlist($user->id, true);
$user = $bop->get_user($uid);
$count = $bop->query("SELECT COUNT(*) FROM `friends` WHERE (`to`=? OR `from`=?) AND status=1", [$user->id, $user->id])->fetch()[0];
$avatar = $bop->avatar($user->id);
?>

<div class="banner success hidden">
	[Success]
</div>
<div class="banner danger hidden">
	[Error]
</div>

<div class="hidden" id="uid" data-id="<?=$user->id?>"></div>
<div class="content">
	<div class="page-title"><?=($bop->logged_in() && $user->id == $_SESSION['id']) ? "Your Profile" : $bop->trueUsername($uid) . "'s Profile"?></div>
	<div class="col-1-1">
		<div class="card border" style="line-height:60px;">
			<img src="https://storage.bopimo.com/heads/<?=$avatar->headshot?>.png" height="60" style="border-radius:100px;float:left;margin-right:5px;"><span style="float:left;" title="Status"><?=htmlentities($user->status)?></span>
		</div>
	</div>
	<div class="col-4-12">
		<div class="card b centered">
			<div class="top">Avatar</div>
			<div class="body">
				<img src="https://storage.bopimo.com/avatars/<?=$user->avatar?>.png" class="image">
				<br>
				<div id="buttonHolder">
				<br>
				<b><u>Statistics:</u></b>
				<br>
				<div style="text-align:left;width:100%;">
					<b><?=(time() - $user->lastseen >= 30) ? "<center><font color='red'>Offline</font>" : "<font color='green'>Online</font></center>"?></b>
					<br>
					Joined: <b><?=substr($user->joined, 5, 2) . "/" . substr($user->joined, 8, 2) . "/" . substr($user->joined, 0, 4)?></b>
					<br>
					Total Posts: <b><?=$user->posts?></b>
					<br>
					Reputation: <b><?=$user->upvotes?></b>
				</div>
				<?php
				if($bop->logged_in() && $user->id != $localUser->id)
				{
					?>
					<a class="button success" href="/messages/compose/?id=<?=$user->id?>">Message</a>
					<?php
					$friend = $bop->query("SELECT * FROM friends WHERE (`to`=? AND `from`=?) OR (`to`=? AND `from`=?)", [$localUser->id, $user->id, $user->id, $localUser->id])->fetchAll();

					if(empty($friend) && $user->id != $localUser->id)
					{
						?>
						<div uid="<?=$user->id?>" class="button success" id="friend" title="Send a friend request to <?=htmlentities($bop->trueUsername($uid))?>.">Friend</div>
						<?php
					} elseif(!empty($friend)) {
						$friend = (object) $friend[0];
						if($friend->status == "0")
						{
							?>
							<div uid="<?=$user->id?>" class="button warning" id="cancel" title="Cancel friend request to <?=htmlentities($bop->trueUsername($uid))?>.">Cancel</div>
							<?php
						} elseif($friend->status == "1") {
							?>
							<div uid="<?=$user->id?>" class="button danger" id="unfriend" title="Unfriend <?=htmlentities($bop->trueUsername($uid))?>.">Unfriend</div>
							<?php
						} elseif ($friend->status == "-1") {
							?>
							<div uid="<?=$user->id?>" class="button success" id="friend" title="Send a friend request to <?=htmlentities($bop->trueUsername($uid))?>.">Friend</div>
							<?php
						}
					}
				}
				if($bop->logged_in())
				{
					$localUser = $bop->local_info();
					if($bop->isAllowed($localUser->id))
					{
						?>
						<a href="/admin/hideUsername.php?id=<?=$uid?>" class="button warning">Censor</a><a href="/admin/reRender.php?id=<?=$uid?>" class="button warning">Re-Render</a>
						<?php
					}
				}
				?>
				</div>
			</div>
		</div>
		<div class="card b centered">
			<div class="top">Currently Wearing</div>
			<div class="body" id="wearing">
				<fieldset>
					<legend>
						Hats
					</legend>
					<div class="col-1-3"><a href="#"><img src="https://storage.bopimo.com/thumbnails/1.png" id="hat1" class="width-100" /></a></div>
					<div class="col-1-3"><a href="#"><img src="https://storage.bopimo.com/thumbnails/1.png" id="hat2" class="width-100" /></a></div>
					<div class="col-1-3" style="padding-right:20px;"><a href="#"><img src="https://storage.bopimo.com/thumbnails/1.png" id="hat3" class="width-100" /></a></div>
				</fieldset>
				<div class="width-333 left centered">
					<fieldset>
						<legend>
							Face
						</legend>
						<div style=""><a href="#"><img src="https://storage.bopimo.com/thumbnails/1.png" id="face" class="width-100" /></a></div>
					</fieldset>
				</div>
				<div class="width-333 left centered">
					<fieldset>
						<legend>
							T-Shirt
						</legend>
						<div style=""><a href="#"><img src="https://storage.bopimo.com/thumbnails/1.png" id="tshir" class="width-100" /></a></div>
					</fieldset>
				</div>
				<div  class="width-333 left centered">
						<fieldset>
							<legend>
								Shirt
							</legend>
							<div style=""><a href="#"><img src="https://storage.bopimo.com/thumbnails/1.png" id="shirt" class="width-100" /></a></div>
						</fieldset>
				</div>
				<div class="width-333 left centered">
					<fieldset>
						<legend>
							Pants
						</legend>
						<div style=""><a href="#"><img src="https://storage.bopimo.com/thumbnails/1.png" id="pants" class="width-100" /></a></div>
					</fieldset>
				</div>
				<div class="width-333 left centered">
					<fieldset>
						<legend>
							Tool
						</legend>
						<div style=""><a href="#"><img src="https://storage.bopimo.com/thumbnails/1.png" id="tool" class="width-100" /></a></div>
					</fieldset>
				</div>
				</div>
				<?php if($bop->logged_in())
				{
					if($user->id != $localUser->id)
					{
						?>
						<a href="/trade-with/<?=$user->id?>" style="margin-bottom:10px;" class="button success width-50">Trade</a>
						<?php
					}
				}
				?>
		</div>
		<?php /*
		<div class="card b centered">
			<div class="top">Badges</div>
			<div class="body">

			</div>
		</div>
		*/ ?>
	</div>
	<div class="col-8-12">
		<div class="card b">
			<div class="top centered"> Bio</div>
			<div class="body" style="height:300px;overflow:auto;">
				<?=nl2br($bop->bbCode($user->bio))?>
			</div>
		</div>
		<div class="card b">
			<div class="top centered">Friends (<?=$count?>)</div>
			<div class="body">
				<div class="col-1-1">
					<?php
					$friends = $bop->query("SELECT DISTINCT(a.cache), a.user_id, u.username FROM `friends` as f, `avatar` as a, `users` as u WHERE ((f.to=? AND a.user_id=f.from) OR (f.from=? AND a.user_id=f.to)) AND f.status=1 AND u.id=a.user_id ORDER BY RAND() LIMIT 0, 10", [$user->id, $user->id]);
					foreach($friends as $friend)
					{
						$friend = (object) $friend;
						?>
						<div class="col-1-5 centered" style="padding-right:0;">
							<a style="color:black;" href="/profile/<?=$friend->user_id?>">
								<img src="https://storage.bopimo.com/avatars/<?=$friend->cache?>.png" style="width:100%;">
								<?=$bop->trueUsername($friend->user_id)?>
							</a>
						</div>
						<?php
					}
					?>
				</div>
				<?php
				$communityCount = $bop->query("SELECT COUNT(*) FROM community_member WHERE uid=? AND banned=0 LIMIT 0,4", [$user->id])->fetchColumn();
				$communities = $bop->query("SELECT community.* FROM community INNER JOIN community_member ON community_member.cid = community.id WHERE community_member.uid = ? AND community_member.banned = 0 LIMIT 0,4", [$user->id], true);
				?>
				<div class="col-1-1 centered">
					<a class="button success" href="/friends/<?=$user->id?>/1">View All</a>
				</div>
			</div>
		</div>
		<div class="card b">
			<div class="top centered">Communities (<?=$communityCount?>)</div>
			<div class="body">
				<?php
				foreach($communities as $community)
				{
					?>
					<div class="col-3-12 centered" style="padding-right:0px">
						<a href="/community/view/<?=$community['id']?>" style="color:black"><img class="image" src="https://storage.bopimo.com/community/<?=$community['cache']?>.png"><?=$community['name']?></a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>

<script src="/profiles/friend.js?r=<?=time()?>"></script>
<script>
$(function () {
currentlyWearing($("#uid").data('id'));
function currentlyWearing ( id ) {
	response("/api/avatar/currentlyWearing.php?userId=" + id)
		.success((data) => {
			$.each( data.data, function (item, value) {
				if (value.hasOwnProperty("id")) {
					$("#" + value.elm + "").attr('src', "https://storage.bopimo.com/thumbnails/" + value.id + ".png");
					$($("#" + value.elm + "").parent()).attr('href', "/item/" + value.id + "");
				} else {
					$("#" + value.elm + "").attr('src', "https://storage.bopimo.com/thumbnails/1.png");
					$($("#" + value.elm + "").parent()).attr('href', "#");
				}
			});
		}).get();
}
});
</script>
<script>
</script>
<div class="col-1-1">
<div class="page-title" data-user-id='<?=htmlentities($user->id)?>'><?=htmlentities($bop->trueUsername($uid))?>'s Inventory</div>
	<div class="col-2-12">
		<div class="content shop-buttons">
			<?php

			$categories = [
			"All" => "all"
			];

			$dbCategories = $bop->getCategories();

			foreach ($dbCategories as $index => $category) {
				$categories[$category["name"]] = $category["id"];
			}

			foreach ($categories as $name => $id) {
			?>
			<div class="shop-button" data-category="<?=$id?>">
				<?=$name?>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="col-10-12">
		<div id="inventory" style='overflow: auto;'></div>
		<div id="pages" style='padding-right:20px;'></div>
	</div>
</div>
<script src="/js/inventory.js?<?=rand()?>"></script>

<?php $bop->footer(); ?>
