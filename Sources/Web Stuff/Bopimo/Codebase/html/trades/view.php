<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
require("/var/www/html/api/shop/shop.php");
require("../site/header.php");

if (!$shop->logged_in()) { die("<script>window.location='/login/'</script>"); }

if (isset($_GET['id'])) {
	if (is_numeric ($_GET['id'])) {
		try {
			$trade = (array) $shop->getTradeProtected($_GET['id'], $_SESSION["id"]);
		} catch (Exception $e) {
			 die("<script>window.location='/trades/'</script>");
		}
	} else {
		die("<script>window.location='/trades/'</script>");
	}
} else {
	die("<script>window.location='/trades/'</script>");
}

$sender = ($trade["from_user"] == $_SESSION['id']) ? true : false;
$otherUser = ($sender) ? $shop->get_user($trade["to_user"]) : $shop->get_user($trade["from_user"]);
$disabled = ($trade['status'] != "0") ? true : false;

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

.shop-button.disabled:hover {
	cursor: default;
}
</style>
<div class="col-1-1" style="margin-bottom:10px;">
  <a href="/trades/" style="color:#8973f9">
  	<i class="fas fa-chevron-left"></i> Return to trades
  </a>
</div>
<?php if ($disabled) {
	switch($trade["status"]) {
		case "-2":
			?>
			<div class='banner' style='text-align:center;background-color:#a5a5a5;color:#ececec;overflow:auto;'> This trade has been canceled by the sender </div>
			<?php
			break;
		case "-1":
			?>
			<div class='banner' style='text-align:center;background-color:#d20505;color:#fff;overflow:auto;'>This trade has been declined</div>
			<?php
			break;
		case "1":
			?>
			<div class='banner' style='text-align:center;background-color:#a5a5a5;color:#ececec;overflow:auto;'>This trade has been accepted</div>
			<?php
			break;
	}
}?>
<div class="page-title" id='tradeId' data-tradeid="<?=htmlentities($_GET['id'])?>"><div style='float:left;'><?=($sender) ? "Trade sent to" : "Trade from" ?> <?=$otherUser->username?>
</div>
	<?php 
	if ($sender) {
		?>
		<div class='buy-button <?=($disabled) ? "disabled" : ""?> danger' id='cancel'  style='background-color:#ff5151;font-size:1.2rem;float:right;'>Cancel Trade</div>
		<?php
	} else {
		?>
	<div class='buy-button <?=($disabled) ? "disabled" : ""?>  danger' id='decline' style='background-color:#ff5151;font-size:1.2rem;float:right;'>Decline</div><div class='buy-button <?=($disabled) ? "disabled" : ""?>' id='accept' style='font-size:1.2rem;background-color: #39c13d;float:right;margin-right:5px;'>Accept</div> 
		<?php
	}
	?>
</div>
<div class='card border flex-container width-100' style=''>
<div class='col-5-12' style='flex:1;'>
	<fieldset>
		<legend>
			<?=($sender) ? "Get" : "Give" ?>
		</legend>
		<div id='giving'>
			<?php 
			foreach ($trade["asking_for"] as $item) {
				?>
				<div class="col-1-4 trade-item">
					<div class="serial">#<?=$item['serial']?></div>				
					<img class="width-100" src="https://storage.bopimo.com/thumbnails/<?=$item['id']?>.png">			
				</div>
				<?php 
			}
			?>
		</div>
	</fieldset>
</div>
<div class='col-2-12' style='flex:.2;align-self:center;color:#B5B5B5;font-size:3rem;text-align:center;'>
<i class="fas fa-exchange-alt"></i>
</div>
<div class='col-5-12' style='flex:1;'>
	<fieldset>
		<legend>
			<?=($sender) ? "Give" : "Get" ?>
		</legend>
		<div id='want'>
			<?php 
			foreach ($trade["sending"] as $item) {
				?>
				<div class="col-1-4 trade-item">
					<div class="serial">#<?=$item['serial']?></div>				
					<img class="width-100" src="https://storage.bopimo.com/thumbnails/<?=$item['id']?>.png">			
				</div>
				<?php 
			}
			?>
		</div>
	</fieldset>
</div>
</div>
<script src='/js/viewtrade.js'></script>
<?php 
$shop->footer();
?>
