<?php
include '../../func/connect.php';
if ($loggedIn) {
    header("Location: ../../login");
}
?>



<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot Password | Tetrimus</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://tetrimus.xyz/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../style.css">
<script src="../../assets/js/nextStep.js"></script>


<link rel="icon" type="image/png" href="https://tetrimus.xyz/logo.png"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<style>
html, body {
    max-width: 100%;
    overflow-x: hidden;
    overflow-x: hidden;
}
</style>
</head>
<?php
include '../../func/navbar.php';
?>
<center><div class="alert alert-primary" role="alert">
  Password Reset is undergoing maintenance. Check the status at: <a href="https://www.tetrimus.xyz/discord">Our Discord</a>
</div></center>
<div class="container">
<form>
  <div class="form-group">
    <label for="exampleFormControlInput1">Account Email</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter Username...">
  </div>
  <button type="button" class="btn btn-primary" onclick="update_url('/please-wait');" id="nextStep">Next</button>
  </div>

  <?php
$to      = 'document.getElementById("searchTxt").value;';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?> 

  