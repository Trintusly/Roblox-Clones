<?php
include '../func/connect.php';
include '../func/filterregister.php';

if($loggedIn) {
	header("Location: /home");
}

// hey guys, sushi here... i fixed it

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
$email = htmlentities($email);    
$ip = $_SERVER['REMOTE_ADDR'];
    
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
    
    $checkIpQ = "SELECT * FROM users WHERE Ip = '$ip'";
    $checkIp = $conn->query($checkIpQ);
    
    if($checkIp->num_rows > 1){
        $error = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="float:left;" id="myModalLabel">Error!</h4>
      </div>
      <div class="modal-body">
        You have  2 accounts with this IP!
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
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register | Tetrimus</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body>
<?php include '../func/navbar.php'; ?>
<div id="loader">
    <div style="height: 100px;"></div>
        <center>
      <i style="font-size: 250px;" class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
      <span class="sr-only">Loading...</span>
    </center>
    </div>
  <div id="your-page" style="display:none">
<div class="container">
  <div class="row">
   <div class="col-md-5" style="margin: 0px auto;float: none;">
    <?php
        if(!empty($error)){
            echo $error;
        }
        ?>
        <div style="height: 25px;"></div>
  <div class="card">
  <div class="card-header">
    Sign Up
  </div>
  <div class="card-body">
    <form method="POST" action="">
    <input type="text" name="username" placeholder="Create a username..." class="form-control">
    <div style="height: 10px;"></div>
    <input type="text" name="email" placeholder="Type your E-mail..." class="form-control">
    <div style="height: 10px;"></div>
    <input type="password" name="password" placeholder="Create your password..." class="form-control">
    <div style="height: 10px;"></div>
    <input type="password" name="passwordCon" placeholder="Confirm your password..." class="form-control">
    <div style="height: 10px;"></div>
    <input href="#" type="submit" class="btn btn-outline-success" name="sign_up" value="Sign Up">
  </div>
  </form>
</div>
</div>
</div>
</div>
</div>
   </div>
 </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function(){
    $( "#loader" ).delay(800).fadeOut(400, function(){
        $( "#your-page" ).fadeIn(400);
    });  
});
  $( "#iconButton" ).click(function(){
    $(this).html('<span class="glyphicon glyphicon-menu-cheeseburger"></span>');
});
$('#myModal').modal('show'); 
document.forms['my_form'].submit();
</script>
</body>
</html>