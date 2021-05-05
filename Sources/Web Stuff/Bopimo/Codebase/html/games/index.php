<?php 

require "../site/header.php";

$categories = [
"Recommended",
"Featured",
"Popular",
"Most Favorited",
"Recently Played"
];

$genres = [
	"All",
	"Building",
	"Horror",
	"City",
	"Military",
	"Comedy",
	"Midevil",
	"Adventure",
	"Sci-Fi",
	"Naval",
	"FPS",
	"RPG",
	"Sports",
	"Fighting",
	"Western"
];

?>
<div class="col-2-12">
	<div class="page-title">
		Games
	</div>
	<div class="game-categories">
		<?php foreach ($categories as $cateogry) { ?>
		<div class="category">
			<?=$cateogry?>
		</div>
		<?php } ?>
		<div class="subtitle">
			Genre
		</div>
		<?php foreach ($genres as $genre) { ?>
		<div class="genre">
			<?=$genre?>
		</div>
		<?php } ?>
	</div>
</div>
<div class="col-10-12">
	<div class="page-title">
		Recommended
	</div>
</div>
<?php 

require "../site/footer.php";

?>