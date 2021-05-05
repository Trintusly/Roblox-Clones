<?php
	include('SiT_3/config.php');
	include('SiT_3/header.php');
	
	if(!$loggedIn) {header("Location: index"); die();}
	
	$error = array();
	if(isset($_POST['submit']) && isset($_POST['currency']) && isset($_POST['value'])) {
		$currency = mysqli_real_escape_string($conn,$_POST['currency']);
		$value = mysqli_real_escape_string($conn,$_POST['value']);
		
		if($value > 0) {
			$userID = $_SESSION['id'];
			
			$currentBits = $userRow->{'bits'};
			$currentBucks = $userRow->{'bucks'};
			
			if($currency == 'toBits') {
				$newBits = $currentBits+10*$value;
				$newBucks = $currentBucks-$value;
				if($newBucks >= 0 && $newBits >= 0) {
					$convertSQL = "UPDATE `beta_users` SET `bucks`='$newBucks', `bits`='$newBits' WHERE `id`='$userID'";
					$convert = $conn->query($convertSQL);
					header("Location: money");
				} else {
					$error[] = "Insufficient bucks!";
				}
			}
			elseif($currency == 'toBucks') {
				if($value/10 == (int)($value/10)) {
					$newBits = $currentBits-$value;
					$newBucks = $currentBucks+(int)($value/10);
					if($newBucks >= 0 && $newBits >= 0) {
						$convertSQL = "UPDATE `beta_users` SET `bucks`='$newBucks', `bits`='$newBits' WHERE `id`='$userID'";
						$convert = $conn->query($convertSQL);
						header("Location: money");
					} else {
						$error[] = "Insufficient bits!";
					}
				} else {
					$error[] = "Value must be divisible by 10";
				}
			} else {$error[] = "Invalid currency";}
		} else {
			$error[] = "Amount must be greater than 0";
		}
	}
?>

<!DOCTYPE html>
	<head>
		<title>Money - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<h3>Money Exchange</h3>
				<?php
				if(!empty($error)) {
					echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
					foreach($error as $errno) {
						echo $errno."<br>";
					} 
					echo '</div>';
				}
				?>
				<form action="" method="POST" style="margin:10px;">
					<select name="currency" style="margin-bottom:10px;">
						<option value="toBits">To bits</option>
						<option value="toBucks">To bucks</option>
					</select><br>
					Amount: <input type="number" name="value" value="" style="margin-bottom:10px;"><br>
					<input type="submit" name="submit" value="Convert">
				</form>
			</div>
		</div>
	</body>
</html>