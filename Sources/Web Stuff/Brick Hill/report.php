<?php
include('SiT_3/config.php');
include('SiT_3/header.php');

if(!$loggedIn) {header("Location: index"); die();}

$error = array();
$reportTypes = array('post','thread','user','game','clan','item','message');
if(isset($_POST['report'])) {
	if(isset($_POST['type']) && isset($_POST['id']) && isset($_POST['reason'])) {
		$type = mysqli_real_escape_string($conn,$_POST['type']);
		if(!in_array($type, $reportTypes)) {
			$error[] = "Invalid report type";
		} else {
			$id = mysqli_real_escape_string($conn,intval($_POST['id']));
			$reason = mysqli_real_escape_string($conn,$_POST['reason']);
			$userID = $_SESSION['id'];
			$reportSQL = "INSERT INTO  `reports` (`id`,`user_id`,`r_type`,`r_id`,`r_reason`,`seen`) VALUES (NULL,'$userID','$type','$id','$reason','no')";
			$report = $conn->query($reportSQL);
		}
	} else {
		$error[] = "Invalid report data";
	}
} else {
	if(!(isset($_GET['type']) && isset($_GET['id']))) {
		$error[] = "Invalid report data";
	} else {
		$r_type = mysqli_real_escape_string($conn,$_GET['type']);
		$r_id = mysqli_real_escape_string($conn,intval($_GET['id']));
		if(!in_array($r_type, $reportTypes)) {
			$error[] = "Invalid report type";
		}
	}
}

?>

<!DOCTYPE html>
	<head>
		<title>Report - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<?php
				if(!isset($_POST['report'])) {
					if(!empty($error)) {
						echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
						foreach($error as $errno) {
							echo $errno."<br>";
						} 
						echo '</div>';
					} else {
					echo '<div style="padding:10px;">
					<h3>Report</h3>
					<form action="report" method="POST">
						<input type="hidden" name="type" value="'.$r_type.'">
						<input type="hidden" name="id" value="'.$r_id.'">
						<h5>Reason:</h5>
						<textarea name="reason" style="margin:5px;width:310px;height:150px;"></textarea><br>
						<input type="submit" name="report" style="margin:5px;">
					</form>
					</div>';
						}
				} else {
					echo '<div style="padding:10px;">
					<h3>Your report will be reviewed shortly</h3>
					<h5>Thank you for keeping this community safe</h5>
					</div>';
				}
				?>
			</div>
		</div>
	</body>
</html>