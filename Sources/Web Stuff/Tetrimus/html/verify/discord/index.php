<?php
include('../../func/connect.php');
if(!$user) {
  echo 'Your not logged in.';
  die();
}
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Verify | Tetrimus</title>
  <link rel="shortcut icon" type="image/png" href="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png"/>
  <meta name="description" content="Another Test">
<meta name="keywords" content="Tetrimus,"South">
<meta name="author" content="Tetrimus">
<meta property="og:image" content="https://images-ext-2.discordapp.net/external/Uq7v1iRUHGV2QH5jeMrMavjSp1uSHGZfQ233tAsTCE8/https/cdn.discordapp.com/attachments/488139976169488395/493222578605916170/1.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../style.css?=875918">

<script>
    window.onload = function() {
    var image = document.getElementById("Avatar");

    function updateImage() {
        image.src = image.src.split("?")[0] + "?" + new Date().getTime();
    }

    setInterval(updateImage, 5000);
}
</script>
</head>
<head>
  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  
<title>Verify | Tetrimus</title>
  
<meta name="description" content="Tetrimus is a new up and coming sandbox game. Join today for free!">
  
<meta name="author" content="Tetrimus">
  <link rel="stylesheet" type="text/css" href="../css/darkthem">
  
<link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png">

<link rel="shortcut icon" type="image/png" href="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png"/>
  
 <link rel="icon" href="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png">
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-9372911432095214",
    enable_page_level_ads: true
  });
</script>
</head>
<?php
include('../../func/navbar.php');
?>
<center>
<div class="card" style="width: 25rem;">
  <img class="card-img-top" src="https://vignette.wikia.nocookie.net/ark-survival-evolved/images/0/01/Discord_Icon.png/revision/latest?cb=20170602171324&path-prefix=ru" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title">Verify</h5>
    <strong>
    <p class="card-text">After verified, you will gain access to all of the public channels.</p>
    <p>DM TetrimusVerification#9502 on Discord ".verify codenamehere"</p>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Discord Verification Code
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    <?php
    if($user->discordVerification == 0) {
   $part1 = md5($user->username);
   $part2 = md5($user->password);
   $part3 = md5($user->email);
   $combine = ''.$part1.''.$part2.''.$part3.'';
   $complete = substr(md5($combine),12);
   echo ''.$complete.'';
 }else{
    echo 'Already Verified';
 }
    ?>
</div>
  </div>
</div>

