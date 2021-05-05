<?php
include'func/connect.php';
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

if($user->tokens >= 100){
	/*
	even if the name is taken it will still update to it (remember to fix -byte and also make subtracting work)
$updateUser = trim($conn->real_escape_string($_POST['updateUSR']));
if ($updateUser) {
    $newUser = strip_tags($_POST['newUser']);
    $newUser = trim($conn->real_escape_string($newUser));
    $newUser = htmlentities($newUser);

    $conn->query("UPDATE users SET username='$newUser' WHERE id='$user->id'");
	$conn->query("UPDATE users SET coins='$user->coins-100' WHERE id='$user->id'");
    
    $error = "<center><div class='alert alert-success' style='width:100%;'>Successfully updated, your username. Go <a href='../settings.php'>here</a> to see it.</div></center>";
    header("Location: ../settings.php"); //it doesn't change the placeholder for some reason but hey still updates..
	}
}
*/
?>
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
include'func/navbar.php';
?>
<style>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #1fc111;
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
      <input type="submit" style="background-color: #1fc111;border-color: #1fc112;" class="btn btn-success" name="update" value="Update">
      </form>
      </div>
  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
    Security
    <div style="height: 10px;"></div>
Change username
<form name="updateUSR" method="POST" action="#">

<input class="form-control" type="text" name="newUser" value="Enter new username">
<button class="btn btn-success" name="updateUSR" value="submit">Change Username</button>
<p><i>Note:</i> changing username costs 100 tokens. If you feel like your username invades your privacy email help@tetrimus.com.</p>
</form>

Change password
<form method="POST" action="#">

<input class="form-control" type="text" name="#" value="Enter password here">
<button class="btn btn-success" name="submit" value="submit">Change Password</button>
</form>
  </div>
  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
    Billing
  </div>
  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
    Privacy
  </div>
</div>  
</div>
</div>  
</div>
</div>
</div>
</body>