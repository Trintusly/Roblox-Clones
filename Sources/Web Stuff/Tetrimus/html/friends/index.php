<?php
include '../func/connect.php';
if($loggedIn){
}else{
    header("Location: ../");
}
$RefreshRate = rand(0,1000);
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Friends | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png">
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
  <div class="col-md-10" style="margin: 0px auto;float: none;">
  <div class="card">
  <div class="card-body">
 <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Friends</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sent</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Request</a>
  </li>
</ul>
</div>
</div>
<div style="height: 15px;"></div>
</div>
<?php

$fetchRequests = $conn->query("SELECT * FROM friends WHERE receiver = '$user->id' AND accepted = '0'");
$areRequests = mysqli_num_rows($fetchRequests);


if(isset($_POST["add"])) {
  $id = $_POST["fid"];
  $add = $conn->query("UPDATE friends SET accepted = '1' WHERE id = '$id' AND receiver = '$user->id'");
  echo '<meta http-equiv="refresh" content="0">';
  //header('Location: ../friends/index.php?add=true');
}
if(isset($_POST["remove"])) {
  $id = $_POST["fid"];
  $remove = $conn->query("DELETE FROM friends WHERE id = '$id' AND receiver = '$user->id'");
  echo '<meta http-equiv="refresh" content="0">';
  //header('Location: ../friends/index.php?remove=true');
}

echo '
<div class="col-md-10" style="margin: 0px auto;float: none;">
  <div class="card">
    <div class="card-body">
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div style="margin-bottom: 15px;">
            <div class="card">
              <div class="card-body">
              
                <center>
';
if($areRequests > 0) {
    while($friend = mysqli_fetch_object($fetchRequests)) {
        $gFriend = $conn->query("SELECT * FROM users WHERE id = '$friend->sender'");
        $friendInfo = mysqli_fetch_object($gFriend);
  
        echo '
            <div style="width:200px;display:inline-block;">
            <center><img src="../images/'.$friendInfo->id.'.png" width="120px"></center>
            <br>
            <center>'.$friendInfo->username.'</center>
            <form action="#" method="POST">
              <center>  
                <input type="hidden" value="'.$friend->id.'" name="fid">
                <button class="btn btn-success" name="add" type="submit">Accept</button>
                </center>
            </form>
            
            
            <form action="#" method="POST">
              <center>
                <input type="hidden" value="'.$friend->id.'" name="fid">
                <button class="btn btn-danger" name="remove" type="submit">Decline</button>
              </center>
            </form>
            </div>
        ';
    }
}else{
  echo'<center>You have no friend requests.</center>';
}
echo '
                </center>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">0 Pending</div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <div class="col-md-3" style="margin-bottom: 15px;">
            <div class="card">
              <div class="card-body">
                <center>
                  <a href="../profile.php?id=18">
                    <img style="width:150;height:150px;" src="../images/18.png">
                    <div style="height: 10px;"></div>
                    OfficialNateYT
                  </a>
                </center>
                <form method="post" action=""><input class="btn btn-success" style="width: 130px;" name="accept" type="submit" value="Accept"><br><br><input class="btn btn-danger" type="submit" name="decline" style="width: 130px;" value="Decline"></form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
';
?>
</div>
</div>

</body>
</html>