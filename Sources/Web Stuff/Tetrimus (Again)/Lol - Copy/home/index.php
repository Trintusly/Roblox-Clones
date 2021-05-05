<?php
include '../func/connect.php';
if($loggedIn){
}else{
    header("Location: ../");
}
$RefreshRate = rand(0,1000);

if(isset($_POST['post'])){
  $status = htmlentities($_POST['status']);

  $conn->query("UPDATE users SET status='$status' WHERE id='$user->id'");
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
  <?php
$fNotification = $conn->query("SELECT * FROM notifications ORDER BY id DESC LIMIT 3"); //ORDER BY id DESC LIMIT 3
//$notification = mysqli_fetch_object($fNotification);
?>
  <div style="height: 15px;"></div>
 
    <div class="card">
    <div class="card-body">
      <font style="font-size: 18px;">Notifications</font><br>
	  <?php 
	  if ($fNotification->num_rows > 0) {
    while($row = $fNotification->fetch_assoc()) {

echo "<b>".$row['post']."</b> by ".$row['poster']." on <i>".$row['date']." <i class='fa fa-clock-o'></i></i><br>";
	}
	  }
  ?>
     </div>
  </div>
  <div style="height: 15px;"></div>
  

</div>
</div>

</div>
<?php include '../func/footer.php'; ?>
</body>
</html>