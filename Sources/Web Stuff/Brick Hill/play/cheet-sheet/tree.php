<?php 

if (isset($_POST['x'])) {
	$x = $_POST['x'];
	$y = $_POST['y'];
	$z = $_POST['z'];
	$b = $_POST['b']; // base height, on Isaiah's islands the base height would be 5 so the tree would be on the island
	$h = $_POST['h'] + $b;
	$tree = '
=" '.$x.' '.$z.' 5 2 2 '.$h.' 5384469 1 1
=" '.$x.' '.$z.' '.($h + 1).' 7 7 1 3825419 1 1
=" '.$x.' '.$z.' '.($h + 2).' 6 6 1 3825419 1 1
=" '.$x.' '.$z.' '.($h + 3).' 5 5 1 3825419 1 1
=" '.$x.' '.$z.' '.($h + 4).' 4 4 1 3825419 1 1
=" '.$x.' '.$z.' '.($h + 5).' 3 3 1 3825419 1 1
=" '.$x.' '.$z.' '.($h + 6).' 2 2 1 3825419 1 1
=" '.$x.' '.$z.' '.($h + 7).' 1 1 1 3825419 1 1';


?>

<fieldset>
	<legend>Output</legend>
	<textarea style="height: 500px;width:100%;">
	<?php echo $tree; ?>
	</textarea>
</fieldset>
<?php } ?>
<form action="" method="POST">
<fieldset>
	<legend>Input</legend>
	X: <input name="x" type="int">
	<br>
	Y: <input name="y" type="int">
	<br>
	Z: <input name="z" type="int">
	<br>
	height: <input name="h" type="int">
	<br>
	base height: <input name="b" type="int">
	<button>Submit!</button>
</fieldset>
</form>