<?php include '../../../func/connect.php';
//Beginning of South's Anti-Cheat Code
if($user->membership =="none"){
    header ("Location: https://www.tetrimus.xyz/upgrade");
}
if($user->membership =="bronze"){
    header ("Location: https://www.tetrimus.xyz/upgrade");
}
if($user->membership =="gold"){
    header ("Location: https://www.tetrimus.xyz/upgrade");
}
if($user->membership =="platinum"){
    header ("Location: https://www.tetrimus.xyz/upgrade");
}
//End of South's Anti-Cheat Code




?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Upgrade | Tetrimus</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../../style.css?=13284">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-9372911432095214",
    enable_page_level_ads: true
  });
</script>
</head>
<?php 
include '../../../func/navbar.php';
?>
<html>
<center>

<?php
echo "<h2>Please wait while our servers upgrade your account, $user->username.</h2></center>";
?>
<br>
<br>
<center>
<i style="font-size: 100px;" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
          <p>Upgrading...</p>
          </center>
          <?php
      
          $upgradeUser = 'UPDATE users SET membership="Platinum" WHERE id="$user->id"';
          $upgradeUser

        ?>