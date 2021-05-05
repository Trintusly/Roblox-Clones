<?php
include '../func/connect.php';
if(!$loggedIn) {
	header("Location: ../");
}


?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forum | Tetrimus</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body>
<?php
include '../func/navbar.php';
include('../func/filter.php');


$id = trim($conn->real_escape_string($_GET['id']));
if ($id < 1)
{
	header('Location: ../forum');
	exit();
}

$topicQ = $conn->query("SELECT * FROM `topics` WHERE `id` = '".$id."'");
$topic = mysqli_fetch_object($topicQ);

$exists = $conn->query("SELECT * FROM `topics`");


if($id > mysqli_num_rows($exists)){
	header('Location: ../forum');
	exit();
}

/*   
    if($user->power == 0){
    if($topic->id >= 0){
     echo"<script>window.location.replace('../forum');</script>";
    }
}
*/
if(isset($_POST['create'])) {
    
$name = strip_tags($_POST['name']);
$name = trim($conn->real_escape_string($name));
$name = htmlentities($name);

$message = strip_tags($_POST['message']);
$message = trim($conn->real_escape_string($message));
$message = htmlentities($message);

if(substr($name,-1) == " " || substr($name,0,1) == " ") {
        $error = "<br><div class='alert alert-danger' role='alert'>You can't have spaces at the beginning of your titles!</div>";
    }
	if(substr($message,-1) == " " || substr($message,0,1) == " ") {
        $error = "<br><div class='alert alert-danger' role='alert'>You can't have spaces at the beginning of your body!</div>";
    }
    if(strlen($name) < 3 || strlen($name) > 50) {
        $error = "<br><div class='alert alert-danger' role='alert'>The thread name needs to be between 3 & 50 Characters!</div>";
    }
    if(strlen(str_replace(array("\r", "\n"), '',$message)) >= 2 && strlen(str_replace(array("\r", "\n"), '',$message)) <= 1000) {
        
    }else{
      $error = "<br><div class='alert alert-danger' role='alert'>The thread body needs to be between 5 & 3000 Characters!</div>";
    }
    
    $time = time();
    if ($user->now < $user->lastflood) {
        $error = "<br><div class='alert alert-danger' role='alert'>You're posting to fast!</div>";
    }
    $flood = $user->now + 10;
	$conn->query("UPDATE users SET lastflood='$flood' WHERE id='$user->id'");


if(empty($error)){
	if($id == 1 || $id < 0 || $id == 0 || $id > 6) {
		if($user->power > 0) {
			    if(!empty($name) && !empty($message)) {
	$createthreadquery = $conn->query("INSERT INTO `threads`(`forumid`, `name`, `poster`,`message`,`lastposter`,`date`,`lastpostdate`,`replies`,`pinned`,`locked`) VALUES('$id','$name','$user->id','$message','$user->id','$time','$time','0','0','0')");
		if($createthreadquery) {
		    $thread_id = $conn->insert_id;
		    $setthread = $conn->query("UPDATE `topics` SET `threads` = threads + 1 WHERE `id` = '".$id."'");
		    echo"<script>window.location.replace('../forum/view.php?id=".$thread_id."');</script>";
        } else {
            echo $conn->error;
        }  
    }
		}else{
			$error = "<center>Sorry, you cant post here!</center>";
		}
	}else{
    if(!empty($name) && !empty($message)) {
	$createthreadquery = $conn->query("INSERT INTO `threads`(`forumid`, `name`, `poster`,`message`,`lastposter`,`date`,`lastpostdate`,`replies`,`pinned`,`locked`) VALUES('$id','$name','$user->id','$message','$user->id','$time','$time','0','0','0')");
		if($createthreadquery) {
		    $thread_id = $conn->insert_id;
		    $setthread = $conn->query("UPDATE `topics` SET `threads` = threads + 1 WHERE `id` = '".$id."'");
		    echo"<script>window.location.replace('../forum/view.php?id=".$thread_id."');</script>";
        } else {
            echo $conn->error;
        }  
    }
  }
}
}

?>
<div class="container">
  <div class="row">
      <div class="col-md-8" style="margin: 0px auto;float:none;">
             <?php
        if(!empty($error)){
            echo $error;
        }
        ?>
      <div class="card">
    <div class="card-body" style="padding: 35px;">
<form method="POST" action="">
<input type="text" class="form-control" name="name" placeholder="Thread name" >
<div style="height:15px;"></div>
<textarea class="form-control" name="message" rows="6" cols="50" placeholder="Thread body"></textarea>
</div>
<div class="form-group">
<input type="submit" style="cursor: pointer;margin-left: 35px;" class="btn btn-outline-success" name="create" value="Create Thread">
</div>
<div style="height:15px;"></div>
</form>
</div>
	</div>
	</div>
	</div>
	</div>
  <br>
  <br>
  <?php include '../func/footer.php'; ?>
	</body>
