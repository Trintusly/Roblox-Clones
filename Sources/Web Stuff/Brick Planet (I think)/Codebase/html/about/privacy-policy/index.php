<?php
$show_ads = false;
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	//variables used incase domain name is changed -- easy, awesome idea!!!!!!!!
	$brand = "Brick Create";
	$website = "<a href='".$serverName."/' style='font-weight:normal;'>brickcreate.com</a>";
	$email = "<a href='hello@brickcreate.com' style='font-weight:normal;'>hello@brickcreate.com</a>";	
	
	/* Temp (Cache Later) */
	
	$AboutSiteSettings = $db->prepare("SELECT * FROM SiteSettingAbout");
	$AboutSiteSettings->execute();
	$AboutSiteSettings = $AboutSiteSettings->fetch(PDO::FETCH_OBJ);
	
	echo '
	<script>document.title = "Privacy Policy - Brick Create";</script>
	<style>.main-section{font-weight:bold;margin-left:30px;margin-top:10px;}.term-header-txt{font-weight:bold;}.sub-section{margin-left:20px;font-weight:normal!important;}</style>
	<div class="container-header md-padding">
		<strong>Privacy Policy</strong>
	</div>
	<div class="container md-padding border-wh">
		'.$AboutSiteSettings->PrivacyPolicy.'
	</div>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");