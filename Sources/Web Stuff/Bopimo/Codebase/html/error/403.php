<?php
$pageName = "403";
require("/var/www/html/site/header.php");
header( $_SERVER['SERVER_PROTOCOL']." 403 Permission Denied", true );

$errors = array (
  "Mind your own business!",
  "FBI OPEN UP",
  "Don' worry aboutit"
);

?>
<div class="content">
  <div class="col-1-1 centered">
    <div style="margin-bottom: 20px;margin-top:10px;">
		<img src="/error/403.png" width="350" />
	</div>
	<div style="font-size: 1.2rem;color: #7660E4;font-weight:600;">
		<?=$errors[rand(0,count($errors) - 1)]?>
	</div>
  </div>
</div>
<?php $bop->footer(); ?>
