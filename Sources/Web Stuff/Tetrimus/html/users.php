<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Users | Tetrimus</title>
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
<?php
include('func/connect.php');
include('func/filter.php');
include('func/navbar.php');
if($loggedIn){
}else{
	header("Location: ../");
}
?>
<div class="container">
<div class="row">
<div class="col-md-10" style="margin: 0 auto;float: none;">
<div class="card">
 <div class="card-body">
      <form action='../search.php' method='GET' role="search">

  <div class="input-group">
        <input type="text" class="form-control" name="query" placeholder="Search">
  <div class="input-group-append">
    <input type="submit" class="btn btn-outline-success" value="Find">
  </div>
</div>
</form>
<?php
$fetch_users = $conn->query("SELECT * FROM users");
$total_users = mysqli_num_rows($fetch_users);

$now = time();

$fetch_online_users = $conn->query("SELECT * FROM users WHERE $now < expireTime");
$online_users = mysqli_num_rows($fetch_online_users);
echo "<center>";
?>
<p style="margin-top:10px;">There are currently <?php echo $total_users; ?> users registered and <?php echo $online_users; ?> users online.</p>

<?php
echo "</center>";
echo "<center>";
echo "<h5>Random users: </h5>";

$TotalUsers = $conn->query("SELECT * FROM `users`");
$TotalUsers = mysqli_num_rows($TotalUsers);

$user1 = rand(4,$TotalUsers);
$user2 = rand(8,$TotalUsers);
$user3 = rand(2,$TotalUsers);

$FirstUser = $conn->query("SELECT * FROM `users` WHERE `id`='$user1'");
$FirstUser = mysqli_fetch_object($FirstUser);

$SecondUser = $conn->query("SELECT * FROM `users` WHERE `id`='$user2'");
$SecondUser = mysqli_fetch_object($SecondUser);

$ThirdUser = $conn->query("SELECT * FROM `users` WHERE `id`='$user3'");
$ThirdUser = mysqli_fetch_object($ThirdUser);

$firstUsername = filter($FirstUser->username);
$secondUsername = filter($SecondUser->username);
$thirdUsername = filter($ThirdUser->username);
?>

<div style='display: inline-block;'><img style='width:200px;height:200px;' src='../images/<?php echo "".$FirstUser->id.""; ?>.png' onerror="this.src='images/default.png'" /><br><center><?php echo "".$firstUsername.""; ?></center></div>
<div style='display: inline-block;'><img style='width:200px;height:200px;' src='../images/<?php echo "".$SecondUser->id.""; ?>.png' onerror="this.src='images/default.png'" /><br><center><?php echo "".$secondUsername.""; ?></center></div>
<div style='display: inline-block;'><img style='width:200px;height:200px;' src='../images/<?php echo "".$ThirdUser->id.""; ?>.png' onerror="this.src='images/default.png'" /><br><center><?php echo "".$thirdUsername.""; ?></center></div>

<?php
echo "</center>";
?>
   </div>
 </div> 
</div>
</div>
</div>
</div>
</div>
</div>
</body>