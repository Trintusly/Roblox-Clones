<?php
include("../SiT_3/config.php");
include("../SiT_3/header.php");

if(!$loggedIn) {header("Location: index"); die();}

$userID = $_SESSION['id'];
$currentSQL = "SELECT * FROM `beta_users` WHERE `id` = '$userID' ";
$currentUser = $conn->query($currentSQL);
$currentRow = mysqli_fetch_assoc($currentUser);
$power = $currentRow['power'];

if (isset($_GET['id'])) {
	$itemID = mysqli_real_escape_string($conn,intval($_GET['id']));
	$sql = "SELECT * FROM `shop_items` WHERE  `id` = '$itemID'";
	$result = $conn->query($sql);
	$shopRow = $searchRow=$result->fetch_assoc();
	if($_GET['id'] == $shopRow['id']) {} else { header('Location: /shop/');}
	$id = $searchRow['owner_id'];
	$sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$id'";
	$userResult = $conn->query($sqlUser);
	$userRow=$userResult->fetch_assoc();
} else {
	header('Location: /shop/');
	die();
}

if($shopRow['owner_id'] != $_SESSION['id'] && $power < 1) {
	header("Location: item?id=".$itemID);
	die();
}

$error = array();
if(isset($_POST['submit'])) {
	if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['bits']) && isset($_POST['bucks'])) {
		if(isset($_POST['special']) && $power >= 1 && ($shopRow['type'] == 'hat' || $shopRow['type'] == 'tool' || $shopRow['type'] == 'face')) {
			$special = 'yes';
			
			//find stock
			$stockSQL = "SELECT * FROM `crate` WHERE `item_id`='$itemID' ORDER BY `serial` DESC";
			$stock = $conn->query($stockSQL);
			$newStock = $stock->num_rows;
		} else {
			$special = 'no';
			$stock = '0';
		}
		$name = mysqli_real_escape_string($conn,$_POST['name']);
		$desc = mysqli_real_escape_string($conn,$_POST['description']);
		$bits = mysqli_real_escape_string($conn,$_POST['bits']);
		$bucks = mysqli_real_escape_string($conn,$_POST['bucks']);
		
		$bits = max($bits,-1);
		$bucks = max($bucks,-1);
		
		if(isset($_POST['offsale'])) {$bits = -1; $bucks = -1;}
		
		$updateSQL = "UPDATE `shop_items` SET `name`='$name', `description`='$desc', `bits`='$bits', `bucks`='$bucks', `collectible`='$special', `collectible_q`='$newStock' WHERE `id`='$itemID'";
		$update = $conn->query($updateSQL);
		
		header("Location: item?id=".$itemID);
	} else {
		$error[] = "Invalid post data";
	}
}

?>

<!DOCTYPE html>
	<head>
		<title>Edit Item - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<?php
				if(!empty($error)) {
					echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
					foreach($error as $errno) {
						echo $errno."<br>";
					} 
					echo '</div>';
				}
				?>
				<div style="float:left;">
					<form style="margin:10px;" action="" method="POST">
						<input type="text" name="name" style="font-size:14px;padding:4px;margin-bottom:10px;" placeholder="Title" value="<?php echo $shopRow['name']; ?>"><br>
						<textarea name="description" placeholder="Description" style="width:320px;height:100px;margin-bottom:10px;"><?php echo $shopRow['description']; ?></textarea><br>
						<input style="margin-bottom:10px;" type="checkbox" name="offsale" value="offsale" <?php 
						if(($shopRow['bits'] == -1) && ($shopRow['bucks'] == -1)) {
							echo 'checked';
						}
						?>>Offsale<br>
						<?php
						
						if($power >= 1) {
							if($shopRow['type'] == 'hat' || $shopRow['type'] == 'tool' || $shopRow['type'] == 'face') {
								echo '<input style="margin-bottom:10px;" type="checkbox" name="special" value="special"';
								if($shopRow['collectible'] == 'yes') {
									echo 'checked';
								}
								echo '>Special<br>';
							}
						}
						
						?>
						Bits: <input style="font-size:14px;padding:4px;margin-bottom:10px;width:80px;" type="number" name="bits" placeholder="0 bits" value="<?php echo $shopRow['bits']; ?>">
						Bucks: <input style="font-size:14px;padding:4px;margin-bottom:10px;width:80px;" type="number" name="bucks" placeholder="0 bucks" value="<?php echo $shopRow['bucks']; ?>"><br>
						<input type="submit" name="submit">
					</form>
				</div>
				<img src="/shop_storage/thumbnails/<?php echo $searchRow['id']; ?>.png" style="float:right;margin:10px;">
			</div>
		</div>
	</body>
</html>