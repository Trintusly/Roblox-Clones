<?php
include('../func/connect.php');
include('../func/navbar.php');

 if($user->power == 0){
	header("Location: ../");
	}
?>
<!DOCTYPE html>
<html>
<body>

<form action="upld.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    Model (OBJ): <input type="file" name="model" id="model"><br>
    Texture (PNG): <input type="file" name="texture" id="texture"><br>
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
