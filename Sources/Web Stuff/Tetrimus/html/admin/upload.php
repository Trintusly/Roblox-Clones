<?php
include('../func/connect.php');
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<?php
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
