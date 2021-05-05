<?php 
include('../SiT_3/config.php');
include('../SiT_3/header.php');
include('../SiT_3/PHP/helper.php');

$gameID = mysqli_real_escape_string($conn, intval($_GET['id']));

$findGameSQL = "SELECT * FROM `games` WHERE `id` = '$gameID'";
$findGame = $conn->query($findGameSQL);
if ( $findGame->num_rows > 0 ) {$gameRow = (object) $findGame->fetch_assoc();
} else {header("location: ../");}
?>
<!DOCTYPE html>
<html>

	<head>
	<title><?php echo $gameRow->{'name'}.' - Brick Hill'; ?></title>
	<?php if($loggedIn) { ?>
	<script>
		function launchClient() {
			var launchURI = "brickhill:<?php 
			
			$gameString = $userRow->{'unique_key'}."-".$gameRow->{'id'}."-client";  //userRow->{'id'}
			$gameLaunch = gameLaunch($gameString);
			echo $gameLaunch;
			?>";
			var coolInput = "<?php echo $gameString; ?>";
			
			window.location = launchURI;
			
			/*var parentElement = document.getElementById("brickClient");
			var brickClient = document.createElement('iframe');
			
			brickClient.setAttribute('src',launchURI);
			parentElement.appendChild(brickClient);*/
		}
		</script>
	<?php } ?>
	</head>
	
	<body>
	<div id="body">
      <div id="box">
        <h3 style="margin-left: 12px;"><?php echo htmlentities( $gameRow->{'name'} ); ?></h3><h5 style="margin-left: 12px;text-transform: capitalize;">Brick Hill Game</h5>        <span style="display:inline-block; float:left; width:640px;">
          
          <img id="shopItem" style="float:left; margin: 0px 10px 0px 10px; width: 340px; height: 244px;" src="<?php echo 'http://storage.brick-hill.com/images/games/' . $gameRow->{'id'} . '.png'; ?>">
                    
              <span style="display:inline-block;">
              <?php 
              if($gameRow->{'active'} == 1) {
                echo '<a style="color:Red;">'.$gameRow->{'playing'}.' playing</a>
                <br>';
                if ($loggedIn) {echo '<input style="padding:7px 10px 7px 10px; border:1px solid #000; background-color:Green; color:#FFF;" type="button" value="Play" onclick="launchClient()">';} else {
                echo '<a href="/login/"><input style="padding:7px 10px 7px 10px; border:1px solid #000; background-color:Green; color:#FFF;" type="button" value="Play"></a>';
                }
              } else {
              	echo '<a style="color:Red;">This server is not being hosted</a>';
              }
              ?>
              </span>
                        <p><?php echo htmlentities( $gameRow->{'description'} ); ?></p>
          <h6>Created: <?php echo $gameRow->{'date'}; ?>
          <br>Last Updated: <?php echo $gameRow->{'last_updated'}; ?>
          <br>Visits: <?php echo $gameRow->{'visits'}; ?>
          </h6><br>
          <?php echo '<a href="/report?type=game&id='.$gameRow->{'id'}.'"><i style="color:#444;font-size:13px;" class="fa fa-flag"></i></a>'; ?>
                  </span>
        <span style="display:inline-block; float:right;">
        <?php 
	 // Find Creator
	 $ownerID = $gameRow->{'creator_id'}; 
	 $findOwnerSQL = "SELECT * FROM `beta_users` WHERE `id` = $ownerID";
	 
	 $findOwner = $conn->query($findOwnerSQL);
	 $ownerRows = (object) $findOwner->fetch_assoc();
	 ?>
          <img style="width:225px; background-color:transparent;" src="http://storage.brick-hill.com/images/avatars/<?php echo $ownerRows->{'id'}.'.png?c='.$ownerRows->{'avatar_id'};?>">
          <h5>Created by:</h5>
          <a href="http://www.brick-hill.com/user?id=<?php echo $ownerID; ?>" style="color:#222;"><h4><?php echo $ownerRows->{'username'}; ?></h4></a>
        </span>
      </div>
    </div>
	
	
	
	
	
	<?php
		include("../SiT_3/footer.php");
	?>
	</body>
	
</html>