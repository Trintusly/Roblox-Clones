<?php 

include("../SiT_3/header.php");

?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/style.css" type="text/css">
		<style>
			
		</style>
	</head>
	
	<body>
		<div id="body">
			<div style="width: 19%;float:left;">
				<div id="box" style="border-sizing: border-box;">
				<div style="background-color:rgba(0,0,0,0.2);border-bottom: 1px solid #000;text-align:center;padding:5px;">
				Login
				</div>
				<div style="padding:5px;">
					<form action="/login/" method="POST" >
						<label for="unameLoginInput">
							Username
						</label>
						<input id="unameLoginInput" type="text" name="username" style="width:99%;">
						<label for="pwordLoginInput">
							Password
						</label>
						<input id="pwordLoginInput" type="text" name="username" style="width:99%;">
						<div style="margin-top:5px;text-align:center;">
						<button>Login</button>
						</div>
					</form>
				</div>
				</div>
			</div>
			<div style="width: 80%;float:right;">
				<div id="box">
					<h2>Brick Hill</h2>
					<div style="padding: 5px;">
					donald trump bought brick hill
					</div>
				</div>
			</div>
		</div>
	</body>
	
</html>