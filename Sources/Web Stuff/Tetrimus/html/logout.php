<?php
 include('func/connect.php');
 unset($_SESSION['TetrimusSess']);
 
 if(session_destroy())
 {
  header("Location: ../");
 }
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Logout | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
<script src="../chat/jquery.min.js"></script>
    <script src="../chat/main.js"></script>
    <link rel="stylesheet" href="../chat/css/main.css" />

</head>
  <body>
  <div class="container">
  <div class="jumbotron">
  <center>
    <strong>
<i class="fa-fa-frown">
  <h1>It appears your attempt to logout was not successful.</h1>
</i></strong><i class="fa-fa-frown">
<p>If you cannot successfully logout then, go to <a href="https://www.tetrimus.xyz/home">Tetrimus</a> and click the green/grey lock beside the URL. Click it, then www.tetrimus.xyz > cookies > TetrimusSess, remove TetrimusSess then refresh the page. </p>
</h2></i></center><i class="fa-fa-frown">
</i></div><i class="fa-fa-frown">
<div id="loader">
    <div style="height: 50px;"></div>
        <center>
      <i style="font-size: 100px;" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
          <p>Retrying...</p>
      <span class="sr-only">Updating...</span>
    </center>
</div>
</i></div></body>
