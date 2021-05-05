<?php
$pageName = "404";
require("/var/www/html/site/header.php");
header( $_SERVER['SERVER_PROTOCOL']." 404 Not Found", true );

$errors = array (
  "What are you looking for?",
  "This page was not found.",
  "Might want to check the URL you've entered.",
  "Keep looking, you might find what you're looking for eventually.",
);

?>
<div class="content">
  <div class="col-1-1 centered">
    <div style="margin-bottom: 20px;margin-top:10px;">
		<img src="/error/404.png" width="350" />
	</div>
	<div style="font-size: 1.2rem;color: #7660E4;font-weight:600;">
		<?=$errors[rand(0,count($errors) - 1)]?>
	</div>
  </div>
</div>
<?php $bop->footer(); ?>
