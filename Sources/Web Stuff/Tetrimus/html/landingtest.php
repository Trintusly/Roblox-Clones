<?php
include("func/connect.php");
if(isset($_POST['sign_up'])){
$username = strip_tags($_POST['username']);
$username = trim($conn->real_escape_string($username));
$username = htmlentities($username);
$username = filter($username);

$password = strip_tags($_POST['password']);
$password = trim($conn->real_escape_string($password));
$password = htmlentities($password);

$passwordCon = strip_tags($_POST['passwordCon']);
$passwordCon = trim($conn->real_escape_string($passwordCon));
$passwordCon = htmlentities($passwordCon);

$email = strip_tags($_POST['email']);
$email = trim($conn->real_escape_string($email));
$email = htmlentities($email);    $ip = $_SERVER['REMOTE_ADDR'];
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
  if(strlen($username) < 3 || strlen($username) > 25) {
        $error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Error!</h4>
      </div>
      <div class="modal-body">
        Your username needs to be between 3 & 25 Characters!
      </div>
    </div>
  </div';
    }

 if(preg_match("/∞([%$#*]+)/", $username)) { 
	echo "HI";
	$error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Error!</h4>
      </div>
      <div class="modal-body">
        You cannot have symbols in your username!
      </div>
    </div>
  </div';	
  }   
    if(substr($username,-1) == " " || substr($username,0,1) == " ") {
        $error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Error!</h4>
      </div>
      <div class="modal-body">
        You cannot have a space at the beginning or end of your username!
      </div>
    </div>
  </div';
    }
    
    $email = mysqli_real_escape_string($conn,$_POST['email']);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Error!</h4>
      </div>
      <div class="modal-body">
        Inavlid email!
      </div>
    </div>
  </div';
		}
    
    if($password !== $passwordCon){
        $error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Error!</h4>
      </div>
      <div class="modal-body">
        Your passwords dont match!
        </div>
    </div>
  </div';
    }
    
    $checkUsernameQ = "SELECT * FROM users WHERE username = '$username'";
    $checkUsername = $conn->query($checkUsernameQ);
    
    if($checkUsername->num_rows > 0){
        $error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Error!</h4>
      </div>
      <div class="modal-body">
        Username is taken already!
      </div>
    </div>
  </div';
    }
    
   
    
    if(empty($error)){
	$timeD = time();
        $create = "INSERT INTO users (username, password, email, tokens, coins, power, description, verified, status, Ip, gettc, lastflood, membership, theme, profile_views, join_date, now) VALUES ('$username','$hashed_password','$email','1','25','0','This is a default description.','0','Playing Tetrimus!','$ip','0','0','none','default','0', '$timeD','0')";
        $createUser = $conn->query($create);
        $error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Success!</h4>
      </div>
      <div class="modal-body">
        You have successfully registered!
      </div>
    </div>
  </div>
</div>';
    }
}
?>
<?php
if(isset($_POST['sign_in'])){

$username = strip_tags($_POST['username']);
$username = trim($conn->real_escape_string($username));
$username = htmlentities($username);

$password = strip_tags($_POST['password']);
$password = trim($conn->real_escape_string($password));
$password = htmlentities($password);

    $checkUsernameQ = "SELECT * FROM users WHERE username = '$username'";
    $checkUsername = $conn->query($checkUsernameQ);
    
    $username = mysqli_real_escape_string($conn, $username);
	$userRow = (object) $checkUsername->fetch_assoc();
    $pass = $userRow->{'password'};
    
 if($checkUsername->num_rows > 0){
	 if (password_verify($password, $pass)) { //logged in
			$_SESSION['id'] = $userRow->{'id'};
			$userID = $_SESSION['id'];
			header('Location: /home/');
			die();
	 }else{
	     $error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Error!</h4>
      </div>
      <div class="modal-body">
        Your password is wrong!
      </div>
    </div>
  </div>
</div>';
	 }
   }else{
       $error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Error!</h4>
      </div>
      <div class="modal-body">
        There is not an account with this username. You can make one!
      </div>
    </div>
  </div>
</div>';
   }
}

?>
?>
<html>
<head><script src="//archive.org/includes/analytics.js?v=cf34f82" type="text/javascript"></script>
<script type="text/javascript">window.addEventListener('DOMContentLoaded',function(){var v=archive_analytics.values;v.service='wb';v.server_name='wwwb-app29.us.archive.org';v.server_ms=300;archive_analytics.send_pageview({});});</script>
<script type="text/javascript" src="/static/js/ait-client-rewrite.js?v=1538596186.0" charset="utf-8"></script>
<script type="text/javascript">
WB_wombat_Init('https://web.archive.org/web', '20180707155901', 'tetrimus.com');
</script>
<script type="text/javascript" src="/static/js/wbhack.js?v=1538596186.0" charset="utf-8"></script>
<script type="text/javascript">
__wbhack.init('https://web.archive.org/web');
</script>
<link rel="stylesheet" type="text/css" href="/static/css/banner-styles.css?v=1538596186.0" />
<link rel="stylesheet" type="text/css" href="/static/css/iconochive.css?v=1538596186.0" />
<!-- End Wayback Rewrite JS Include -->

	<title>Landing | Tetrimus</title>
	 <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tetrimus is an online up-and-coming 3D multiplayer sandbox game!">
  	<meta name="keywords" content="Fun Games, Sandbox Games, 3D Games, tetrimus, tetrimus.com">
  	<meta http-equiv="x-ua-compatible" content="ie=edge">
  	<meta name="author" content="Tetrimus Inc.">

    <!-- CSS -->
    <link rel="stylesheet" href="https://web.archive.org/web/20180707155901cs_/https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/web/20180707155901cs_/https://tetrimus.com/main-light.css?r=34">
    <link rel="stylesheet" href="style.css">

    <!-- FontAwsome -->
    <script src="https://web.archive.org/web/20180707155901js_/https://use.fontawesome.com/972a1e6dcd.js"></script>
    <link rel="stylesheet" href="https://web.archive.org/web/20180707155901cs_/https://use.fontawesome.com/c78fe38725.css">

    <!-- JS -->
	  <script src="https://web.archive.org/web/20180707155901js_/https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://web.archive.org/web/20180707155901js_/https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://web.archive.org/web/20180707155901js_/https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

</head>
<body style="background: url(https://web.archive.org/web/20180707155901im_/https://tetrimus.com/background.png);background-size: cover;"><!-- BEGIN WAYBACK TOOLBAR INSERT -->
<script type="text/javascript" src="/static/js/timestamp.js?v=1538596186.0" charset="utf-8"></script>
<script type="text/javascript" src="/static/js/graph-calc.js?v=1538596186.0" charset="utf-8"></script>
<script type="text/javascript" src="/static/js/auto-complete.js?v=1538596186.0" charset="utf-8"></script>
<script type="text/javascript" src="/static/js/toolbar.js?v=1538596186.0" charset="utf-8"></script>
<style type="text/css">
@import url('https://fonts.googleapis.com/css?family=Montserrat');
body {
  margin-top:0 !important;
  padding-top:0 !important;
  /*min-width:800px !important;*/
}
.wb-autocomplete-suggestions {
    text-align: left; cursor: default; border: 1px solid #ccc; border-top: 0; background: #fff; box-shadow: -1px 1px 3px rgba(0,0,0,.1);
    position: absolute; display: none; z-index: 2147483647; max-height: 254px; overflow: hidden; overflow-y: auto; box-sizing: border-box;
}
.wb-autocomplete-suggestion { position: relative; padding: 0 .6em; line-height: 23px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 1.02em; color: #333; }
.wb-autocomplete-suggestion b { font-weight: bold; }
.wb-autocomplete-suggestion.selected { background: #f0f0f0; }
</style>
<div id="wm-ipp" lang="en" style="display:none;direction:ltr;">
<div style="position:fixed;left:0;top:0;right:0;">
<div id="wm-ipp-inside">
  <div style="position:relative;">
    <div id="wm-logo" style="float:left;width:130px;padding-top:10px;">
      <a href="/web/" title="Wayback Machine home page"><img src="/static/images/toolbar/wayback-toolbar-logo.png" alt="Wayback Machine" width="110" height="39" border="0" /></a>
    </div>
    <div class="r" style="float:right;">
      <div id="wm-btns" style="text-align:right;height:25px;">
                  <div id="wm-save-snapshot-success">success</div>
          <div id="wm-save-snapshot-fail">fail</div>
          <a href="#"
             onclick="__wm.saveSnapshot('https://tetrimus.com/', '20180707155901')"
             title="Share via My Web Archive"
             id="wm-save-snapshot-open"
          >
            <span class="iconochive-web"></span>
          </a>
          <a href="https://archive.org/account/login.php"
             title="Sign In"
             id="wm-sign-in"
          >
            <span class="iconochive-person"></span>
          </a>
          <span id="wm-save-snapshot-in-progress" class="iconochive-web"></span>
        	<a href="http://faq.web.archive.org/" title="Get some help using the Wayback Machine" style="top:-6px;"><span class="iconochive-question" style="color:rgb(87,186,244);font-size:160%;"></span></a>
	<a id="wm-tb-close" href="#close" onclick="__wm.h(event);return false;" style="top:-2px;" title="Close the toolbar"><span class="iconochive-remove-circle" style="color:#888888;font-size:240%;"></span></a>
      </div>
      <div id="wm-share" style="text-align:right;">
	<a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=https://web.archive.org/web/20180707155901/https://tetrimus.com/', '', 'height=400,width=600'); return false;" title="Share on Facebook" style="margin-right:5px;" target="_blank"><span class="iconochive-facebook" style="color:#3b5998;font-size:160%;"></span></a>
	<a href="#" onclick="window.open('https://twitter.com/intent/tweet?text=https://web.archive.org/web/20180707155901/https://tetrimus.com/&amp;via=internetarchive', '', 'height=400,width=600'); return false;" title="Share on Twitter" style="margin-right:5px;" target="_blank"><span class="iconochive-twitter" style="color:#1dcaff;font-size:160%;"></span></a>
      </div>
    </div>
    <table class="c" style="">
      <tbody>
	<tr>
	  <td class="u" colspan="2">
	    <form target="_top" method="get" action="/web/submit" name="wmtb" id="wmtb"><input type="text" name="url" id="wmtbURL" value="https://tetrimus.com/" onfocus="this.focus();this.select();" /><input type="hidden" name="type" value="replay" /><input type="hidden" name="date" value="20180707155901" /><input type="submit" value="Go" /></form>
	  </td>
	  <td class="n" rowspan="2" style="width:110px;">
	    <table>
	      <tbody>
		<!-- NEXT/PREV MONTH NAV AND MONTH INDICATOR -->
		<tr class="m">
		  <td class="b" nowrap="nowrap"><a href="https://web.archive.org/web/20180606205156/https://tetrimus.com/" title="06 Jun 2018"><strong>Jun</strong></a></td>
		  <td class="c" id="displayMonthEl" title="You are here: 15:59:01 Jul 07, 2018">JUL</td>
		  <td class="f" nowrap="nowrap"><a href="https://web.archive.org/web/20180819051031/https://tetrimus.com/" title="19 Aug 2018"><strong>Aug</strong></a></td>
		</tr>
		<!-- NEXT/PREV CAPTURE NAV AND DAY OF MONTH INDICATOR -->
		<tr class="d">
		  <td class="b" nowrap="nowrap"><a href="https://web.archive.org/web/20180627142811/https://tetrimus.com/" title="14:28:11 Jun 27, 2018"><img src="/static/images/toolbar/wm_tb_prv_on.png" alt="Previous capture" width="14" height="16" border="0" /></a></td>
		  <td class="c" id="displayDayEl" style="width:34px;font-size:24px;white-space:nowrap;" title="You are here: 15:59:01 Jul 07, 2018">07</td>
		  <td class="f" nowrap="nowrap"><a href="https://web.archive.org/web/20180805002111/http://tetrimus.com/" title="00:21:11 Aug 05, 2018"><img src="/static/images/toolbar/wm_tb_nxt_on.png" alt="Next capture" width="14" height="16" border="0" /></a></td>
		</tr>
		<!-- NEXT/PREV YEAR NAV AND YEAR INDICATOR -->
		<tr class="y">
		  <td class="b" nowrap="nowrap">2017</td>
		  <td class="c" id="displayYearEl" title="You are here: 15:59:01 Jul 07, 2018">2018</td>
		  <td class="f" nowrap="nowrap">2019</td>
		</tr>
	      </tbody>
	    </table>
	  </td>
	</tr>
	<tr>
	  <td class="s">
	    	    <div id="wm-nav-captures">
	      	      <a class="t" href="/web/20180707155901*/https://tetrimus.com/" title="See a list of every capture for this URL">15 captures</a>
	      <div class="r" title="Timespan for captures of this URL">10 Mar 2018 - 28 Aug 2018</div>
	      </div>
	  </td>
	  <td class="k">
	    <a href="" id="wm-graph-anchor">
	      <div id="wm-ipp-sparkline" title="Explore captures for this URL" style="position: relative">
		<canvas id="wm-sparkline-canvas" width="575" height="27" border="0"></canvas>
	      </div>
	    </a>
	  </td>
	</tr>
      </tbody>
    </table>
    <div style="position:absolute;bottom:0;right:2px;text-align:right;">
      <a id="wm-expand" class="wm-btn wm-closed" href="#expand" onclick="__wm.ex(event);return false;"><span id="wm-expand-icon" class="iconochive-down-solid"></span> <span style="font-size:80%">About this capture</span></a>
    </div>
  </div>
    <div id="wm-capinfo" style="border-top:1px solid #777;display:none; overflow: hidden">
            <div style="background-color:#666;color:#fff;font-weight:bold;text-align:center">COLLECTED BY</div>
    <div style="padding:3px;position:relative" id="wm-collected-by-content">
            <div style="display:inline-block;vertical-align:top;width:50%;">
			<span class="c-logo" style="background-image:url(https://archive.org/services/img/webwidecrawl);"></span>
		Organization: <a style="color:#33f;" href="https://archive.org/details/webwidecrawl" target="_new"><span class="wm-title">Internet Archive</span></a>
		<div style="max-height:75px;overflow:hidden;position:relative;">
	  <div style="position:absolute;top:0;left:0;width:100%;height:75px;background:linear-gradient(to bottom,rgba(255,255,255,0) 0%,rgba(255,255,255,0) 90%,rgba(255,255,255,255) 100%);"></div>
	  The Internet Archive discovers and captures web pages through many different web crawls.

At any given time several distinct crawls are running, some for months, and some every day or longer.

View the web archive through the <a href="http://archive.org/web/web.php">Wayback Machine</a>.
	</div>
	      </div>
      <div style="display:inline-block;vertical-align:top;width:49%;">
			<span class="c-logo" style="background-image:url(https://archive.org/services/img/liveweb)"></span>
		<div>Collection: <a style="color:#33f;" href="https://archive.org/details/liveweb" target="_new"><span class="wm-title">Live Web Proxy Crawls</span></a></div>
		<div style="max-height:75px;overflow:hidden;position:relative;">
	  <div style="position:absolute;top:0;left:0;width:100%;height:75px;background:linear-gradient(to bottom,rgba(255,255,255,0) 0%,rgba(255,255,255,0) 90%,rgba(255,255,255,255) 100%);"></div>
	  Content crawled via the <a href="http://archive.org/web/web.php">Wayback Machine</a> Live Proxy mostly by the Save Page Now feature on web.archive.org.
<br /><br />
Liveweb proxy is a component of Internet Archive’s wayback machine project. The liveweb proxy captures the content of a web page in real time, archives it into a ARC or WARC file and returns the ARC/WARC record back to the wayback machine to process. The recorded ARC/WARC file becomes part of the wayback machine in due course of time.
<br /><br />
	</div>
	      </div>
    </div>
    <div style="background-color:#666;color:#fff;font-weight:bold;text-align:center" title="Timestamps for the elements of this page">TIMESTAMPS</div>
    <div>
      <div id="wm-capresources" style="margin:0 5px 5px 5px;max-height:250px;overflow-y:scroll !important"></div>
      <div id="wm-capresources-loading" style="text-align:left;margin:0 20px 5px 5px;display:none"><img src="/static/images/loading.gif" alt="loading" /></div>
    </div>
  </div></div></div></div><script type="text/javascript">
__wm.bt(575,27,25,2,"web","https://tetrimus.com/","2018-07-07",1996);
</script>
<!-- END WAYBACK TOOLBAR INSERT -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="box-shadow: 0px 1px #dbdbdb;padding:0.8px 8px!important;margin-bottom: 90px;">
  <a class="navbar-brand" style="margin-right: 0px!important;" href="https://web.archive.org/web/20180707155901/https://tetrimus.com/"><img src="/web/20180707155901im_/https://tetrimus.com/storage/assets/TetrimusLOGO.png?r=<?php echo time(); ?>" width="33" height="35"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  
</nav>
<div class="modal fade" id="sign-in" tabindex="-1" role="dialog" aria-labelledby="sign-in" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sign In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="Post" action="">
  <div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" name="username" placeholder="Username">
       </div>
   <div class="form-group">
    <labe>Password</label>
    <input type="password" class="form-control" name="password" placeholder="Password">
       </div>
       <?php
      //its just gonna stay here unless i need it for testing purposes - South<input href="#" type="submit" class="btn btn-outline-success" name="sign_in" value="Sign In"> ?>
      <input href="#" type="submit" type="submit" href="#" name="sign_in" class="btn btn-primary btn-block" value="Sign In">
  <div style="height: 8px;"></div>
  <div class="row">
  <div class="col-md-8">
<a href="" style="text-decoration: none">Forgot Password?</a>
  </div>
  </div>
</form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="sign-up" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="Post" action="">
  <div class="form-group">
    <label>Email address</label>
    <input type="text" class="form-control" name="email" placeholder="Enter your email">
      </div>
  <div class="form-group">
    <label>Username</label>
    <input type="text" class="form-control" name="username" placeholder="Username">
       </div>
  <div class="row">
  <div class="col-xs-12 col-sm-6 col-md-6">
   <div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" name="password" placeholder="Password">
       </div>
  </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
   <div class="form-group">
    <label>Confirm Password</label>
    <input type="password" class="form-control" name="passwordc" placeholder="Confirm Password">
       </div>
  </div>
  </div>
  <div class="form-group">
    <label>Referral code</label>
    <input type="text" class="form-control" name="code" placeholder="Code">
       </div>
  <div style="height: 5px;"></div>
  <button type="submit" name="sign_up" class="btn btn-primary btn-block">Sign Up</button>
</form>
      </div>
    </div>
  </div>
</div><div class="container">
<div class="col-md-8" style="margin: 0 auto;float:none;">
<div class="card bg-light">
    <div class="card-body">
    <h5 class="card-title">What is Tetrimus?</h5>
    <p class="card-text text-muted">Tetrimus is an online up-and-coming 3D multiplayer sandbox game!</p>
     <h5 class="card-title">What can you do in Tetrimus?</h5>
    <p class="card-text text-muted">There are many things you can do on Tetrimus including making friends, posting on the forums, customizing your own avatar, and much more!</p>
     <h5 class="card-title">What are realms?</h5>
    <p class="card-text text-muted">The realms are not done at the moment but are projected to be out in a few months or so!</p>
    <div style="height: 10px;"></div>
    <center><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#sign-up">Get started</a><a href="#" style="margin-left: 10px;" class="btn btn-success" data-toggle="modal" data-target="#sign-in">Sign In</a></center>
    </div>
</div>
</div>
</div>
</div>
</body>
</html><!--
     FILE ARCHIVED ON 15:59:01 Jul 07, 2018 AND RETRIEVED FROM THE
     INTERNET ARCHIVE ON 22:03:33 Oct 14, 2018.
     JAVASCRIPT APPENDED BY WAYBACK MACHINE, COPYRIGHT INTERNET ARCHIVE.

     ALL OTHER CONTENT MAY ALSO BE PROTECTED BY COPYRIGHT (17 U.S.C.
     SECTION 108(a)(3)).
-->
<!--
playback timings (ms):
  LoadShardBlock: 190.78 (3)
  esindex: 0.006
  captures_list: 208.551
  CDXLines.iter: 12.809 (3)
  PetaboxLoader3.datanode: 197.782 (4)
  exclusion.robots: 0.268
  exclusion.robots.policy: 0.257
  RedisCDXSource: 1.48
  PetaboxLoader3.resolve: 22.299
  load_resource: 65.463
-->