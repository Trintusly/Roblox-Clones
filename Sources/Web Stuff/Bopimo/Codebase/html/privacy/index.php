<?php 

require "../site/header.php";

$privacyPolicyTXT = file_get_contents("privacy.txt");

?>
<div class="page-title centered">
	Privacy Policy
</div>
<div class="col-2-12">
</div>
<div class="col-8-12">
<?php 
foreach (explode("\n", $privacyPolicyTXT) as $line => $text) {
	if ($line % 2 == 0) {
	?>
	<div style="color:#000;font-size:1.1rem;margin-bottom:3px;font-weight:600">
		<?=$text?>
	</div>
	<?php 
	} else {
	?>
	<div class="card border">
		<?=$text?>
	</div>
	<?php
	}
}
?>
</div>
<?php 

require "../site/footer.php";

?>