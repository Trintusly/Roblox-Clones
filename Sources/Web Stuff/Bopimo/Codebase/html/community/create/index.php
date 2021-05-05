<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
	die(header("location: /account/login"));
}
require("/var/www/html/site/header.php");
?>
<style>
.placeholder-label {
	color: #797979;
	font-size: 0.9rem;
}
</style>
<title>Community - Create</title>
<div class='col-8-12 push-2-12'>
	<a href="/community" style="color:#8973f9">
		<i class="fas fa-chevron-left"></i> Return to communities
	</a>
	<div class='card b'>
		<div class='top'>
			Create Community
		</div>
		<div class='content' style='overflow: auto;'>
			<div id='error' style='color: #e08a7d;'></div>
			<div>
				<div class="col-2-12">
					<div class='placeholder-label'>Tag</div>
					<input id='tag' class="width-100" id="name" placeholder="MC">
				</div>
				<div class="col-10-12" style='padding-right: 0px;'>
					<div class='placeholder-label'>Name</div>
					<input class="width-100" id="name" placeholder="My Community">
				</div>
				<div class='placeholder-label'>Description</div>
				<textarea class="width-100" style='height: 150px;' id="description" placeholder="Epic only!!!"></textarea>
			</div>
			<div class='col-1-2'>
				<div class='placeholder-label'>Postable <i class="far fa-question-circle" title="Lets new members post"></i></div>
				<select id='postable' class='width-100'>
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select>
			</div>
			<div class='col-1-2'>
				<div class='placeholder-label'>Type</div>
				<select id='type' class='width-100'>
					<option value="0">Private</option>
					<option value="1">Open</option>
				</select>
			</div>
			<div>
			<div class='placeholder-label'>Logo (<font color="red">Recommended Size 500px x 500px</font>)</div>
				<input type="file" id="image" name="image" class="upload" accept="image/*">
				<label for="image" id="label" class="button upload centered"><i class="fas fa-upload"></i> Choose a file </label>
			</div>
			<div>
				<div id='create' class='button success' style='text-align:center;width:100%;box-sizing:border-box;'>Create Community for B25</div>
			</div>
			<font color="red">*Note: If your community is declined in the approval process, your community will be removed and you will be refunded.</font>
		</div>
	</div>
</div>
<script src="/community/js/create.js"></script>
<?php
require("/var/www/html/site/footer.php");
?>
