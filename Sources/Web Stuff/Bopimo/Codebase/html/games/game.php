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
	<div class="col-1-2">
		<div class="game">
			<div class="title">
				Bopimo Game
			</div>
			<div class="creator">
			by <a href="#!">Bopimo User 26</a>
			</div>
			<div class="thumbnail">
				<img src="https://orig00.deviantart.net/3ef4/f/2012/122/f/2/super_mario_64_online__my_roblox_place__by_smbmadman-d4ybk9i.png" />
			</div>
			<div class="play">
				Play
			</div>
			<div class="info centered">
				<div class="col-1-4">
					<div class="value">8/22/2012</div>
					<div class="name">Created</div>
				</div>
				<div class="col-1-4">
					<div class="value">8/22/2018</div>
					<div class="name">Updated</div>
				</div>
				<div class="col-1-4">
					<div class="value">25</div>
					<div class="name">Favorites</div>
				</div>
				<div class="col-1-4">
					<div class="value">99,999</div>
					<div class="name">Vists</div>
				</div>
			</div>
			<div class="description">
				This is a super cool game! It's actually one of my favorites that I Have made so far. There's just so much depth to it that's is almost unbelivable.
			</div>
		</div>
	</div>
<div class="col-1-2">
	<div class="game">
		<div class="options col-1-1">
			<div class="option active">
				Servers
			</div>
			<div class="option">
				Comments
			</div>
		</div>
		<div class="servers">
			<div class="server col-1-1">
				<div class="col-3-12">
					<div class="in-server">
						12/20
					</div>
					<div class="join-server">
						Join Server
					</div>
				</div>
				<div class="col-9-12">
					<?php for ($i = 0;$i <= rand(20,20);$i++) { ?>
						<img src="https://storage.bopimo.com/avatars/3n4NhH9F0YNFQbTSQaDOp14BS.png" class="user" />
					<?php } ?>
				</div>
			</div>
			<div class="server col-1-1">
				<div class="col-3-12">
					<div class="in-server">
						12/20
					</div>
					<div class="join-server">
						Join Server
					</div>
				</div>
				<div class="col-9-12">
					<?php for ($i = 0;$i <= rand(1,20);$i++) { ?>
						<img src="https://storage.bopimo.com/avatars/3n4NhH9F0YNFQbTSQaDOp14BS.png" class="user" />
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php 

require "../site/footer.php";

?>