<?php
include('../../SiT_3/config.php');
include('../../SiT_3/header.php');
include('../../SiT_3/PHP/helper.php');

if(!$loggedIn) { header('Location: ../');die(); }

if(isset($_POST['submit'])) {
	$error = array();
	if(isset($_FILES['image'])) {
		$imgName = $_FILES['image']['name'];
		$imgSize = $_FILES['image']['size'];
		$imgTmp = $_FILES['image']['tmp_name'];
		$imgType = $_FILES['image']['type'];
		$isImage = getimagesize($imgTmp);
		
		if($isImage !== false) {
			if($imgSize < 2097152) {
				if(isset($_POST['name'])) {
					if(isset($_POST['bits']) or isset($_POST['bucks'])) {
						$name = mysqli_real_escape_string($conn,$_POST['name']);
						$desc = mysqli_real_escape_string($conn,$_POST['description']);
						$bits = mysqli_real_escape_string($conn,$_POST['bits']);
						$bucks = mysqli_real_escape_string($conn,$_POST['bucks']);
						
						if(isset($_POST['free'])) {$bits = 0; $bucks = 0;} else {$bits = max(1,$bits); $bucks = max(1,$bucks);}
						if(isset($_POST['offsale'])) {$bits = -1; $bucks = -1;}
						
						$ownerID = $_SESSION['id'];
						$today = date("Y-m-d");
						
						$newSQL = "INSERT INTO `shop_items` (`id`,`owner_id`,`name`,`description`,`bucks`,`bits`,`type`,`date`,`last_updated`,`offsale`,`collectible`,`collectable-edition`,`collectible_q`,`zoom`) VALUES (NULL,'$ownerID','$name','$desc','$bucks','$bits','pants','$today','$today','no','no','no','0',NULL)";
						$new = $conn->query($newSQL);
						$itemID = $conn->insert_id;
						
						$addItem = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$ownerID','$itemID','1')";
						$add = $conn->query($addItem);
						
						move_uploaded_file($imgTmp,"../../shop_storage/assests/pants/".shopItemHash($itemID).".png");
						header('Location: ../../../shop/item?id='.$itemID.'&render');
					} else {
						$error[] = "Your item needs a price!";
					}
				} else {
					$error[] = "Your item needs a name!";
				}
			} else {
				$error[] = "File size must be smaller than 2MB";
			}
		} else {
			$error[] = "File must be an image!";
		}
	} else {
		$error[] = "You did not upload pants!";
	}
}

?>

<!DOCTYPE html>
	<head>
		<title>Upload Pants - Brick Hill</title>
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
					<form style="margin:10px;" action="" method="POST" enctype="multipart/form-data">
						<input type="text" name="name" style="font-size:14px;padding:4px;margin-bottom:10px;" placeholder="Title"><br>
						<input type="file" name="image" style="margin-bottom:10px;"><br>
						<textarea name="description" placeholder="Description" style="width:320px;height:100px;margin-bottom:10px;"></textarea><br>
						<input style="margin-bottom:10px;" type="checkbox" name="offsale" value="offsale">Offsale<br>
						<input style="margin-bottom:10px;" type="checkbox" name="free" value="free">Free<br>
						Bits: <input style="font-size:14px;padding:4px;margin-bottom:10px;width:80px;" type="number" min="1" name="bits" placeholder="0 bits">
						Bucks: <input style="font-size:14px;padding:4px;margin-bottom:10px;width:80px;" type="number" min="1" name="bucks" placeholder="0 bucks"><br>
						<input type="submit" name="submit">
					</form>
				</div>
				<img src="template.png" style="float:right;width:50%;height:50%px;margin:10px;">
			</div>
		</div>
	</body>
</html>

<?php
include('../../SiT_3/footer.php');
?>