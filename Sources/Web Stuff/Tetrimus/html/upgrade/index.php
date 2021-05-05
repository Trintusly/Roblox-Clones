<?php
include '../func/connect.php';

?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Upgrade | Tetrimus</title>
<script type="text/javascript" src="https://ajax.cloudflare.com/cdn-cgi/scripts/b7ef205d/cloudflare-static/rocket.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script data-rocketsrc="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous" type="text/rocketscript"></script>
<script data-rocketsrc="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous" type="text/rocketscript"></script>
<script data-rocketsrc="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous" type="text/rocketscript"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<?php
include '../func/navbar.php';
?>
<div class="container" style="margin: 0 auto; text-align: center;">
	<div class="row">
  <div class="col-sm-6">
	<h4>Upgrade</h4>
</div>

  <div class="col-sm-6">
	<button class="btn btn-success">Redeem</button>
	<button class="btn btn-success">Buy tokens</button>
</div>
</div>
<div class="content">
<?php
if($user->power >=2){
  echo"<button class='btn btn-danger' id='disableUpgrades' name='disableUpgrades'>Disable Upgrades and Purchases</button><br><br>";
}
?>
<div class="row">

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 style="font-weight: bold;" class="card-title">None</h5>
        <p class="card-text">No membership. $0.00.</p>
        <p class="card-text">1 token, daily.</p>
        <a href="#" class="btn btn-primary disabled">Purchase</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 style="font-weight: bold;color: #a5682c;" class="card-title">Bronze</h5>
        <p class="card-text">Bronze membership. $2.99/mo.</p>
        <p class="card-text">T2.</p>
        <a href="https://www.tetrimus.xyz/upgrade/bronze" class="btn btn-primary">Purchase</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 style="font-weight: bold; color: #ddb630;" class="card-title">Gold</h5>
        <p class="card-text">Gold membership. $5.99/mo.</p>
        <p class="card-text">T3.</p>
        <a href="https://www.tetrimus.xyz/upgrade/gold" class="btn btn-primary">Purchase</a>
      </div>
    </div>
  </div>
<div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 style="font-weight: bold; color: #30a0dd;" class="card-title">Diamond</h5>
        <p class="card-text">Diamond Membership. $9.99/mo.</p>
        <p class="card-text">T4.</p>
        <a href="https://www.tetrimus.xyz/upgrade/diamond" class="btn btn-primary">Purchase</a>
      </div>
    </div>
  </div>
  </div>
  <br>
  <br>
  <center>
  <?php
  if ($user->membership == "none"){
    echo'<a href="https://www.tetrimus.xyz/upgrade/upgrade-tier/none" class="btn btn-outline-success disabled">Upgrade</a>
    <br><p>You must have a membership before you can upgrade!</p>';
  }
  ?>
   <?php
  if ($user->membership == "bronze"){
    echo'<a href="https://www.tetrimus.xyz/upgrade/upgrade-tier/bronze" class="btn btn-outline-success">Upgrade</a>
    <br><p>You will upgrade from <strong>Bronze</strong> to <strong>Gold</strong></p>';
  }
  ?>
   <?php
  if ($user->membership == "gold"){
    echo'<a href="https://www.tetrimus.xyz/upgrade/upgrade-tier/gold" class="btn btn-outline-success">Upgrade</a>
    <br><p>You will upgrade from <strong>Gold</strong> to <strong>Diamond</strong></p>';
  }
  ?>
   <?php
  if ($user->membership == "Diamond"){
    echo'<a href="https://www.tetrimus.xyz/upgrade/upgrade-tier/diamond" class="btn btn-outline-success">Upgrade</a>
    <br><p>Awesome! You have purchased the highest tier, if you upgrade then you will have the tier that only Diamond Membership users can upgrade to. You will upgrade from <strong>Diamond</strong> to <strong>Platinum</strong></p>';
  }
  ?>
   <?php
  if ($user->membership == "Platinum"){
    echo'<a href="https://www.tetrimus.xyz/upgrade/upgrade-tier/platinum" class="btn btn-outline-success disabled">Upgrade</a>
    <br><p>You have reached the highest tier! Thank You for donating and supporting Tetrimus!</p>';
  }
  ?>
  </center>
</div>
</div>
</div>
