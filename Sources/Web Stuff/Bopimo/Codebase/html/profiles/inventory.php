<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$userI = $bop->get_user($uid);
if($bop->isBanned($userI->id))
{
	require("/var/www/html/error/404.php");
	die();
}

require("/var/www/html/api/shop/shop.php");
require("../site/header.php");

?>


<div class="page-title" data-user-id='<?=htmlentities($userI->id)?>'><?=htmlentities($userI->username)?>'s Inventory</div>

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
<script src="/js/inventory.js"></script>
<?php
$bop->footer();
?>
