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
<?php
include('../func/connect.php');
include('../func/navbar.php');
include('../func/filter.php');

if($loggedIn){ 
}else{
	header("Location: ../");
  die();
}

$id = trim($conn->real_escape_string($_GET['id']));
if ($id < 1)
{
	header('Location: ../forum');
	exit();
}

$getthreadquery = $conn->query("SELECT * FROM `threads` WHERE `id` = '".$id."'");
$getthread = mysqli_fetch_object($getthreadquery);

if(isset($_POST['reply'])) {
$message = strip_tags($_POST['message']);
$message = trim($conn->real_escape_string($message));
$message = htmlentities($message);

    if(strlen(str_replace(array("\r", "\n"), '',$message)) >= 2 && strlen(str_replace(array("\r", "\n"), '',$message)) <= 1000) {
    }else{
      $error = "<br><div class='alert alert-danger' role='alert'>The body needs to be between 2 & 1000 Characters!</div>";
    }
    
      if ($user->now < $user->lastflood) {
        $error = "<br><div class='alert alert-danger' role='alert'>You're posting to fast!</div>";
    }
    $flood = $user->now + 10;
    $conn->query("UPDATE users SET lastflood='$flood' WHERE id='$user->id'");


    $time = time();
if(empty($error)){
    if(!empty($message)) {

	$findThread = $conn->query("SELECT * FROM `threads` WHERE `id`='$id'");
	$fetchThread = mysqli_fetch_object($findThread);

	$findForum = $conn->query("SELECT * FROM `topics` WHERE `id`='$fetchThread->forumid'");
	$fetchForum = mysqli_fetch_object($findForum);

	$createreplyquery = $conn->query("INSERT INTO `replies`(`topic_id`, `poster`,`message`,`date`,`forum_id`) VALUES('$id','$user->id','$message','$time','$fetchForum->id')");
		if($createreplyquery) {
	 	    $updateReplyDate = $conn->query("UPDATE `threads` SET `lastpostdate`='$time' WHERE `id`='$id'");
			if($updateReplyDate) {
		    $thread_id = $id;
		    $settopic = $conn->query("UPDATE `topics` SET `replies` = replies + 1 WHERE `id` = '$getthread->forumid'");
            $setthread = $conn->query("UPDATE `threads` SET `replies` = replies + 1 , `lastposter` = '$user->id' WHERE `id` = '$getthread->id'");
             echo'<meta http-equiv="refresh" content="0;url=../forum/view.php?id='.$id.'" />';
	   }else {
		            echo $conn->error;
		}
        } else {
            echo $conn->error;
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
<textarea class="form-control" name="message" rows="6" cols="50" placeholder="Reply to <?php echo "$getthread->name"; ?>"></textarea>
</div>
<div class="form-group">
<input type="submit" style="background-color: #1fc111;border-color: #1fc112;cursor: pointer;margin-left: 35px;" class="btn btn-success" name="reply" value="Create Reply">
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
  <br>
  <br>
  <?php include '../func/footer.php'; ?>
	</body>