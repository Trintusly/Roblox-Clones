<head>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-4458325242752954",
    enable_page_level_ads: true
  });
</script>
<link rel="shortcut icon" type="image/png" href="../assets/images/tetrimus.png"/>
<!-- hi <link rel="icon" href="../assets/images/tetrimus.png">-->
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background: #fff!important;">
<a class="navbar-brand" href="../home">Tetrimus</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav mr-auto">
<li class="nav-item">
<a class="nav-link" href="/realms">Realms</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/store">Store</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/users.php">Users</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/clubs/">Clubs</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/forum">Forum</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/upgrade">Upgrade</a>
</li>
</ul>
<ul class="nav navbar-nav ml-auto">
  <?php if($loggedIn){ ?>
    <li class="nav-item">
<a class="nav-link" data-placement="bottom" data-toggle="tooltip" title="Friends" href="../friends/"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
</li>
<li class="nav-item">
<a class="nav-link" data-placement="bottom" data-toggle="tooltip" title="Messages" href="../messages/"><i class="fa fa-envelope" aria-hidden="true"></i></a>
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
  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <?php echo "$username"; ?>
        </a>
<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="margin-left: -70px;">
  <?php echo '<a class="dropdown-item" href="/profile.php?id='.$user->id.'">';echo "Profile";echo '</a>'; ?>
<a class="dropdown-item" href="/character.php">Character</a>
<a class="dropdown-item" href="/settings.php">Settings</a>
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
        echo "<div style='color: #fff;margin-bottom: 0px !important;background: #1fc111;border-radius: 0px;' class='alert text-center'>" . $banner["text"]. "</div>";
    }
}
}
?>
<br>
