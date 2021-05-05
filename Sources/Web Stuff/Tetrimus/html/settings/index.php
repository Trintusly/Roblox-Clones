<?php
include'../func/connect.php';
if($loggedIn) {
}else{
header("Location: ../");
}

$update = trim($conn->real_escape_string($_POST['update']));
if ($update) {
    $description = strip_tags($_POST['description']);
    $description = trim($conn->real_escape_string($description));
    $description = htmlentities($description);

    $conn->query("UPDATE users SET description='$description' WHERE id='$user->id'");
    
    $error = "<center><div class='alert alert-success' style='width:100%;'>Successfully updated, your description. Go <a href='../settings.php'>here</a> to see it.</div></center>";
    header("Location: ../settings.php"); //it doesn't change the placeholder for some reason but hey still updates..
}

if($_POST['changeSignature']) {
  $siggy = htmlentities(strip_tags($_POST['newSignature']));
  if(strlen($siggy) > 1000) {
    $sigMessage = "Your signature is too long.";
  }else{
    $updateSiggySQL = "UPDATE users SET signature = '$siggy' WHERE id='$user->id'";
    if($conn->query($updateSiggySQL)) {
      $sigMessage = "updated signature";
    }else{
      $sigMessage = "We could not update your signature at this time";
    }
  }
}
	
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Settings | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body>
<?php
include'../func/navbar.php';
?>
<style>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #007bff;
}
</style>
<div class="container">
    <div class="row">
        <?php
        if(!empty($error)){
            echo $error;
        }
        ?>
        <div class="col-md-3" style='margin: 0px auto; float: none;'>
    <div class="card">
    <div class="card-body">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">General</a>
  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Security</a>
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Billing</a>
  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Privacy</a>
  <a class="nav-link" id="v-pills-notifications-tab" data-toggle="pill" href="#v-pills-notifications" role="tab" aria-controls="v-pills-notifications" aria-selected="false">Notifications</a>
</div>
</div>
</div>
	</div>
	<div class='col-md-9' style='margin: 0px auto; float: none;'>
	    <div class="card">
    <div class="card-body">
<div class="tab-content" id="v-pills-tabContent">
  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
      General
      <div style="height: 10px;"></div>
      Username: 
      <a data-toggle="collapse" style="color: #000;" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    <?php echo "$user->username"; ?>
  </a>
    <div class="collapse" id="collapseExample">
  <div class="card card-body">
    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
</div>
      <div style="height: 10px;"></div>
      Email: 
      <a data-toggle="collapse" style="color: #000;" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
    <?php echo "$user->email"; ?>
  </a>
    <div class="collapse" id="collapseExample2">
  <div class="card card-body">
    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
</div>
      <div style="height: 10px;"></div>
      Membership: <?php echo ucfirst($user->membership); ?>
      <div style="height: 10px;"></div>
      <form method="post" action="">
      <textarea class="form-control" rows="8" name="description" placeholder="<?php echo "$user->description"; ?>"></textarea>
      <div style="height: 10px;"></div>
      <input type="submit" style="background-color: #1fc111;border-color: #1fc112;" class="btn btn-primary" name="update" value="Update">
      </form>
      <form method="post" action="">
      <?php
      if($sigMessage) {
        echo '<center>'.$sigMessage.'</center>';
      }
      ?>
      <textarea class="form-control" rows="2" name="newSignature" placeholder="<?php echo "$user->signature"; ?>"></textarea>
      <div style="height: 10px;">
          
      </div>
      <input type="submit" style="background-color: #1fc111;border-color: #1fc112;" class="btn btn-primary" name="changeSignature" value="Update Signature">
      </form>
      </div>
  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
    Security
    <div style="height: 10px;"></div>
Change username
<form name="updateUSR" method="POST" action="updateUSR">

<input class="form-control" type="text" name="newUser" value="">
<hr>
<button class="btn btn-success" name="updateUSR" value="submit">Change Username</button>
<hr>
<p><i>Note:</i> changing username costs 100 tokens. If you feel like your username invades your privacy email support@tetrimus.xyz</p>
</form>
    <br>

Change password
<form method="POST" action="#">

<input class="form-control" type="text" name="#" value="">
<hr>
<button class="btn btn-success" name="submit" value="submit">Change Password</button>
</form>
<hr>
<center>
<h3>Session Details<h3>
<div class="well" id="sessionWell">
<strong>Browser: </strong><?php echo"$user_browser"?>
<hr>
<strong>OS: </strong><?php echo"$user_os"?>
</div>
</center>
  </div>
  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
    <center><h2>Your Billing info will be located in here</h2>
    <hr>
    <h5>Contact support@tetrimus.xyz for issues regarding your billing info or history.</h5>
    </center>
  </div>
  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
    <div class="custom-control custom-checkbox my-1 mr-sm-2">
    <input type="checkbox" class="custom-control-input" id="customControlInline">
    Privacy
    <label class="custom-control-label" for="customControlInline">2 Step Verification</label>
    <hr>
    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Who can chat with me ingame?</label>
  <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
    <option selected>Everyone</option>
    <option value="1">Everyone</option>
    <option value="2">Friends</option>
    <option value="3">Nobody</option>
  </select>
  <hr>
  <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Who can trade with me?</label>
  <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
    <option selected>Everyone</option>
    <option value="1">Everyone</option>
    <option value="2">Membership Only</option>
    <option value="3">Friends</option>
    <option value="4">Nobody</option>
  </select>


  </div>
  </div>
  <div class="tab-pane fade" id="v-pills-notifications" role="tabpanel" aria-labelledby="v-pills-notifications-tab">
      Work in progress
</div>  
<hr>
<center>
<div class="container">
  <div class="row">
    <div class="col-sm">
<a class="btn btn-primary" href="https://www.tetrimus.xyz/verify" role="button">Verify</a>
    </div>
    <div class="col-sm">
    <button type="button" class="btn btn-outline-danger" disabled>Disable Account</button>
    </div>
    <div class="col-sm">
     <button type="button" class="btn btn-outline-danger" disabled>Delete Account</button>
    </div>
  </div>
</div>
</center>

</div>
</div>  
</div>
</div>
</div>
</body>

