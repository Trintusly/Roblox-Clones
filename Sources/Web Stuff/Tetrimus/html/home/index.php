<?php
include '../func/connect.php';
if($loggedIn){
}else{
    header("Location: ../");
}
$RefreshRate = rand(0,1000);

if(isset($_POST['post'])){
  $status = htmlentities($_POST['status']);
  $feedDate = time();

  $conn->query("UPDATE users SET status='$status' WHERE id='$user->id'");
  $conn->query("INSERT INTO feed (user_id,message,feed_date) VALUES ('$user->id','$status','$feedDate')");
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body>
<?php include '../func/navbar.php'; ?>
<div class="container">
  <div class="row">
  <div class="col-md-4" style="margin: 0px auto;float: none;">
    <div class="card">
    <div class="card-body">
    <font style="font-size: 18px;">Hello, <?php echo "$user->username"; ?></font>
    <div style="height:10px"></div>
    <center><img src='../images/<?php echo"" . $user->id . ".png?r=$RefreshRate' "; ?>height='300' width='300'onerror="this.src='../images/default.png'" /?</center>
     </div>
  </div>
  <div style="height: 15px;"></div>
  <div class="card">
    <div class="card-body">
        <font style="font-size: 18px;">Updates/Events</font>
        <div style="height: 10px;"></div>
        <?php
        $sql2 = "SELECT * FROM updates ORDER BY ID DESC";
        $result = $conn->query($sql2);

        $getupdateInfo = $conn->query("SELECT * FROM updates");
        $update = mysqli_fetch_object($getupdateInfo);

        while($row = $result->fetch_assoc()) {
          echo "-<i>".$row['desc_update']."</i>&nbsp;&nbsp;&nbsp;";   echo '<i class="fa fa-clock-o" aria-hidden="true"></i>';echo date('m/d/y', $update->date);echo"<br>";
          echo "Posted by: ".$row['posted_by']."";
        }
        ?>
     </div>
  </div>
  <div style="height: 15px;"></div>

</div>
  <div class="col-md-8" style="margin: 0px auto;float: none;">
    <div class="card">
    <div class="card-body">
      <form action="" method="Post">
<div class="input-group">
      <input type="text" class="form-control" name="status" placeholder="<?php echo $user->status;?>">
  <div class="input-group-append">
    <input type="submit" class="btn btn-outline-success" value="Post" name="post">
  </div>
</div>
</form>
     </div>
  </div>
<div style="height: 10px;"></div>
<div class="row">
<?php 
	  /* Hi, noynac aka Sushi here! I'll be adding notifications here. */
            $fetchFriends = $conn->query("SELECT * FROM friends WHERE receiver = '$user->id' AND accepted = '1' OR sender = '$user->id' AND accepted = '1'");
            $areFriends = mysqli_num_rows($fetchFriends);
            if($areFriends == 0) {
              echo ' You dont hvae any friends so you dont have any feed!';
            }else{
              while($friend = mysqli_fetch_object($fetchFriends)) {
                  if($friend->receiver == $user->id) {
                      $gFriend = $conn->query("SELECT * FROM users WHERE id = '$friend->sender'");
                  }else if($friend->sender == $user->id) {
                      $gFriend = $conn->query("SELECT * FROM users WHERE id = '$friend->receiver'");
                  }
                  $friendInfo = mysqli_fetch_object($gFriend);
  				  
  				  //now we fetch your friends feed
  				  $fetchFeed = $conn->query("SELECT * FROM feed WHERE user_id='$friendInfo->id' ORDER BY id DESC LIMIT 10");
  				  while($feed = mysqli_fetch_object($fetchFeed)) {
  				  	$findUsr = $conn->query("SELECT * FROM users WHERE id='$feed->user_id'");
  				  	$userInfo = mysqli_fetch_object($findUsr);
  				  	echo '<div class="col-md-12">
    						<div class="card">
    							<div class="card-header">
    							<a href="../profile.php?id='.$feed->user_id.'" style="text-decoration:none;"><img src="../images/'.$feed->user_id.'.png" style="height: 30px;width: 30px;" class="img-thumbnail">
    								<span style="margin-left: 10px;">'.$userInfo->username.'</span><span style="float: right;font-size: 12px;">
    									<i class="fa fa-clock-o" aria-hidden="true"></i>
    								</span>
    							</a>
    						</div>
    						<div class="card-body">"'.$feed->message.'"</div>
    					  </div>
    					  <div style="height: 10px;"></div></div>'; 				  	
  				  }
              }
            }
  ?>

    </div>
  

</div>
</div>

</div>
<?php include '../func/footer.php'; ?>
</body>
</html>