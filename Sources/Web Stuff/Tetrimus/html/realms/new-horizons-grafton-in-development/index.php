<?php
include ('../../func/connect.php');
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Client Testing | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="APS is a game where you can become a pedophile in the city of Amelia, Erindale. You can do anything you want, but make sure you don't get raped!">
<meta name="keywords" content="Tetrimus, Amelia Pedophile Simulator">
<meta name="author" content="Tetrimus">
<meta property="og:image" content="https://opuszine.us/_assets/entries/_mediumCropped/salon-pedophile.jpg">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<?php
include('../../func/navbar.php');

?> 
<?php
?>
<div class="container">
<div class="card">
<div class="card-header">
<font>Private Realm</font>
</div>
<div class="card-body">
<div class="row">
<div class="col-lg-7 my-2 text-center">
<img src="https://www.tetrimus.xyz/storage/club_thumbnails/New_Horizons.png" alt="" style="width: 100%;max-width: 483px;max-height: 262px;margin-left: -7rem;">
</div>
<div style="margin-left: -3rem;" class="col-lg-5 my-2">
<h3>New Horizons: Grafton [In Development]</h3>
<h6>An upcoming road game series here on Tetrimus. Join our Club! </h6>
Created by: <a href="https://www.tetrimus.xyz/profile.php?id=21">Plainoldbread</a>

<br><input style="margin-top: 4rem;" class="btn btn-primary  btn-block btn-lg" type="button" value="Play" onclick="playRealmByID("1,souths-untitled-realm")>
<?php 
if ($user->username == "Plainoldbread"){
    echo'<input style="margin-top: 1rem;" class="btn btn-secondary  btn-block btn-lg" type="button" value="Edit in Workshop" onclick="editRealmByName("1,souths-untitled-realm")>';
}
?>
</div>
</div>
<hr>
</div>
</div>
<br>
<div class="card">
<div class="card-body">
<div style="text-align: center;">
<div class="row" style="margin-bottom:0;">
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;">November 7th, 2018</div>
<div style="color:#999;font-size:14px;">Created</div>
</div>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;">November 7th, 2018</div>
<div style="color:#999;font-size:14px;">Last Updated</div>
</div>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;">0</div>
<div style="color:#999;font-size:14px;">Visits</div>
</div>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;">0</div>
<div style="color:#999;font-size:14px;">Playing</div>
</div>
</div>
</div>
</div></div>