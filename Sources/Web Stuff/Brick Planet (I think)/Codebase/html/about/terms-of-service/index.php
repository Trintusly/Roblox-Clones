<?php
$show_ads = false;
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	//variables used incase domain name is changed -- easy, awesome idea!!!!!!!!
	$brand = "BLOX City";
	$website = "<a href='".$serverName."/' style='font-weight:normal;'>BLOXCity.com</a>";
	$email = "<a href='helpme@bloxcity.com' style='font-weight:normal;'>helpme@bloxcity.com</a>";
	
	/* Temp (Cache Later) */
	
	$AboutSiteSettings = $db->prepare("SELECT * FROM SiteSettingAbout");
	$AboutSiteSettings->execute();
	$AboutSiteSettings = $AboutSiteSettings->fetch(PDO::FETCH_OBJ);
	
	echo '
	<script>document.title = "Terms of Service - Brick Create";</script>
	<style>
	.main-section{font-weight:bold;margin-left:30px;margin-top:10px;}
	.term-header-txt{font-weight:bold;}
	.sub-section{margin-left:20px;font-weight:normal !important;}
	.alert-info {color: #333333;background-color: #fcf8e3;border-color: #faebcc;}
	.alert {padding: 15px;margin-bottom: 20px;border: 1px solid #cccccc;font-size:13px;}
	</style>
	<div style="margin:auto;">
		<div class="container-header md-padding">
			<strong>Terms of Service</strong>
		</div>
		<div class="container md-padding border-wh">
			'.$AboutSiteSettings->TermsOfService.'
		</div>
	</div>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");