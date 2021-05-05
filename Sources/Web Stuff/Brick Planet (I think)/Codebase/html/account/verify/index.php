<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();

	echo '
	<div class="content-box">
		<h5>Verify Your BLOX City Account</h5>
		<img src="'.$serverName.'/assets/images/account/success.png">
	</div>
	';
?>