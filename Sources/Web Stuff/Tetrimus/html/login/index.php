<?php
include '../func/connect.php';
if($loggedIn) {
	header("Location: /home");
}
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
			header('Location: ../home/');
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
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login | Tetrimus</title>
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
<center><div class="alert alert-primary" role="alert">
  Login is undergoing maintenance. Check the status at: <a href="https://www.tetrimus.xyz/discord">Our Discord</a>
</div></center>
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
    Sign In
  </div>
  <div class="card-body">
    <form method="POST" action="">
    <input type="text" name="username" placeholder="Enter your username..." class="form-control">
    <div style="height: 10px;"></div>
    <input type="password" name="password" placeholder="Enter your password..." class="form-control" onkeypress="capLock(event)">
    <div id="capDetect" style="visibility:hidden;color:red">Caps Lock is on.</div> 

  <script id="capDetect">
  function capLock(e){
  var kc = e.keyCode ? e.keyCode : e.which;
  var sk = e.shiftKey ? e.shiftKey : kc === 16;
  var visibility = ((kc >= 65 && kc <= 90) && !sk) || 
      ((kc >= 97 && kc <= 122) && sk) ? 'visible' : 'hidden';
  document.getElementById('capDetect').style.visibility = visibility
}
</script>

    <div style="height: 10px;"></div>
     <input href="#" type="submit" type="submit" href="#" name="sign_in" class="btn btn-primary btn-block" value="Sign In">
  <div style="height: 8px;"></div>
  <div class="row">
  <div class="col-md-8">
<a href="https://www.tetrimus.xyz/login/forgot-password/" style="text-decoration: none">Forgot Password?</a>
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