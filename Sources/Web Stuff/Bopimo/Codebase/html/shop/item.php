<?php
$ads = true;
require("/var/www/html/api/shop/shop.php");


if (!isset($_GET["id"])) { die("<script>window.location = '/shop/'</script>"); }
if (empty(trim($_GET["id"])) || !is_numeric($_GET["id"])) { die("<script>window.location = '/shop/'</script>"); }
error_reporting(E_ALL);
ini_set('display_errors', 1);

$item = $bop->getItem($_GET["id"]);
if (empty($item)) { die("<script>window.location = '/shop/'</script>"); }
$creator = $shop->get_user($item['creator'], "username");
$isBundle = false;
if ($item['category'] == "7") {
	$isBundle = true;
	$item = $shop->getBundle($_GET["id"]);
	if ($item['items']) {
		foreach ($item['items'] as $i => $bundleItem) {
			$item['items'][$i]['name'] = $shop->itemName($bundleItem['item_id']);
		}
	}
}
$stock = "";
$sold = $shop->getSold($item['id']);
$favorites = $shop->getFavorites($item['id']);
$wishlistCount = $shop->getWishlistCount($item['id']);
$pageName = htmlentities($item['name']);

if($item['verified'] == 0)
{
	$imgString = "awaiting.png";
} elseif($item['verified'] == 1) {
	$imgString = $item['id'] . ".png";
} else {
	$imgString = "declined.png";
	//$imgString = "awaiting.png";
}

if ($isBundle) {
	if ($item['items']) {
		$imgString = $item['items'][0]['item_id'] . ".png";
	}
}

?>
<meta charset="UTF-8">
<meta property="og:site_name" content="bopimo.com">
<meta property="og:image" content="https://storage.bopimo.com/thumbnails/<?=$imgString?>">
<meta name="description" content="<?=htmlentities(substr($item['description'], 0, 200))?>">
<meta name="keywords" content="Bopimo, Bopimo thread, Bopimo Game">
<meta name="author" content="<?=htmlentities($creator->username)?>">
<?php

/*
<meta charset="UTF-8">
<meta property="og:site_name" content="bopimo.com">
<meta property="og:image" content="https://storage.bopimo.com/thumbnails/<?=$imgString?>">
<meta name="description" content="<?=nl2br(htmlentities($item['description']))?>">
<meta name="keywords" content="Bopimo, Bopimo thread, Bopimo Game">
<meta name="author" content="<?=htmlentities($creator['username'])?>">
*/

require("/var/www/html/site/header.php");
$loggedIn = $bop->loggedIn();
$isOnWishlist = false;
$isFavorited = false;
$ownsItem = false;
$isCreator = false;
if ($item['tradeable'] == 1) {
	$class = "tradable";
	$f = $shop->getStock($item['id']);
	$stock = ($f['remaining'] != 0) ? $f['remaining'] . " Remaining" : "Sold Out";
} else {
$class = ($item['sale_type'] == 0) ? ($item['price'] == 0) ? "free" : "" : "offsale disabled";
}
if ($bop->loggedIn()) {

	$localId = $bop->local_info("id")->id;
	$isOnWishlist = $shop->getWishlistBoth( $item['id'], $localId, true )[0]??false;
	$isFavorited = $shop->getFavorite($item['id'], $localId, true)[0]??false;
	$isOwned = ($isBundle) ? $shop->hasBundle($item['id'], $localId) : $shop->hasItem($item['id'],$localId);
	$isCreator = $shop->isCreator($item["id"], $_SESSION["id"]);
	$class .= ($isOwned && $item['sale_type'] !== 1) ? " disabled tooltipster-right" : "";
}

?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-9016364683167219",
enable_page_level_ads: true
});
</script>
<style>
.ellipsis {
	text-overflow: ellipsis;
}
.bundle-box {
	padding: 10px;
	background-color: #f3f3f3;
	display: block;
	border-radius: 5px;
	overflow: auto;
}
.bundle-content {
	box-sizing: border-box;
	text-align: center;
	border-radius: 3px;
	background-color: #fff;
	padding: 5px;
	transition: opacity .5s;
}
a {
	color: #000;
}
.bundle-content:hover {
	cursor: pointer;
	opacity: 0.7;
}
.bundle-content:not(:last-child) {
	margin-bottom: 5px;
}
.bundle-content img {
	width: 100%;
}
.hover-edit {
	color:grey;
}
.bundle-box .per50 {
	display: block;
	float: left;
	width: 48%;
}
.bundle-box .per50 {
	margin-right: 1%;
}
.bundle-box .per50 {
	margin-left: 1%;
}
.hover-edit:hover {
	color: #000;
	cursor: pointer;
}
.popup-background {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 200px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.3);
}

.popup-background.active,.popup.active {
	display: block;
}

.popup {
	display: none;
	z-index: 2;
	position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

}
</style>
<span style="display:none;" id="item-info" data-item-id="<?=$item['id']?>"></span>
<div class="col-1-12"></div><div class="col-10-12">
<div id="responce"></div>
<div class="card border">
	<div class="col-4-12" id="image">
		<div>
			<img src="https://storage.bopimo.com/thumbnails/<?=$imgString?>" style="width:100%;" />
		</div>
	</div>
	<div class="<?=($isBundle) ? "col-5-12" : "col-8-12"  ?>" id="item">
		<div style="padding:10px;" >
		<div class="everything-else">
		<div class="item-name <?=$class?>">
			<?=htmlentities($item['name'])?> <?= ($isCreator) ? "<a style='color:inherit;' href='/edit/item/".$item["id"]."'><i class='far fa-edit'></i></a>" : "" ?>
			<?php if ($bop->isAdmin()) { ?>
			<div class="subtitle">
				<?php if ($item["verified"] == 1) { ?>
				<a class="danger-option" href='#!' onclick='declineItemYes(<?=$item['id']?>)'>Decline</a>
				<?php } else { ?>
				<a class="safe-option" href='#!' onclick='approveItemYes(<?=$item['id']?>)'>Accept</a>
				<?php } ?>
				<a class="danger-option" href='#!' onclick='censorItem(<?=$item['id']?>)'>Censor</a>
			</div>
			<?php } ?>
		</div>
		<div class="creator-name">
			By: <a href="/profile/<?=$item['creator']?>" ><?=htmlentities($bop->trueUsername($creator->id))?></a>
		</div>
		<div style="margin-bottom: 10px;font-size:1.3rem;font-weight:600;"><?=$stock?></div>
		<?php
		if ($loggedIn) {
		
		?>
		<div data-item-id="<?=$item['id']?>" <?=($isOwned && $item['sale_type'] == 0 && !$isBundle) ? "title='You already own this item.'" : "" ?> <?=($isOwned && $item['sale_type'] == 0 && $isBundle) ? "title='You already own the bundle or the items in it'" : "" ?> class="buy-button <?=$class?>"><?=($item['sale_type'] == 0) ? ($item['price'] == 0) ? "Get" : "Buy for B".$item['price'] : "Offsale" ?></div>
		<?php
		}
		?>
		</div>
			<div class="content">
				<div class="subtitle" id="title">DESCRIPTION</div>
				<div style="margin-bottom:5px;overflow:auto;max-height:400px;" id="description"><?=nl2br(htmlentities($item['description']))?></div>
				<div class="col-1-3" id="info">
					<div class="subtitle">CREATED</div>
					<div style="margin-bottom:5px;"><?=date("m/d/Y", strtotime($item['uploaded']))?></div>
				</div>
				<div class="col-1-3">
					<div class="subtitle">UPDATED</div>
					<div style="margin-bottom:5px;"><?=date("m/d/Y", strtotime($item['updated']))?></div>
				</div>
				<div class="col-1-3">
					<div class="subtitle">SOLD</div>
					<div style="margin-bottom:5px;"><?=htmlentities($sold)?></div>
				</div>
			</div>
		</div>
	</div>
	<?php if ($isBundle) { ?>
	<div class="col-3-12">
		This bundle includes:
		<div class="bundle-box">
			<?php if ($item['items']) { ?>
				<?php foreach ($item['items'] as $i => $bundleItem) { ?>
				<a class="per50" href="/item/<?=$bundleItem['item_id']?>"><div class="bundle-content">
					<img src="https://storage.bopimo.com/thumbnails/<?=$bundleItem['item_id']?>.png"> 
					<div class="ellipsis"><?=htmlentities($bundleItem['name'])?></div>
				</div></a>
				<?php } ?>
			<?php } else { ?>
				<div style="color: #696969;font-weight:600;text-align:center;">Nothing!</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
</div>
<div class="item-icons col-4-12">
	<?php
	if ($loggedIn) {
	?>
	<div class="col-1-3">
		<i class="fas fa-heart <?=($isFavorited) ? "active" : ""?> tooltip" title="<?=($isFavorited) ? "Unfavorite" : "Favorite"?>"></i> <span id="favorites"><?=$favorites?></span>
	</div>
	<div class="col-1-3">
		<i class="fas fa-list <?=($isOnWishlist) ? "active" : ""?> tooltip" title="<?=($isOnWishlist) ? "Remove from Wishlist" : "Add to Wishlist"?>"></i> <span id="wishlists"><?=$wishlistCount?></span>
	</div>
	<?php
	} else {
		?>
		<div class="col-1-3">
			<i class="fas fa-heart disabled"></i> <span id="favorites"><?=$favorites?></span>
		</div>
		<div class="col-1-3">
			<i class="fas fa-list disabled"></i> <span id="wishlists"><?=$wishlistCount?></span>
		</div>
		<?php
	}
	?>
</div>
<?php



if ($loggedIn) {
	if($item['tradeable'] == "1" && ($item['category'] == 1 || $item['category'] == 2 || $item['category'] == 3))
	{
		if($f['remaining'] == 0) {
		if ($isOwned) {
			$serials = $shop->query("SELECT * FROM inventory WHERE item_id = ? AND user_id = ? AND own = 1", [$item['id'], $localId])->fetchAll(PDO::FETCH_ASSOC);

			$usableSerials = [];

			foreach ($serials as $serial) {

				if ($shop->query("SELECT COUNT(*) FROM item_other_sellers WHERE item_id = ? AND seller_id = ? AND serial_id = ? AND active = 1", [$item['id'], $localId, $serial['serial']])->fetchColumn(0) == 0) {
					if ($serial['serial'] != 0) {
						$usableSerials[] = $serial['serial'];
					}
				}
			}
		


		?>
		<div class='popup-background'>
		</div>
		<div id='editOnSale' class='card popup' style='width: 300px;'>
			<div class='content'>
				<div class='item-name' style="color:#222;">Edit your on sale item</div>
				Serial:<br>
				<span id='editSerial' data-sale-id='#'>#</span>
				<br>
				Price:<br>
				<input id='newOnSalePrice' type='int' class='width-100'></input>
				<div class='col-1-2'>
					<div id='offsale' class='shop-search-button' style='background-color: #9e0f0f;width: auto;'>
						Offsale
					</div>
				</div>
				<div class='col-1-2'>
					<div id='update' class='shop-search-button' style='width: auto;'>
						Update
					</div>
				</div>
			</div>
		</div>
		<div id='putOnSalePopup' class='card popup' style='width: 300px;'>
			<div class='content'>
					<div class='item-name' style="color:#222;">Sell your item</div>

					<div>
					Serial:<br>
					<select class='width-100' id='serials'>
						<?php



							foreach ($usableSerials as $serial) {

						?>
						<option value='<?=$serial?>'>#<?=$serial?></option>
						<?php

								}
						?>
					</select>
					</div>
					<div>
					Price:<br>
					<input id='onSalePrice' type='int' class='width-100'></input>
					</div>
					<div style='margin-top:4px;'>
						<div id='putOnSale' class='shop-search-button' style='width: auto;'>
						put this bad boy on the market
						</div>
					</div>
					<div  style='text-align:center;font-size:0.8rem;color: #b95d5d;'>*There is a 20% taxes on sales</div>
				</div>
			</div>
		<?php } ?>
		<div class="col-1-1">
			<div class="item-name" style="color:#222;">
			Sellers (Original Price: B<?=$item['price']?>) <?=($isOwned && count($usableSerials) > 0) ? "<span class='cog-hover' id='addSerial'>+</span>" : "" ?>
			</div>
			<div id="sellers">
				<div style='text-align:center;color:gray;padding: 10px;'>
				No-one is selling this item
				</div>

			</div>
		</div>
		<?php
	}
	}
}
?>
<div class="col-1-1">
	<div class="item-name" style="color:#222;">
		Comments
	</div>
	<?php
	if ($loggedIn) {
	?>
	<div class="card border">
		<div class="content">
			<textarea class="width-100" id="body" placeholder="Neat item!" style="height:80px;"></textarea>
			<div id="commentError" class="input-error"></div>
			<span class="right button success" id="postComment">Post</span>
		</div>
	</div>
	<?php
	}
	?>
	<div id="comments">
	</div>
</div>
</div>
<script src="/js/item.js?2"></script>
<?php $bop->footer(); ?>
