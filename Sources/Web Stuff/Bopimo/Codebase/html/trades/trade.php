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
$tradeUser = $bop->get_user($uid);

if($bop->isBanned($tradeUser->id))
{
	require("/var/www/html/error/404.php");
	die();
}
if ($tradeUser->id == $bop->local_info(["id"])->id) {
	die();
}

require("/var/www/html/api/shop/shop.php");
require("../site/header.php");





?>

<style>
.disabled {
	opacity: 0.5;
	cursor: default;
}
.trade-item {
	position: relative;
	padding: 5px;
	z-index: 1;
	text-align: right;
}
.trade-item .serial {
	right: 0;
	color: #3c3c3c;
	z-index: 2;
	position: absolute;
}
.tradable:hover {
	cursor: pointer;
}

.flex-container {
	display: flex;flex-direction:row;
}

@media only screen and (max-width: 600px) {
	.flex-container {
		display: block;
	}
}
</style>
<div class="page-title">Trade with <?=htmlentities($tradeUser->username)?> <div class='buy-button' style='font-size:1.2rem;background-color: #4f39c1;float:right;' id="sendTrade">Send Trade <i class="fas fa-arrow-right"></i></div></div>
<div class='card border flex-container width-100' style=''>
<div class='col-5-12' style='flex:1;'>
	<fieldset>
		<legend>
			You'll Give
		</legend>
		<div id='giving'>
			
		</div>
	</fieldset>
</div>
<div class='col-2-12' style='flex:.2;align-self:center;color:#B5B5B5;font-size:3rem;text-align:center;'>
<i class="fas fa-exchange-alt"></i>
</div>
<div class='col-5-12' style='flex:1;'>
	<fieldset>
		<legend>
			What you want
		</legend>
		<div id='want'>
		
		</div>
	</fieldset>
</div>
</div>
<div style='overflow: auto;'>
	
</div>
<div class='col-1-2'>
<div class="page-title">Your Inventory</div>
	<div class='shop-search' style='margin-bottom:5px;'>
		<input id='myInvSearch' data-user-id="<?=$user->id?>" class="search not-default width-100" type="text" placeholder="Search your items" value="">
	</div>
	<div id='myInv' style='overflow: auto;'>
	</div>
	<div id='myPages' class='overflow: auto;'>
	</div>
</div>
<div class='col-1-2'>
<div class="page-title">Their Inventory</div>
	<div class='shop-search' style='margin-bottom:5px;'>
		<input id='userInvSearch' data-user-id="<?=$tradeUser->id?>" class="search not-default width-100" type="text" placeholder="Search their items" value="">
	</div>
	<div id='userInv' style='overflow: auto;'>
	</div>
	<div id='userPages' style='overflow: auto;'>
	</div>
</div>
<script src="/js/trade.js"></script>