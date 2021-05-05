<?php
require("/var/www/html/site/header.php");
?>
<script src="/js/create.js"></script>
<div class="col-2-12">
	<div class="content shop-buttons">
		<?php 
		
		$dbCategories = $bop->getCategories(!$bop->isAdmin());
		
		foreach ($dbCategories as $index => $category) {
			$categories[$category["name"]] = $category["id"];
		}
		
		?>
		<div class="shop-buttons">
			<?php
			foreach ($categories as $name => $id) {
			?>
			<div class="shop-button" data-category="<?=$id?>">
				<?=$name?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="col-10-12">
	<div class="card b create">
		<div class="top ">
			Create
		</div>
		<div class="body centered">
			<div id="generalError" class="input-error"></div>
			<div class="col-1-2">
				<input class="width-100" id="title" placeholder="Title" />
				<div id="titleError" class="input-error"></div>
				<textarea class="width-100" id="description" placeholder="Description" style="height:250px;"></textarea>
				<div id="descriptionError" class="input-error"></div>
				<div class="col-1-2">
					<select id="sale" class="width-100">
						<option value="0">Onsale</option>
						<option value="1" selected>Offsale</option>
					</select>
				</div>
				<div class="col-1-2" style="padding-right:0px;">
					<input id="price" class="width-100" type="number" placeholder="Price" disabled />
				</div>
				<div class="col-1-1 width-100" style="padding:0px;">
					<div class="button success width-100" id="upload" style="padding: 10px 0px 10px 0px;opacity:0.5;">Upload</div>
				</div>
				<div class="col-1-1 width-100">
					<a href="template.png" target="blank" class="button upload centered">Template</a>
				</div>
			</div>
			<div class="col-1-2" id="previewSection"> 
				<div class="image-banner"></div>
				
				<input type="file" id="image" name="image" class="upload" accept="image/*" />
				<div id="button1"><label for="image" id="label" class="button upload centered"><i class="fas fa-upload"></i> Choose a file </label></div>
				<div id="button2"></div>
				<div class="upload button" id="preview" style="margin-top:10px;font-size:15px;background-color:#fff;">Render Preview</div>
				<div style="margin-top:5px;" class="centered"><img id="previewImg" src="solid.png" style="width: 80%;"/></div>
			</div>
		</div>
	</div>
</div>
