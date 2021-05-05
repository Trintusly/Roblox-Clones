<?php 
$actions = [
	"approved",
	"declined",
	"banned",
	"unbanned"
];

$types = [
	"item",
	"user",
	"thread",
	"reply"
];
?>
<div class="logs" style="margin-bottom: 10px;overflow:auto;">
	<div class="col-1-4">
		<input type="text" class="width-100" id="username" autocomplete="off" placeholder="Username"/>
	</div>
	<div class="col-1-4">
		<input type="number" class="width-100" id="affectedId" placeholder="Affected ID" />
	</div>
	<div class="col-1-4">
		<select class="width-100" id="type" placeholder="Type">
			<option selected disabled>Type</option>
			<option value="">Any</option>
			<?php foreach ($types as $type) { ?>
			<option value='<?=$type?>'>
				<?=ucfirst($type)?>
			</option>
			<?php } ?>
		</select>
	</div>
	<div class="col-1-4">
		<select class="width-100" id="action" placeholder="Action">
			<option disabled selected>Action</option>
			<option value="">Any</option>
			<?php foreach ($actions as $action) { ?>
			<option value='<?=$action?>'>
				<?=ucfirst($action)?>
			</option>
			<?php } ?>
		</select>
	</div>
</div>
<div class="results log">
</div>
<button style="float:left;display:inline;width:auto;display:none;" id="previousPage" class="shop-search-button"><i class="fas fa-chevron-left"></i></button>
<button style="float:right;display:inline;width:auto;display:none;" id="nextPage" class="shop-search-button"><i class="fas fa-chevron-right"></i></button>
