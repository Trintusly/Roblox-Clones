<? include 'connection.php'; ?>
<head>
<title>Build City</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="/css/rawsheet.css" rel="stylesheet">
<script type="text/javascript"> //<![CDATA[ 
var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
//]]>
</script>
</head>

<body>
<div class="entire-page-wrapper">
<nav style="box-shadow:none;box-shadow: 1px 2px 2px #ccc;">
<div class="nav-wrapper white">
<a href="https://www.buildcity.ml" class="brand-logo"><img src="https://storage.googleapis.com/bloxcity-file-storage/assets/images/FlatLogoFull.png" style="height:65px;padding: 15px 15px;"></a>
<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
<ul class="left hide-on-med-and-down" style="margin-left:65px;">

<li><a href="https://www.buildcity.ml/">Home</a></li>
<li><a href="https://www.buildcity.ml/UserShop">Market</a></li>
<li><a href="https://www.buildcity.ml/People">Users</a></li>
<li><a href="https://www.buildcity.ml/Account/Upgrade">Upgrade</a></li>
</ul>
<?
if ($User) {
									
								echo "<ul class='right hide-on-med-and-down'>
<li><a href='#' style='color:#15BF6B;'>$Bux Bux</a></li>
                                                                     <li>

          <a a class='dropdown-button' href='#!' data-activates='dropdown1'>$User<i class='material-icons right'>arrow_drop_down</i></a>
          <ul id='dropdown1' class='dropdown-content'>
            <li><a href='/Account/Settings/'>Settings</a></li>
            <li><a href='/Wardrobe'>Wardrobe</a></li>";
            if($myU->PowerAdmin == "true"){
            echo"<li class='divider'></li>
            <li><a href='/Admin/Panel/'>Admin</a></li>
            <li><a href='/UserShopMod'>Shop Items Moderation</a></li>";
            };
            echo"<li class='divider'></li>
            <li><a href='/Account/Logout'>Logout</a></li>
          </ul>
        </li>
</ul>
										";
									
									}
									else {
									
										echo "
									    <ul class='right hide-on-med-and-down'>
									           <li><a href='/Account/Login/' class='waves-effect waves-light btn green'>Login</a></li>
                                                                                   <li><a href='/Account/Register/' class='waves-effect waves-light btn blue'>Register</a></li>
									</ul>
										";
									
									}
									?>
<ul class="side-nav" id="mobile-demo" style="transform: translateX(-100%);">
<li><a href="https://www.bloxcity.com/games/">Games</a></li>
<li><a href="https://www.bloxcity.com/catalog/">Market</a></li>
<li><a href="https://www.bloxcity.com/users/search">Users</a></li>
<li><a href="https://www.bloxcity.com/forum/">Forum</a></li>
<li><a href="https://www.bloxcity.com/upgrade/">Upgrade</a></li>
<li><a href="https://www.bloxcity.com/account/login">Login</a></li><li><a href="https://www.bloxcity.com/account/register" class="waves-effect waves-light btn blue">REGISTER</a></li> </ul>
</div>
</nav>
<?
if($gC->Maintenance == "true"){
if(!$User){
    header('Location: https://maintenance.buildcity.ml/');
    }elseif($myU->PowerAdmin == "false"){
    header('Location: https://maintenance.buildcity.ml/');
    }elseif($myU->PowerAdmin == "true"){
    echo "<div class='alert alert-danger'>
         <center>Currently in Maintenance Mode!</center>
         </div>";
    };
  };
$getShout = mysql_query("SELECT * FROM Shout");
while ($gB = mysql_fetch_object($getShout)) {
if (!empty($gB->Text)) { 
echo"
<div class='card-panel red center-align' style='color:white;margin:0;border-radius:0;'>
<center>".nl2br($gB->Text)."</center>
</div>";
};
};
?>
</body>
