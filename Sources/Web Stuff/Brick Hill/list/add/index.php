<?php
 
    include("../../SiT_3/config.php");
    include("../../SiT_3/header.php");
    include("../../SiT_3/PHP/helper.php");
    
if($power > 0) {
//Let them continue. They must be a admin :o
} 
else {
header('Location: ../../');
}
  $error = array();
  if(isset($_POST['submit'])) {
    if(isset($_POST['hatname'])) {
      $hatname = $_POST['hatname'];
    } else {
      $error[] = "You must have a hat name, you silly nigger";
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add - Brick Hill</title>
</head>
<body>
	<div id="body">
		<div id="box" style="padding:10px;">
		<form action="" method="post">
			<input name="hatname" type="text"> <input type="submit" value="Upload hat">
		</form>
		</div>
	</div>
</body>
</html>