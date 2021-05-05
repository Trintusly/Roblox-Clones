<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Realms | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
<link rel="stylesheet" href="../assets/css/realmList.css">

</head>
<?php
include('../func/connect.php');
include('../func/navbar.php');
?>
<body>
<center>
<h2>You can download the client <a href="https://www.tetrimus.xyz/realms/download.php" class="btn btn-primary">Here</a>
</h2>
</center>
<div class="container">
  <div class="content">
    <h3>Check back soon!</h3>
    
<?php //<h5>Games are preparing for release</h5>?>
<hr>
    <div class="row">  
<div class="container">
  <div class="row">
      <div class="col-md-10" style="margin: 0 auto;float: none;">
        <a href="create.php" class="btn btn-outline-success">Create</a>
        <div style="height: 12px;"></div>
<div class="card">
    <div class="card-body">
        <div class="input-group">
      <input type="text" class="form-control" name="search" placeholder="Search">
  <div class="input-group-append">
    <input type="submit" class="btn btn-outline-success" value="Find" name="r">
  </div>
</div>

 <div style="height: 15px;">
   
 </div>
 <h4>Trending</h4>
        <div class="row"><div class="col-md-3">
          <div class="card" id="realmListItem">
            <a href="https://www.tetrimus.xyz/realms/client-testing">
            <img class="card-img-top" src="../realms/1.png" alt="Thumbnail">
            <div class="card-body">
          
          </a><div style="height: 2px;"></div>
          <div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
            <a href="../realms/view.php">Client Testing</a></div> <div style="height: 10px;">
          
          </div>Creator: South<div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"></div><div style="height: 2px;"></div>Playing: 1</div>
           
      <?php
if($user->power >1){
    echo'
    <a href="/deleteRealm.php?realmid=1" class="btn btn-danger">Delete</a>
    
<button onclick="UnfinishedCode()" href="TetrimusLauncher:">Launch (Beta)</button>

<script>
function UnfinishedCode() {
    alert("Looks like this is so unfinished that staff cannot even access ( ͡° ͜ʖ ͡°) ");
}
</script>
';
}
?>
</div>
</div>
<hr>

</div></div>