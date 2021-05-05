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
/*
<div class="container">
  <div class="row">
      <div class="col-md-10" style="margin: 0 auto;float: none;">
<div class="card">
    <div class="card-body">

<div class="row">
  <div class="col-md-3">
  <center>
      <a href="../profile.php?id-1">
    <img style="width:150;heigh:150;" class="img-responsive" src="http://tetrimus.xyz/images/1.png"></a>
<br>Creator: <a href="../profile.php?id-1">South </a><br>Playing: 1
<br>
<form method="POST" action="">
	<button class="btn btn-success" onclick="UnfinishedCode()" name="leave" type="submit">Join</button>


<script>
function UnfinishedCode() {
    alert("The Tetrimus Client could not be found.( ͡° ͜ʖ ͡°) ");
}
</script>
</form>
</div>
<h2>
<div class="col-md-5" >Client Testing</h2><div style="height: 50px;"></div>Testing Purposes.</div>
    </div>
</div>


</center></div></div></div></div>
<div class="container">
  <div class="row">
  <div class="col-md-10" style="margin: 0px auto;float: none;">
  <div class="card">
  <div class="card-body">
 <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Information</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Stats</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Servers</a>
  </li>
</ul>
</div>
</div>
<div style="height: 15px;"></div>
</div>
<div class="col-md-10" style="margin: 0px auto;float: none;">
  <div class="card">
  <div class="card-body">
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><div class="card">
  <div class="card-header">
    Information
  </div>
  <div class="card-body">
      <strong>
    <h5 class="card-title">Client Testing:</h5></strong>
    <p class="card-text">9/23/18 - Pre-Alpha Testing</p>
    <hr>
    <p class="card-text">1 Like, 0 Dislikes, 0 Pins, 0 Reports.</p>
 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Report</button>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Realm Reporting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Realm Name:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Reason:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
          <div class="input-group mb-3">
  <div class="input-group-prepend">
    <label class="input-group-text" for="inputGroupSelect01">What is the game violating?</label>
  </div>
  <select class="custom-select" id="inputGroupSelect01">
    <option selected>Choose...</option>
    <option value="1">Illegal Content</option>
    <option value="2">Harassment</option>
    <option value="3">Personal Information</option>
    <option value="4">Other</option>
  </select>
</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Report</button>
      </div>
    </div>
  </div>
</div>
  </div>
</div></div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><div class="col-md-10" style="margin: 0px auto;float: none;">
  <div class="card">
  <div class="card-body">
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Work in progress</div>
  
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">2 Active Servers Running<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Join
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
<div class="card-title">Tetrimus</div>
      <a href="../profile.php?id-2">
    <img style="width:150;heigh:150;" class="img-responsive" src="http://tetrimus.xyz/images/2.png"></a> </div>
</div><button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Join
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
<div class="card-title">South</div>
      <a href="../profile.php?id-1">
    <img style="width:150;heigh:150;" class="img-responsive" src="http://tetrimus.xyz/images/1.png"></a> </div>
</div></div></div>

</div>
  </div>
</div>
</div>
</div>
</div>

</div>
</div>

</div>
</div></div>
*/


?>
<?php
?>
<div class="container">
<div class="card">
<div class="card-header">
<font>Tetrimus Place</font>
</div>
<div class="card-body">
<div class="row">
<div class="col-lg-7 my-2 text-center">
<img src="https://www.tetrimus.xyz/realms/1.png" alt="" style="width: 100%;max-width: 483px;max-height: 262px;margin-left: -7rem;">
</div>
<div style="margin-left: -3rem;" class="col-lg-5 my-2">
<h3>South's Untitled Realm</h3>
<h6>Click "Edit in Workshop" to edit your first realm!</h6>
Created by: <a href="https://www.tetrimus.xyz/profile.php?id=1">South</a>

<br><input style="margin-top: 4rem;" class="btn btn-primary  btn-block btn-lg" type="button" value="Play" onclick="playRealmByID("1,souths-untitled-realm")>
<?php 
if ($user->username == "South"){
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
<div style="font-size:20px;">November 6th, 2018</div>
<div style="color:#999;font-size:14px;">Created</div>
</div>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;">November 6th, 2018</div>
<div style="color:#999;font-size:14px;">Last Updated</div>
</div>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;">1</div>
<div style="color:#999;font-size:14px;">Visits</div>
</div>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;">1</div>
<div style="color:#999;font-size:14px;">Playing</div>
</div>
</div>
</div>
</div></div>