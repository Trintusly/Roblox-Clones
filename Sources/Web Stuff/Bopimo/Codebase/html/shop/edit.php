<?php

require("/var/www/html/api/shop/shop.php");
require("/var/www/html/site/header.php");

if (!isset($_GET["id"])) { die("<script>window.location = '/shop/'</script>"); }
if (empty(trim($_GET["id"])) || !is_numeric($_GET["id"])) { die("<script>window.location = '/shop/'</script>"); }
error_reporting(E_ALL);
ini_set('display_errors', 1);

$item = $bop->getItem($_GET["id"]);
if (empty($item)) { die("<script>window.location = '/shop/'</script>"); }
if (!$bop->loggedIn()) { die("<script>window.location = '/item/".$item["id"]."'</script>"); }
if (!$shop->isCreator($_GET["id"], $_SESSION["id"])) {  die("<script>window.location = '/item/".$item["id"]."'</script>"); }
$creator = $shop->get_user($item['creator'], "username");
$sold = $shop->getSold($item['id']);
$favorites = $shop->getFavorites($item['id']);
$localId = $bop->local_info("id")->id;
$wishlistCount = $shop->getWishlistCount($item['id']);

$class = ($item['sale_type'] == 0) ? ($item['price'] == 0) ? "free" : "" : "offsale disabled";
if($item['verified'] == 0)
{
	$imgString = "awaiting.png";
} elseif($item['verified'] == 1) {
	$imgString = $item['id'] . ".png";
}
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
?>
<style>

</style>
<?php if (!$isBundle) { ?>
<div class="col-1-12"></div><div class="col-10-12">
<?php } ?>
<div id="response"></div>
<div style="color:#8973f9;font-size:1rem;font-weight:600;margin-bottom:4px;">
	<a href="/item/<?=$item['id']?>" style="color:#8973f9">
		<i class="fas fa-chevron-left"></i> Return to <?=($isBundle) ? "bundle" : "item"?>
	</a>
</div>
<?php if ($isBundle) { ?>
	<div class="col-8-12" id="item">
<?php } ?>
<div class="card border">
	<?php if (!$isBundle) { ?>
	<div class="col-4-12" id="image">
		<div>
			<img src="https://storage.bopimo.com/thumbnails/<?=$imgString?>" style="width:100%;" />
		</div>

	</div>
	<?php } ?>
	<?php ?>
	<div class="<?=(!$isBundle) ? "col-8-12" : "col-1-1" ?>" id="item">
		<div style="padding:10px;" >
			<div class="everything-else">
				<input class="width-100" id="title" placeholder="Title" value="<?=htmlentities($item['name'])?>">
				<div id="titleError" class="input-error"></div>
				<textarea class="width-100" id="description" placeholder="Description" style="height: 150px;max-height:150px;"><?=htmlentities($item['description'])?></textarea>
				<div id="descriptionError" class="input-error"></div>
				<div class="col-1-2">
					<div class="col-1-2">
						<select id="sale" class="width-100">
							<option value="0">Onsale</option>
							<option value="1" <?=($item['sale_type'] == "1") ? "selected" : "" ?>>Offsale</option>
							<?php if (in_array($item['category'], [1,2,3])) { ?> 
							<option value="tradeable">Tradeable</option>
							<?php } ?>
						</select>
					</div>
					<div class="col-1-2" style="padding-right:0px;">
						<input id="price" class="width-100" type="number" placeholder="Price"  <?=($item['sale_type'] == "1") ? "disabled" : "" ?> value="<?=htmlentities($item['price'])?>">
					</div>
				</div>
				<div class="col-1-2">
					<div id="notUpdateHolder">
					</div>
					<div id="updateHolder">
						<div class="button success width-100 centered" data-item-id="<?=$item['id']?>" id="update" style="box-sizing:border-box;">Update</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-1-1">
		<div class="content">
			<div class="col-1-5" id="info">
				<div class="subtitle">CREATED</div>
				<div style="margin-bottom:5px;"><?=date("m/d/Y", strtotime($item['uploaded']))?></div>
			</div>
			<div class="col-1-5">
				<div class="subtitle">UPDATED</div>
				<div style="margin-bottom:5px;"><?=date("m/d/Y", strtotime($item['updated']))?></div>
			</div>
			<div class="col-1-5">
				<div class="subtitle">SOLD</div>
				<div style="margin-bottom:5px;"><?=htmlentities($sold)?></div>
			</div>
			<div class="col-1-5">
				<div class="subtitle">FAVORITES</div>
				<div style="margin-bottom:5px;"><?=htmlentities($favorites)?></div>
			</div>
			<div class="col-1-5">
				<div class="subtitle">WISHLISTS</div>
				<div style="margin-bottom:5px;"><?=htmlentities($wishlistCount)?></div>
			</div>
		</div>
	</div>
</div>
</div>
<?php if ($isBundle) { ?>
<span style="display: none;" id="bundleId" data-bundle-id="<?=$item["id"]?>"></span>
		<div class="col-4-12">
			<div class="card border">
				<div class="content">
					<div style="font-size:1.2rem;">Configure Bundle</div>
					<div class="col-10-12">
						<input type="text" id="addId" class="width-100" placeholder="Item ID" />
					</div>
					<div class="col-2-12">
						<button style="margin-top: 5px;" id='addBundle' class="shop-search-button"><i class="fas fa-plus"></i></button>
					</div>
				</div>
			</div>
			<div id="epiccontainer">
			
			</div>
		</div>
	<?php } ?>
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
<script src="/js/editItem.js?2"></script>