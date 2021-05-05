<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
	die(header("location: /account/login"));
}
require "../site/header.php";
?>

<div class="col-3-12">
	<a href="/messages/compose" class="button success" style="width:calc(100% - 40px);text-align:center;margin-bottom:5px;margin-top:0px;">Compose</a>
	<div class="shop-button current" data-category="unread">
		Unread
	</div>
	<div class="shop-button" data-category="read">
		Read
	</div>
	<div class="shop-button" data-category="outgo">
		Outgoing
	</div>
</div>
<div class="col-9-12">
	<div class="col-1-1" style="padding-right:0px;">
		<div class="card b" style="margin-bottom:5px;">
			<div class="top">
				Messages
			</div>
		</div>
		<div class="banner danger hidden">No replies</div>
	</div>
	<div class="col-1-1" style="padding-right:0px;"><span id="content"></span></div>
	<div class="col-1-1">
		<button style="float: left; width: auto;" id="page-left" class="shop-search-button next hidden"><i class="fas fa-chevron-left"></i></button>
		<button style="float: right; width: auto;" id="page-right" class="shop-search-button next hidden"><i class="fas fa-chevron-right"></i></button>
	</div>
</div>
<script src="main.js?<?=rand()?>"></script>
<?php
$bop->footer();
?>
