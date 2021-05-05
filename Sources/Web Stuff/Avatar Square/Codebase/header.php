<?php include('Site/init.php'); error_reporting(0); ?>
 <title>AvatarSquare | Home</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="http://materializecss.com/dist/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="http://materializecss.com/templates/parallax-template/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="http://web.archive.org/web/20170112100057cs_/https://www.bloxcity.com/assets/css/default.css" type="text/css" rel="stylesheet" media="screen,projection">

      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>           
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script> 

<script src='https://www.google.com/recaptcha/api.js'></script>

<style>
body {
    background-color: #eceff1;
}
</style>

<script>
$('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrainWidth: true, // Does not change width of dropdown to that of the activator
      hover: false, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: true, // Displays dropdown below the button
      alignment: 'right', // Displays dropdown with edge aligned to the left of button
      stopPropagation: false // Stops event propagation
    }
  );
</script>

<nav <? if ($user){ ?> style="padding-left: 300px" <? } ?> class="main-nav">
<div class="nav-wrapper light-blue darken-2">
<a href="/" class="brand-logo">
<div style="margin-top:10px;margin-left:10px;height:40px;width:40px;background:white;" class="circle">
<img src="https://i.imgur.com/UBiGSWl.png" style="margin-top:-1px;height:42px;width:42px;padding: 8px 8px;">
</div>
</a>
<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
<ul class="left hide-on-med-and-down" style="margin-left:65px;">
<li><a href="/">Home</a></li>
<li><a href="/Games">Games</a></li>
<li><a href="/Market">Market</a></li>
<li><a href="https://discord.gg/GJ7xf3J">Chats</a></li>
<li><a href="/Forum">Forum</a></li>
<li><a href="/Upgrade">Upgrade</a></li>
<li class="no-hover"><a class="dropdown-button2" href="#" data-activates="more-links"><i class="material-icons" style="font-size:16px;">arrow_drop_down</i></a><ul id="more-links" class="dropdown-content">
<li><a href="/Players">Users</a></li>
<li><a href="/Groups">Groups</a></li>
</ul></li>
</ul>

<ul class="right hide-on-med-and-down">
<script>
						$(document).ready(function(){
							$('.tooltipped').tooltip({delay: 50});
							$(".dropdown-button2").dropdown({belowOrigin: true});
						});
					</script>
<? if (!$user){ ?>
<li><a href="/Login">Login</a></li>
<li><a href="/Register">Register</a></li><? } ?></ul>
</div>
</nav>

<div style="width:1100px;" class="container">

<div style="padding-top:35px;"></div>
<? if ($user){?><div style="padding-left: 315px; width:1285px;" class="container"><? } else {?>
<div style="width:1300px;" class="container"><? } ?>

<? if ($user){?><ul id="nav-mobile" class="side-nav fixed" style="width:175px transform: translateX(0%);">

<li><div class="user-view">
      <div class="background">
<img src="http://i.imgur.com/rw1JMpi.png">
            </div>
            <a href="#"><img class="circle" src="http://i.imgur.com/hAdq5Gu.png"></a>
            <a href="/Profile/?username=<? echo $myu->username ?>"><span class="white-text name"><? echo $myu->username ?></span></a>
            <a href="/Upgrades/"><span class="white-text email"><? echo $myu->emeralds ?> Cash</span></a>
          </div></li>
          <li><a href="/"><i class="material-icons">home</i>Home</a></li>
          <li><a href="/Players"><i class="material-icons">search</i>Players</a></li>
<li><a href="/Upgrade"><i class="material-icons">shopping_basket</i>Upgrades</a></li>
          <li><div class="divider"></div></li>
          <li><a href="/Personal/Messages"><i class="material-icons">message</i>Inbox</a></li>
          <li><a href="/Personal/Friends"><i class="material-icons">person</i>Friends</a></li>
<li><a href="/Personal/Settings"><i class="material-icons">settings</i>Settings</a></li>
<li><a href="/Customize"><i class="material-icons">add_box</i>Character</a></li>
          <li><div class="divider"></div></li>
          <li><a href="/user/logout.php"><i class="material-icons">power_settings_new</i>Logout</a></li>
          
      </ul><? } ?>
<div style="padding-top:50px;"></div>
<div class="card-panel light-blue darken-2 white-text"><center><table style="padding:0;margin:0;"><tbody><tr></tr></tbody></table>Join our discord! https://discord.gg/GJ7xf3J</center></div>