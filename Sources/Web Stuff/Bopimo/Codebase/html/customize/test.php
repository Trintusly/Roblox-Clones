<?php
require("/var/www/html/site/bopimo.php");

if(!$bop->logged_in())
{
	die(header("header: /account/login"));
}

require("/var/www/html/site/header.php");
?>
<script src="/js/tooltipster.bundle.min.js">
</script>
<style>
	.tooltipo {
		position: absolute;
	}
</style>
<script>
$(function () {
	$('.tooltip').tooltipster({
		contentCloning: true,
		side: 'left',
		theme: 'tooltipo'
	});
});
</script>
<span class="tooltip" data-tooltip-content="#tooltip_content">This span has a tooltip with HTML when you hover over it!</span>
<span class="tooltip" title="This is my span's tooltip message!">Some text</span>

<div class="tooltip_templates">
    <span id="tooltip_content">
		<strong>This is the content of my tooltip!</strong>
    </span>
</div>