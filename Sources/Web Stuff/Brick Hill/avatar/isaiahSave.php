<?php 
//header("Content-type: image/png");
session_start();
  session_start();
  include('../SiT_3/config.php');
  
  $id = $_SESSION['id'];
  
  $findAvatarSQL ="SELECT * FROM `avatar` WHERE `user_id` = '".$id."' ";
  $findAvatar = $conn->query($findAvatarSQL);
  if ($findAvatar->num_rows > 0) {

  $cacheAvatarSQL = "UPDATE `avatar` SET `cache`='".rand()."' WHERE `user_id`='".$id."'";
  $cacheAvatar = $conn->query($cacheAvatarSQL);

  if(isset($_POST['img'])){

	$image64 = $_POST['img'];

	if(base64_decode($image64)) {
		$img = base64_decode($image64);
		$ID = $_SESSION['id'];
		$imageFile = fopen("../../storage_subdomain/images/avatars/$ID.png", "w") or die("Unable to open file!");
		$data = $img;
		if ($imageFile) {
			
			$writeImage = fwrite($imageFile, $data);
			
			if ($writeImage) {
				
				?> <script> window.location = "http://storage.brick-hill.com/images/avatars/<?php echo $ID; ?>.png?c=<?php echo rand() ?>"; </script>
				<?php
				die();
				
			}
			
			fclose($imageFile);
		}
		
	} 
	
  }else{
	  
    echo"Bad post data.";
	
  }
  
  } else {
	  header("Location: /login/");
	  die();
  }
?>

