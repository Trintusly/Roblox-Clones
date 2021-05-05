<?php

require "../site/header.php";
$bopibits = [
	150 => 'DAY4YHQG7FMHQ',
	300 => "GQES9SKWG2JPU",
	600 => "CNW8BEK67DP2G",
	1200 => "YE52LFGVG4L4E",
];

?>
<?php /*
<div class="col-1-3">
	<div class="membership tertiary">
		<div class="price">
			$5<span class="term">/mo</span>
		</div>
		<div class="title">
			Beginner
		</div>
		<div class="features">
			<ul>
				<li>Feature</li>
				<li>Feature 2</li>
			</ul>
		</div>
		<div class="centered">
			<a href="#!" class="buy">
				Buy
			</a>
		</div>
	</div>
</div>
<div class="col-1-3">
	<div class="membership secondary">
		<div class="price">
			$10<span class="term">/mo</span>
		</div>
		<div class="title">
			Enhanced
		</div>
		<div class="features">
			<ul>
				<li>Feature</li>
				<li>Feature 2</li>
			</ul>
		</div>
		<div class="centered">
			<a href="#!" class="buy">
				Buy
			</a>
		</div>
	</div>
</div>
<div class="col-1-3">
	<div class="membership primary">
		<div class="price">
			$15<span class="term">/mo</span>
		</div>
		<div class="title">
			Ultimate
		</div>
		<div class="features">
			<ul>
				<li>Feature</li>
				<li>Feature 2</li>
			</ul>
		</div>
		<div class="centered">
			<a href="#!" class="buy">
				Buy
			</a>
		</div>
	</div>
</div>*/ ?>
<div class="col-1-1">
	<div class="page-title" style="margin-top: 10px;">Buy Bopibits</div>
</div>
<?php
foreach ($bopibits as $amount => $url) {
	$price = ($amount * 2 / 100);
?>
<div class="col-1-4">
	<div class="card bopibits">
		<div class="price">
			<?=$amount?> <img src="/images/bopibit.svg" width="18"> for <u><font color="green">$<?=$price?></font></u>
		</div>
		<div class="centered">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input type="hidden" name="tax" value="0.00"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="<?=$url?>"><input type="submit" class="button success" value="Purchase"></form>
		</div>
	</div>
</div>
<?php } ?>
<?php

require "../site/footer.php";

?>
