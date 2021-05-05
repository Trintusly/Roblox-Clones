<?php
include '../../func/connect.php';
include '../../func/navbar.php';

?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Create | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="../storage/tetrimus.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body>
    <style>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #007bff;
}
</style>
<?php // this code is useless - include '../func/navbar.php';
      ?>
      
  <center>
    <a href='https://www.tetrimus.xyz/store/createshirt.php' class="btn btn-primary">Shirt</a>
     <hr>
    <a href='https://www.tetrimus.xyz/store/createpants.php' class="btn btn-primary">Pants</a>
     <hr>
    <a href='https://www.tetrimus.xyz/store/createdecal.php' class="btn btn-primary">Decals</a>
     <hr>
    <a href='https://www.tetrimus.xyz/store/createsound.php' class="btn btn-primary">Sounds</a>
     <hr>
    <a href='https://www.tetrimus.xyz/store/createad.php' class="btn btn-primary">Advertisements</a>
     <hr>
    <a href='https://www.tetrimus.xyz/store/createrealm.php' class="btn btn-primary">Realms</a>
  <hr>
  </center>
  <?php
  if($user->power >1){
      echo"
  

    <a href='https://www.tetrimus.xyz/store/createhat.php' class='btn btn-primary'>Create Hat (Staff)</a>
    <hr>
    <a href='https://www.tetrimus.xyz/store/createface.php' class='btn btn-primary'>Create Face (Staff)</a>
    <a href='https://www.tetrimus.xyz/store/creategear.php' class='btn btn-primary'>Create Gear (Staff)</a>";
    }
    ?>
    
      

 
      </div>
     
        
