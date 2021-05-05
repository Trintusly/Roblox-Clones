<!DOCTYPE html>
<?php 
  session_start();
  include('../SiT_3/config.php');
  $id = $_SESSION['id'];
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  }
  
  $findAvatarSQL ="SELECT * FROM `avatar` WHERE `user_id` = '".$id."' ";
  $findAvatar = $conn->query($findAvatarSQL);
  $avatar = (object) $findAvatar->fetch_assoc();

ini_set('post_max_size', '500M');
ini_set('upload_max_filesize', '500M');

   // define('UPLOAD_DIR', 'avatars/');
  if(isset($_POST['inputimg'])){
    echo"not so bad news :)";
  }else{
    echo"vbad news. i quit";
  }
  //$img = $_POST['inputimg'];
  //$img2 = str_replace('data:image/png;base64,', '', $img);
  //$img3 = str_replace(' ', '+', $img2);
  //$data = base64_decode($img3);
  //echo "$img $imageData Bruh is getting annoying";
  /*$file = UPLOAD_DIR . $avatar['id'] . '.png';
  $success = file_put_contents($file, $data);
  print $success ? $file : 'Unable to save the file.';
  */
  
  // if (isset($_POST['img'])) {echo "bonjourno";}
?>

