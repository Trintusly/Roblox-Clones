<?php
$page = 'upgrade';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireLogin();
	
	if ($SiteSettings->Upgrades == 0) {

		echo '
		<script>
		document.title = "Upgrades - Brick Planet";
		</script>
		<div class="container lg-padding border-r text-center games-construction">
			<i class="material-icons">warning</i>
			<div>This area is under maintenance</div>
			<p>Please contact <a href="mailto:hello@brickplanet.com">hello@brickplanet.com</a> for billing or payment issues.</p>
		</div>
		';
		
		require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
		
		die;
		
	}
	
	if (isset($_POST['Discord Server_1']) && $myU->VIP == 0) {
		
		$_SESSION['UpgradePlanChoice'] = 1;
		$_SESSION['UpgradeCheckoutPage'] = 1;
		
		header("Location: ".$serverName."/upgrade/checkout");
		die;
		
	} else if (isset($_POST['Discord Server_2']) && $myU->VIP <= 2) {
		
		$_SESSION['UpgradePlanChoice'] = 2;
		$_SESSION['UpgradeCheckoutPage'] = 1;
		
		header("Location: ".$serverName."/upgrade/checkout");
		die;
		
	} else if (isset($_POST['Discord Server_3']) && $myU->VIP <= 3) {
		
		$_SESSION['UpgradePlanChoice'] = 3;
		$_SESSION['UpgradeCheckoutPage'] = 1;
		
		header("Location: ".$serverName."/upgrade/checkout");
		die;
		
	}
	
	echo '
	<script>document.title = "Upgrade - Brick Planet";</script>
	<div class="grid-x grid-margin-x">
		<div class="large-9 upgrade-offset cell">
			<div class="grid-x grid-margin-x">
				<div class="auto cell no-margin">
					<h4>Nitro Boosting</h4>
				</div>
				<div class="shrink cell right">
					<a href="'.$serverName.'/upgrade/code-redemption" class="button button-grey">Redeem Codes</a>
				</div>
			</div>
		</div>
	</div>
	<div class="push-25"></div>
	<div class="upgrade-title">NITRO BOOSTING BENIFITS</div>
	<div class="push-25"></div>
	<div class="grid-x grid-margin-x">
		<div class="large-3 medium-4 small-6 upgrade-offset cell">
			<div class="r">
				<div class="push-15"></div>
				
				<div class=""></div>
				<div class="">
					<div class=""></div>
					<div class=""></div>
					<div class=""></div>
				</div>
				<div class=""></div>
				<div class="">
					
				</div>
			</div>
		</div>
		<div class="large-3 medium-4 small-6 cell">
			<div class="container border-r">
				<div class="push-15"></div>
				<div class="upgrade-card-image" style="background:url('.$cdnName.'assets/images/profile/ss.png);"></div>
				<div class="upgrade-card-title">Nitro Membership</div>
				<div class="upgrade-card-price">Exclusive</div>
				<div class="upgrade-card-inner">
					<div class="upgrade-card-info">- Access to Nitro Channel</div>
					<div class="upgrade-card-info">- Discord Perks, Custom Name colour.</div>
					<div class="upgrade-card-info">- Nitro Top Hat on site</div>
					<div class="upgrade-card-info">- Permanent Nitro Membership on site along with it being displayed all over the website.</div>
					<div class="upgrade-card-info"> - Early notifications for collectibles and loot boxes, get them before anyone else!</div>
				</div>
				<div class="upgrade-card-divider"></div>
				<div class="upgrade-card-button">
					<form action="" method="POST">
						<a href="https://discord.gg/f3Z3E7p" class="button button-blue" style="font-size:13px;margin-top:5px;">Discord Server</a>
					</form>
				</div>
			</div>
		</div>
		
				</div>
			</div>
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");