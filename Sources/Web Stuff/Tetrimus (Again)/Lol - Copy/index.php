<?php
include 'func/connect.php';
if($loggedIn){
  header("Location: ../home/");
}
?>
    <?php
$fetch_users = $conn->query("SELECT * FROM users");
$total_users = mysqli_num_rows($fetch_users);

$fetch_threads = $conn->query("SELECT * FROM threads");
$total_threads = mysqli_num_rows($fetch_threads);

$fetch_items = $conn->query("SELECT * FROM store");
$total_items = mysqli_num_rows($fetch_items);

$fetch_replies = $conn->query("SELECT * FROM replies");
$total_replies = mysqli_num_rows($fetch_replies);

$fetch_clubs = $conn->query("SELECT * FROM clubs");
$total_clubs = mysqli_num_rows($fetch_clubs);

$now = time();

$fetch_online_users = $conn->query("SELECT * FROM users WHERE $now < expireTime");
$online_users = mysqli_num_rows($fetch_online_users);
$round = ceil($total_users / 10) * 10;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tetrimus | Build, Play, Achieve</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/png" href="../assets/images/tetrimus.png"/>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background: #fff!important;">
<a class="navbar-brand" href="../home">Tetrimus</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mr-auto">
</ul>
<ul class="nav navbar-nav ml-auto">
  
<li class="nav-item">
<a class="nav-link btn btn-primary" style="color: #fff;" href="../login/">Login</a>
</li>
<li class="nav-item">
<a class="nav-link btn btn-success" style="color: #fff;margin-left: 10px;" href="../register/">Register</a>
</li>
</ul>
</div></nav>
<header class="tetrimus text-white text-center">
      <!-- hi <div class="overlay"></div>-->
      <div class="container">
        <div class="row">
          <div class="col-md-7">
			  <h3>Tetrimus is a new up and coming sandbox game. Join today for free!</div></h3>
			  <h5>Join over <?php echo $round ?> users playing today.<br>
			  What are you waiting for?</h5>
        </div>

      </div>
      
              <a href="/register">
        <button class="btn btn-success">Get Started Today</button>
      </a>
			<a href="/login">
        <button class="btn btn-primary">Login</button>
        </a>
    </header>

<center>
	<br>
	<h3>Tetrimus' Statistics</h3>
<h4>
<div class="container">
  <div class="row">
    <div class="col-sm">
<?php echo "<strong>$total_users</strong>"; ?> Users Registered <br><br>
<?php echo "<strong>$total_items</strong>"; ?> Items Created 
</div>
	<div class="col-sm">
<?php echo "<strong>$online_users</strong>"; ?> Users Online <br><br>
<?php echo "<strong>$total_replies</strong>"; ?> Forum Replies 
</div>
	<div class="col-sm">
<?php echo "<strong>$total_threads</strong>"; ?> Threads Created <br><br>
<?php echo "<strong>$total_clubs</strong>"; ?> Clubs Created 


	</div>
	</div>
</div>
</h4>
</center>
</body>
</html>
