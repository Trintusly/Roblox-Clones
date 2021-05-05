<?php
include('SiT_3/config.php');
include('SiT_3/header.php');
?>

<!DOCTYPE html>
	<head>
		<title>Brick Hill - Forbidden</title>
	</head>

	<body>
		<div id="body" style="text-align:center;">
			<div id="box">
				<div id="subsect" style="padding: 0px;">
					<h3 style="margin-bottom: 0px;">403 Forbidden</h3>
					<h4 style="color:#444; margin-top:10px;">You've seen too much!</h4>
				</div>
				<?php
				$users = array(1,2,3,4);
				shuffle($users);
				foreach($users as $u) {
					echo '<img style="height: 250px;" src="http://storage.brick-hill.com/images/avatars/'.$u.'.png">';
				}
				?>
			</div>
		</div>
		<?php
		include('SiT_3/footer.php');
		?>
	</body>
</html>