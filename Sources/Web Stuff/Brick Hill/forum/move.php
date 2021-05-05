<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header("Location: index"); die();}
	if($power < 1) {header("Location: index"); die();}
	
	if(isset($_GET['id'])) {
		$threadID = $_GET['id'];
		$threadIDSafe = mysqli_real_escape_string($conn, $threadID);
	} else {
		header("Location: index");
	}
	
	if(isset($_POST['move'])) {
		$boardID = mysqli_real_escape_string($conn,$_POST['move']);
		$moveSQL = "UPDATE `forum_threads` SET `board_id`='$boardID' WHERE `id`='$threadIDSafe'";
		$move = $conn->query($moveSQL);
		header("Location: thread?id=".$threadIDSafe);
	}
?>

<!DOCTYPE html>
	<head>
		<title>Move thread - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<form action="" method="POST">
					<select name="move">
						<?php
							$boardsSQL = "SELECT * FROM `forum_boards`";
							$boards = $conn->query($boardsSQL);
							while($boardRow = $boards->fetch_assoc()) {
								echo '<option value="'.$boardRow['id'].'">'.$boardRow['name'].'</option>';
							}
						?>
					</select>
					<input type="submit">
				</form>
			</div>
		</div>
	</body>
	<?php include("../SiT_3/footer.php"); ?>
</html>