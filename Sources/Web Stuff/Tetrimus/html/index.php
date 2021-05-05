<?php






include 'func/connect.php';

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
  <meta name="description" content="Tetrimus is an upcoming sandbox game. Join Today!">
<meta name="keywords" content="Tetrimus,Landing">
<meta name="author" content="Tetrimus">
<meta property="og:image" content="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      <meta name="google-site-verification" content="-mRGJHzuzBk5acIaII2SRzZ_pHuCHEJlt7I4VBPRCu4" />
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
<style>
body {
        background-image: url("https://web.archive.org/web/20180707155940im_/https://tetrimus.com/background.png");
} 
 
</style>

  
<div class="container">
<div class="col-md-8" style="margin: 0 auto;float:none;">
<div class="card bg-light">
  <div class="card-header">Create, Build, Play</div>
    <div class="card-body">
    <h5 class="card-title">What is Tetrimus?</h5>
    <p class="card-text text-muted">Tetrimus is an online up-and-coming 3D multiplayer sandbox game!</p>
     <h5 class="card-title">What can you do in Tetrimus?</h5>
    <p class="card-text text-muted">There are many things you can do on Tetrimus including making friends, posting on the forums, customizing your own avatar, and much more!</p>
     <h5 class="card-title">What are realms?</h5>
    <p class="card-text text-muted">The realms are not done at the moment but are projected to be out in a few months or so!</p>
    <div style="height: 10px;"></div>
    <center><a href="https://www.tetrimus.xyz/register" class="btn btn-primary">Get started</a><a href="https://www.tetrimus.xyz/login" style="margin-left: 10px;" class="btn btn-success">Sign In</a></center>
    </div>
</div>
</div>
</div>
</div>
</body>
</html>