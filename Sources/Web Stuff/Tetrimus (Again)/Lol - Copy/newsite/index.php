<?php
include('func/connect.php');
if($loggedIn){
    header("Location: /home/");
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="style-dark.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark" style="margin-bottom: 55px;">
<a class="navbar-brand" style="color: #28CE3B;" href="#"><img width="30" height="30" class="d-inline-block align-top" src='../storage/icon.png'></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">

<ul class="nav navbar-nav ml-auto">
<li class="nav-item">
<a class="nav-link" style="color: #15fe9aff!important;" href="../sign-in/">Sign In</a>
</li>
<li class="nav-item">
<a class="nav-link" style="color: #15fe9aff!important;" href="../sign-up/">Sign Up</a>
</li>
</ul>
</div>
</nav>
<div class="container">
	<div class="row">
	<div class="col-md-10" style="margin: 0 auto;float: none;">
	<div class="card text-white bg-dark">
  	<div class="card-header">Welcome to Tetrimus!</div>
  	<div class="card-body">
    <h5 class="card-title">What is Tetrimus?</h5>
    <p class="card-text">Tetrimus is a website that you can Play, Create and achieve on. Whether it be customizing your avatar or making new friends. A fun and awesome website to enjoy yourself!</p>
     <h5 class="card-title">What can you do in Tetrimus?</h5>
    <p class="card-text">There are many things you can do on Tetrimus including making friends, posting on the forums, and soon being able to play games/realms</p>
     <h5 class="card-title">Is there game/realms?</h5>
    <p class="card-text">The games are not done at the moment but are projected to be out in 2 months or so!</p>
 	</div>
 	</div>
	</div>
	</div>
</div>
</body>
</html>