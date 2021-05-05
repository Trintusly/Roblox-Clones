<?php 
include('../SiT_3/config.php');
include('../SiT_3/header.php');

?>
<!DOCTYPE html>
<html>

	<head>
		
		<title>Games - Brick Hill</title>
		
	</head>
	
	<body>
		
		<div id="body">
			<div id="box" style="padding-top: 9px;padding-left: 9px;">
			<?php 
			
			$findGamesSQL = "SELECT * FROM `games` WHERE `active`='1' ORDER BY `playing` DESC";
			$findGames = $conn->query($findGamesSQL);
			
			if ($findGames->num_rows > 0) {
				while($gameRow = $findGames->fetch_assoc()) {
					
					// Change array to OOP Array
					
					$gameRow = (object) $gameRow;
					
					// Find Game Owner
					
					$ownerID = $gameRow->{'creator_id'};
					$findOwnerSQL = "SELECT * FROM `beta_users` WHERE `id` = $ownerID";
					$findOwner = $conn->query($findOwnerSQL);
					$ownerRow = (object) $findOwner->fetch_assoc();
					
			?>
				<div style="margin: 10px; width: 196px; display:inline-block; ;"><a href="set?id=<?php 
					echo $gameRow->{'id'};
					?>"><img id="shopItem" style="width:196px;" src="<?php echo 'http://storage.brick-hill.com/images/games/' . $gameRow->{'id'} . '.png'; ?>"></a>
					<span style="display:inline-block; float:left; width:100%">
						<a class="shopTitle" href="set?id=<?php 
					echo $gameRow->{'id'}; ?>"><?php echo $gameRow->{'name'}; ?></a>
					</span>
					<span style="display:inline-block; float:left; padding-left:0px;"><p class="shopDesc">by<a class="shopDesc" href="http://www.brick-hill.com/user?id=<?php echo $ownerID; ?>"><?php echo $ownerRow->{'username'}; ?></a></p></span>
					<span style="padding:0px; display:inline-block; float:right; text-align:right"><p class="shopDesc" style="color:Red;"><?php echo $gameRow->{'playing'}; ?> online</p></span>
					</div>
				
				
			<?php 
				}
				} else {
					?>
					<div style="text-align:center;">
						There aren't any active servers!
					</div>
					<?php
				}
			?>
			</div>
		</div>
		
		<?php
		include("../SiT_3/footer.php");
		?>
		
	</body>
	
</html>
