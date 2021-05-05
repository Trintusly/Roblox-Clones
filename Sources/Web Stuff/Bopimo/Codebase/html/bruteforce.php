<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_SESSION['in']))
	{
	?>
	<style>
	body {
		font-family: helvetica;
	}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
	window.onload = function() {
		if (window.jQuery) {  
			// jQuery is loaded  
			alert("Yeah!");
		} else {
			// jQuery is not loaded
			alert("Doesn't Work");
		}
	}
	</script>
	<?php
	if(!isset($_POST['list'])) {
		?>
		<h1>List here:</h1>dwadsa
		<form action="/bruteforce.php" method="POST">
			<textarea name="list" placeholder="list here"></textarea>
			<input type="submit" value="submit">
		</form>
		<?php
	} else {
		$list = explode(" ", $_POST['list']);
		$num = 1;
		$thing = [];
		?>
		<br>
		<?php
		
		foreach($list as $row){
			//echo $row;
			$newthing = explode(":", $row);
			$pass = rtrim($newthing[1], " ");
			?>
			<div style="margin-bottom:10px;height:140px;width:300px;;border:solid black 1px;text-align:left;float:left;margin-left:5px;margin-right:5px;">
				<br>
				<img src="https://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&username=<?=$newthing[0]?>" style="height:100px;width:100px;float:left;">
				Account #<?=$num?>:<br>Username: <?=htmlentities($newthing[0])?><br>Password: <?=htmlentities($pass)?><br>
				BC: <img src="https://www.roblox.com/Thumbs/BCOverlay.ashx?username=<?=$newthing[0]?>">
				<br>
				<a target="_blank" href="https://www.roblox.com/search/users?keyword=<?=$newthing[0]?>">Search for user</a>
			</div>
			<?php
		}
		?>
		
		<?php
	}
} else {
	die(header("location: /"));
}
?>
