<?php
$ads = true;
$pageName = "Shop";
require("/var/www/html/site/header.php");
$placeholders = [ "🎩 Amazing Top Hat", "🧢 Billy's Baseball Cap", "👒 Flower Hat", "🐱 Something Hot", "🔨 Handy Man", "👚 Dress", "👕 Polo" ];
?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-9016364683167219",
enable_page_level_ads: true
});
</script>
<script>
	<?php
	$perPage = [12,24,36,48];
	$approval = [ 0 => "Only Approved", 2 => "Only Unapproved", 3 => "Only Declined", 1 => "All" ];
	$saleType = [ 1 => "On Sale", 2 => "Offsale",0 => "Both" ];
	$fields = [
		"query" => "",
		"category" => "threeo",
		"sort" => "",
		"creator" => "",
		"min" => "",
		"max" => "",
		"page" => "1",
		"perPage" => "",
		"showVerified" => "",
		"saleType" => "0"
	];
	$advancedFields = [
		"showVerified",
		"perPage",
		"min",
		"max",
		"creator",
		"saleType"
	];
	foreach ($fields as $filter => $value) {
		if (isset($_GET[$filter])) {
			if (is_string($_GET[$filter])) {
				$fields[$filter] = htmlentities($_GET[$filter]);
			}
		}
	}

	$advanced = false;
	foreach ($advancedFields as $filter) {
		if (!empty(trim($fields[$filter]))) {
			$advanced = true;
			break;
		}
	}
	?>
	var defaultSearch = <?=json_encode($fields)?>;
</script>
<div class="col-2-12">
	<div class="content shop-buttons">
		<?php

		$categories = [
		"Official" => "threeo",
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
	<div class="col-11-12">
		<div class="shop-search">
			<input class="search not-default width-100" type="text" placeholder="<?=$placeholders[rand(0, count($placeholders) - 1)]?>" value="<?=$fields["query"]?>" />
			<div class="advanced" style="<?=($advanced) ? "" : "display:none"?>">
				<div class="col-1-5">
					Creator <br><input id="creator" class="not-default" type="text" value="<?=$fields["creator"]?>" />
				</div>
				<div class="col-1-5">
					Min Price<br><input id="min" class="not-default" type="text" value="<?=$fields["min"]?>" />
				</div>
				<div class="col-1-5">
					Max Price<br><input id="max" class="not-default" type="text" value="<?=$fields["max"]?>"/>
				</div>
				<div class="col-1-5">
					Page<br><input id="page" class="not-default" type="text" value="<?=$fields["page"]?>"/>
				</div>
				<div class="col-1-5">
					Per Page<br><select class="not-default" id="perPage">
						<?php
						foreach ($perPage as $option) {
							$selected = ($option == $fields["perPage"]) ? "selected" : "";
							?>
							<option value="<?=$option?>" <?=$selected?>><?=$option?></option>
							<?php
						}
						?>
						</select>
				</div>
				<div class="col-1-5">
					Approval Sort<br><select class="not-default" id="showApproved">
					<?php
						foreach ($approval as $option => $name) {
							$selected = ($option == $fields["showVerified"]) ? "selected" : "";
							?>
							<option value="<?=$option?>" <?=$selected?>><?=$name?></option>
							<?php
						}
					?>
					</select>
				</div>
				<div class="col-1-5">
					Sale Type Sort<br><select class="not-default" id="showApproved">
					<?php
						foreach ($saleType as $option => $name) {
							$selected = ($option == $fields["showVerified"]) ? "selected" : "";
							?>
							<option value="<?=$option?>" <?=$selected?>><?=$name?></option>
							<?php
						}
					?>
					</select>
				</div>
				<div class="col-1-5">
				</div>
			</div>
		</div>
		<div class="search-results"><div class="col-10-12 result">Showing most popular Category1</div><div class="col-2-12" style="text-align:right;"><span class="cog-hover"><i class="fas fa-cog"></i> Advanced</span></div></div>
		<div class="item-container">

		</div>
		<div class="col-1-1" id="pageButtons">
			<button style="float:left;display:inline;width:auto;display:none;" id="previousPage" class="shop-search-button"><i class="fas fa-chevron-left"></i> Previous Page</button>
			<button style="float:right;display:inline;width:auto;display: none;" id="nextPage" class="shop-search-button">Next Page <i class="fas fa-chevron-right"></i></button>
		</div>
	</div>
	<div class="col-1-12">
		<button class="shop-search-button" tooltip="Search"><i class="fas fa-search"></i></button>
		<div class="small-subtitle">CREATE</div>
		<a href="/shop/create/"><button class="shop-search-button" tooltip="Create"><i class="fas fa-tshirt"></i><i class="fas fa-plus"></i></button></a>
		<div class="small-subtitle">SORT</div>
		<button class="shop-search-button tooltip" data-sort="expensive" title="Most Expensive"><i class="fas fa-dollar-sign"></i><i class="fas fa-level-up-alt"></i></button>
		<button class="shop-search-button tooltip" data-sort="cheap" title="Least Expensive"><i class="fas fa-dollar-sign"></i><i class="fas fa-level-down-alt"></i></button>
		<button class="shop-search-button tooltip" data-sort="most_bought" title="Most Bought"><i class="fas fa-money-bill"></i></button>
		<button class="shop-search-button tooltip" data-sort="most_favorites" title="Most Favorited"><i class="fas fa-heart"></i></button>
		<button class="shop-search-button tooltip" data-sort="most_favorites" title="On Most Wishlists"><i class="fas fa-list"></i></button>
		<button class="shop-search-button tooltip" data-sort="" title="Remove Sort"><i class="fas fa-times"></i></button>
		<div class="small-subtitle">OTHER</div>
		<button class="shop-search-button tooltip" id="help" title="Help"><i class="fas fa-question"></i></button>
		<button class="shop-search-button tooltip" id="copyLink" title="Copy Link"><i class="fas fa-link"></i></button>
	</div>
</div>
<script src="/js/shop.js?68as"></script>

<?php $bop->footer(); ?>
