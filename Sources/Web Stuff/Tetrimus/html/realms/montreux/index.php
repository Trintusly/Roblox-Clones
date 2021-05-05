<?php
include ('../../func/connect.php');
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Hungary | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Soon™">
<meta name="keywords" content="Tetrimus, Hungary">
<meta name="author" content="Tetrimus">
<meta property="og:image" content="https://44h0y32hrrk21zhfs2i85gq1-wpengine.netdna-ssl.com/wp-content/uploads/2018/02/Hungary-banner.jpg">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../style.css?=<?php echo rand(10000,1000000) ?>">
<link rel="stylesheet" href="../../assets/css/realmPlace.css">
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
<img src="https://44h0y32hrrk21zhfs2i85gq1-wpengine.netdna-ssl.com/wp-content/uploads/2018/02/Hungary-banner.jpg" alt="" style="width: 100%;max-width: 483px;max-height: 262px;margin-left: -7rem;">
</div>
<div style="margin-left: -3rem;" class="col-lg-5 my-2">
<h3>Hungary</h3>
<h6>Soon™</h6>
Created by: <a href="https://www.tetrimus.xyz/profile.php?id=410">Bobby-John</a>

<br><div id="playRealm">
<input style="margin-top: 4rem;" class="btn btn-primary  btn-block btn-lg" type="button" value="Play" onclick="playRealmByID("1,souths-untitled-realm")></div>
<?php 
if ($user->username == "Bobby-John"){
    echo'<div id="playRealm"><input style="margin-top: 1rem;" class="btn btn-secondary  btn-block btn-lg" type="button" value="Edit in Workshop" onclick="editRealmByName("1,souths-untitled-realm")></div>';
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
<div style="font-size:20px;">December 22nd, 2018</div>
<div style="color:#999;font-size:14px;">Created</div>
</div>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;">December 22nd, 2018</div>
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