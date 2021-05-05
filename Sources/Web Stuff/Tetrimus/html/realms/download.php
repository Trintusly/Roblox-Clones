<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Download | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<?php
include('../func/connect.php');
include('../func/navbar.php');
?>
<body>
<center>
<h2>You can download the client</h2>
</center>
<div class="container">
  <div class="content">
    <center>
    <h3>Client Download</h3>
    </center>
    <center>
    <div class="row">
      
<div class="card" style="width:300px;length:200px;margin-center">
  <img class="card-img-top" src="https://cdn.icon-icons.com/icons2/1488/PNG/512/5314-windows_102509.png" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Windows<h3>
      <p class="card-text">Releasing Soon!</p>
    <a href="https://cdn.discordapp.com/attachments/486327981946568706/489952472270503947/nestles.png" class="btn btn-primary" download>64 Bit</a>
    <br>
    <br>
    <a href="https://cdn.discordapp.com/attachments/486327981946568706/489952472270503947/nestles.png" class="btn btn-primary" download>32 Bit</a>
    <br>
    <br>
    <?php
if($user->power >1){
    echo'<a href="https://www.tetrimus.xyz/download/client/setup/TetrimusSetup.exe" class="btn btn-primary" download>64 Bit Test Client (Admin)</a>';
    }
    ?>
      
  </div>
  </div>
     
    <div class="card" style="width:300px;length:200px">
  <img class="card-img-top" src="http://icons.iconarchive.com/icons/iconsmind/outline/512/iOS-Apple-icon.png" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Mac<h3>
      <p class="card-text">Coming Soon</p>
      <button type="button" class="btn btn-primary" disabled>Download</button>
      <br>
      <?php
if($user->power >1){
    echo'<br>
    <a href="https://www.tetrimus.xyz/download/client/setup/MacOS/TetrimusInstaller.dmg" class="btn btn-primary" download>Mac Test Client (Admin)</a>';
    }
    ?>
      
  </div>
  </div>
     <div class="card" style="width:300px;length:200px">
  <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/Icons8_flat_linux.svg/1024px-Icons8_flat_linux.svg.png" alt="Card image">
  <div class="card-body">
    <h3 class="card-title">Linux<h3>
      <p class="card-text">Coming Soon</p>
      <button type="button" class="btn btn-primary" disabled>Coming Soon</button>
      
  </div>
  </div>
</div>
       </center>
    </body>