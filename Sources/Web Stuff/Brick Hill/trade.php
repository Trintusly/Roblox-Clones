<?php
	include('SiT_3/config.php');
	include('SiT_3/header.php');
?>
<!DOCTYPE html>
	<head>
		<title>Trade - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				hey mang yuo want trade yes no
			</div>
		</div>
		<script>
			window.onload = function() {
				getPage(1);
			};
			
			function getPage(page) {
				$("#crate").load("http://www.brick-hill.com/trade_crate?id="+<?php echo $id; ?>+"&type="+type+"&page="+page);
			};
		</script>
	</body>
</html>