<?php
	include('../SiT_3/config.php');
	include('../SiT_3/header.php');
	//if(!$loggedIn || $power <= 0) {header("Location ../index");}
?>
<!DOCTYPE html>
	<head>
		<title>Download - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<div id="subsect" style="margin-left:10px;width:560px;">
					<h3>Download</h3>
				</div>
				<div style="padding:0px 14px 14px 14px;float:left;">
					<div id="subsect" style="width:380px;">
						<h4 style="float:left;">Play</h4>
						<h5 style="float:left;padding-top: 3px;">Version: <?php include('version.php') ?></h5><br><br>
						<a href="Brick Hill Setup.msi">
						<input type="button" style="width:194px;height:34px;padding-left:22px;font-size:16px;" value="Client"></a>
						<h6>3.66MB</h6>
						<br>
						<a href="">
						<input type="button" style="width:194px;height:34px;padding-left:22px;font-size:16px;" value="Server"></a>
						<h6>4.12MB</h6>
					</div>
					<h4>Create</h4>
					<a href="Workshop.exe">
					<input type="button" style="width:194px;height:34px;padding-left:22px;background-color:#03c303;font-size:16px;" value="Workshop"></a>
					<h6>4.26MB</h6>
				</div>
				<img style="float:right;margin-right:10px;" src="launcher.png">
			</div>
		</div>
		<?php
			include('../SiT_3/footer.php');
		?>
	</body>
</html>