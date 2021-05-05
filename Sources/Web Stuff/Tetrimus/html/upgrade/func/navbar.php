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
</head>
<nav>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="box-shadow: 0px 1px #dbdbdb;padding:0.8px 8px!important;">
  <a class="navbar-brand" href="https://www.tetrimus.xyz/" rel="nofollow" style="color: #3333ff;">
    <img src="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png?r=<?php echo rand(10,100); ?>" width="28" height="30"><span style="margin-left: 10px;">Tetrimus</span>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    
      <li class="nav-item">
        <a class="nav-link" href="https://www.tetrimus.xyz/realms/">Realms</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.tetrimus.xyz/forum/">Forum</a>
      </li>
          <li class="nav-item">
        <a class="nav-link" href="https://www.tetrimus.xyz/users.php">Users</a>
      <li class="nav-item">
        <a class="nav-link" href="https://www.tetrimus.xyz/store/">Store</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.tetrimus.xyz/clubs/">Clubs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.tetrimus.xyz/upgrade/">Upgrade</a>
      </li>
    </ul>
<ul class="nav navbar-nav ml-auto">
  <?php if($loggedIn){ ?>
    <li class="nav-item">
<a class="nav-link" data-placement="bottom" data-toggle="tooltip" title="Friends" href="https://www.tetrimus.xyz/friends/"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
</li>
<li class="nav-item">
<a class="nav-link" data-placement="bottom" data-toggle="tooltip" title="Messages" href="https://www.tetrimus.xyz/messages/"><i class="fa fa-envelope" aria-hidden="true"></i></a>
</li>
  <?php 
  echo '
<li class="nav-item">
<a class="nav-link" data-placement="bottom" data-toggle="tooltip" title="'.$user->tokens.'';if($user->id == 16) {echo 'Trucks';}else{if($user->tokens > 1){ echo " Tokens";}else{echo " Token";}}echo ' "href="/currency"><i class="fa fa-certificate" style="color: #2def51" aria-hidden="true"></i> '.$user->tokens.'</a>
</li>
<li class="nav-item" data-toggle="tooltip" title="'.$user->coins.'';if($user->id == 16) {echo 'Engines';}else{if($user->coins > 1){ echo " Coins";}else{echo " Coin";}}echo ' ""><a class="nav-link" href="/currency"><i class="fa fa-circle" style="color: #e6b13f;" aria-hidden="true"></i> '.$user->coins.'
</a>
</li>
';
  ?>
  <div style="background-size: cover;background-image: url(../images/dropdown2.png);border-radius: 50%;width:35px;height:35px;border:1px #eee solid;vertical-align: middle;"></div>


  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <?php echo "$username"; ?>
        </a>
<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="margin-left: -70px;">
  <?php echo '<a class="dropdown-item" href="https://www.tetrimus.xyz/profile.php?id='.$user->id.'">';echo "Profile";echo '</a>'; ?>
<a class="dropdown-item" href="https://www.tetrimus.xyz/character.php">Character</a>
<a class="dropdown-item" href="https://www.tetrimus.xyz/settings.php">Settings</a>
<div class="dropdown-divider"></div>
<?php
if($user->power >1){
    echo'<a class="dropdown-item" href="/admin">Admin</a>';
    echo '<div class="dropdown-divider"></div>';
}
echo '<a class="dropdown-item" href="../logout.php">Logout</a>';
?>

</div>
</li>
<?php

}else{
echo '
<li class="nav-item">
<a class="nav-link" href="../login/">Login</a>
</li>
<li class="nav-item">
<a class="nav-link" href="../register/">Register</a>
</li>
';
}
?>
</ul>
</nav>
<script>
 $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
<?php
// Banner.
$bannerquery = "SELECT * FROM banner";
$result = mysqli_query($conn, $bannerquery);

if (mysqli_num_rows($result) > 0) {
  // Output banner.
while($banner = mysqli_fetch_assoc($result)) {
    if (!empty($banner["text"])){
        echo "<div style='color: #fff;margin-bottom: 0px !important;background: #007bff;border-radius: 0px;' class='alert text-center'>" . $banner["text"]. "</div>";
    }
}
}
?>
  
<br>
  
