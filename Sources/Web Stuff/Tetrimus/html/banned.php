
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Banned | Tetrimus</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<meta property="og:image" content="http://assets1.ignimgs.com/2018/04/27/infinitywarthanos-blogroll-1524860342885_1280w.jpg"/>  
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<link rel="icon" href="http://assets1.ignimgs.com/2018/04/27/infinitywarthanos-blogroll-1524860342885_1280w.jpg">
<link rel="shortcut icon" href="http://assets1.ignimgs.com/2018/04/27/infinitywarthanos-blogroll-1524860342885_1280w.jpg">

<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-9372911432095214",
    enable_page_level_ads: true
  });
</script>
</head>
<head>
  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  
<title>Tetrimus</title>
  
<meta name="description" content="Tetrimus is a new up and coming sandbox game. Join today for free!">
  
<meta name="author" content="Tetrimus">
  <link rel="stylesheet" type="text/css" href="../css/darkthem">
  
<link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png">

<link rel="shortcut icon" type="image/png" href="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png"/>

  
 <link rel="icon" href="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png">
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  
</script>
</head>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include ('func/connect.php');
include ('func/avatarconect,php');

$time = time();

if($user->banned != 0) {
    header("Location: ../index.php");
}

$findBan = $conn->query("SELECT * FROM `bans` WHERE `banned_user`='$user->id'");
$banInfo = mysqli_fetch_object($findBan); 
if($time > $banInfo->ban_time) {
$conn->query("UPDATE users SET banned='0' WHERE id='$user->id'");
echo"You are now unbanned. Please refresh your page";
}
include("func/navbar.php");
?>

<title>BANNED!</title>
<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>

<article>
    <h1>UH OH! You have been banned <?php echo"$user->username."?>!</h1>
    <div>
        <p>reason: <?php echo".$banInfo->reason."?></p>
        <p>You will been unbanned on <?php echo".date('m/d/y', $banInfo->ban_time)."?>, thanks for playing! &mdash; <a href='/logout.php?logout'>logout</a></p>
    </div>
</article>
<style>@import url('https://fonts.googleapis.com/css?family=Montserrat');
body {
    background: #ededed;
    margin: 0px;
    
    padding-bottom: 194px;
    font-family: 'Montserrat', sans-serif;
}

.content{
    background: #fff;
    padding: 40px;
    margin-top: 60px;
    box-shadow: 0 1px 2px #ccc;
}
.outline{
    text-shadow: #000 0px 0px 1px,   #000 0px 0px 1px,   #000 0px 0px 1px,
             #000 0px 0px 1px,   #000 0px 0px 1px,   #000 0px 0px 1px;
}
.invisible-box {
    width: 400px;
    margin: 0 auto;
    margin-top: 40px;
}

h3 {
    font-size: 28px;
    text-align: center;
    padding-bottom: 20px;
    font-weight: 400;
}

a {
    text-decoration: none;
}

a:hover, a:focus {
    text-decoration: none;
}

.tetrimus {
    position: relative;
    background-color: #343a40;
    background: url(placeholder.jpg) no-repeat center center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    padding-top: 14rem;
    padding-bottom: 14rem;
}
.tetrimus .overlay {
    position: absolute;
    background-color: #212529;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    opacity: .3;
}

.footer{
    padding: 1rem;
    background-color: #1fc111;
    bottom: 0;
    left: 0;
    margin: 0 auto;
    width: 100%;
    padding-top: 65px;
    position: absolute;
    max-width: 650px;
    right: 0;
}</style>

?>