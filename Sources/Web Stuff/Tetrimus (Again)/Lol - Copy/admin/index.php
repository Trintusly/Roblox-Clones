<?php
$currentTime = time();

include '../func/connect.php';

if (!$loggedIn) {
    header("Location: ../");
    exit;
}

if($user->power == 0) {
    header("Location: ../");
}

if(isset($_POST['grant'])){
  $id = $_POST['id'];
  $tokens = $_POST['tokens'];
  $coins = $_POST['coins'];

  $conn->query("UPDATE users SET tokens=$user->tokens + ".$tokens." WHERE id='$id'");
  $conn->query("UPDATE users SET coins=$user->coins + ".$coins." WHERE id='$id'");
  
  $conn->query("INSERT INTO `adminLogs`(`username`, `log`, `time`)
VALUES ('$user->username', 'Granted $tokens tokens and $coins coins to $id', '$currentTime')");
}

if(isset($_POST['grant2'])){
  $id = $_POST['id'];
  $mem = $_POST['mem'];

  $conn->query("UPDATE users SET membership = '$mem' WHERE id='$id'");

  $conn->query("INSERT INTO `adminLogs`(`username`, `log`, `time`)
VALUES ('$user->username', 'Granted $mem to $id', '$currentTime')");
echo"<div class='alert alert-success' style='width: 50%;'>Successfully granted and logged</div>";
sleep(3);

}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin | Tetrimus</title>
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
    <style>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #1fc111;
}
</style>
<?php include '../func/navbar.php';?>
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
  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Logs</a>
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Bans</a>
  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Approval</a>

  <?php
  if($user->power >= 3){
	  echo'
  <a class="nav-link" id="v-pills-executive-tab" data-toggle="pill" href="#v-pills-executive" role="tab" aria-controls="v-pills-executive" aria-selected="false">Executive Panel</a>
  ';
}
?>

</div>
</div>
</div>
	</div>
	<div class='col-md-9' style='margin: 0px auto; float: none;'>
	    <div class="card">
    <div class="card-body">
<div class="tab-content" id="v-pills-tabContent">
  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
      <div style='border-bottom: 1px #eee solid;'>
      Admin Panel
      </div>
      <div style="height: 10px;"></div>
      Grant
      <form action="" method="POST">
      <div style="height: 10px;"></div>
      <input class='form-control' type="text" name="id" placeholder="User ID">
      <div style="height: 10px;"></div>
      <input class='form-control' type="text" name="tokens" placeholder="Amount of Tokens">
      <div style="height: 10px;"></div>
      <input class='form-control' type="text" name="coins" placeholder="Amount of Coins">
      <div style="height: 10px;"></div>
      <input class="btn btn-success" name="grant" type="submit" value="Grant">
      </form>
      <div style='height: 10px;'></div>
      Give membership
      <form action="" method="POST">
      <div style="height: 10px;"></div>
      <input class='form-control' type="text" name="id" placeholder="User ID">
      <div style="height: 10px;"></div>
      <input class='form-control' type="text" name="mem" placeholder="Membership type Bronze, Gold, Diamond">
      <div style="height: 10px;"></div>
      <input class="btn btn-success" name="grant2" type="submit" value="Grant">
    </form>
    </div>
  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <div style='border-bottom: 1px #eee solid;'>
      Logs
      </div>
      <div style="height: 10px;"></div>
      This feature is being worked on. <i class="fa fa-warning"></i>
  </div>
  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
    <div style='border-bottom: 1px #eee solid;'>
      Bans
    </div>
      <div style="height: 10px;"></div>
     <?php
     $banQuery = "SELECT * FROM `bans` WHERE `id` ORDER BY `id` DESC LIMIT 0,10";
        $banQ = $conn->query($banQuery);
        $bannedCount = $banQ->num_rows;
      if ($bannedCount > 0) {
          while($banRow = $banQ->fetch_assoc()) {
              $ID = $banRow['id'];
			  $ban_reason = $banRow['reason'];
			  $ban_name = $banRow['banned_user'];
			  $ban_time = $banRow['ban_time'];
			  $ban_by = $banRow['banned_by'];
			  echo '<div class="card">';
				echo '<div class="card-body">';
				echo '<div style="width:35%;float:left;text-align:center;">'.$ban_name.'<br><a href="/profile.php?id='.$id.'"><img style="width:150px;" src="../images/'.$ID.'.png"></a><br>'.$ban_reason.'';
				echo '';
				echo '</div></div></div><br>';
          }
      }
     ?>
     </div>
  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
       <div style='border-bottom: 1px #eee solid;'>
      Approval
    </div>
      <div style="height: 10px;"></div>
      <?php
      $storeQuery = "SELECT * FROM `store` WHERE `accepted`='0' ORDER BY `id` DESC LIMIT 0,10";
        $storeApp = $conn->query($storeQuery);
        $storeAppCount = $storeApp->num_rows;
      if ($storeAppCount > 0) {
					
					while($storeRow = $storeApp->fetch_assoc()) {
							$itemID = $storeRow['id'];
							$type = $storeRow['type'];
							$name = $storeRow['name'];
							if(isset($_POST['accepted'])){
                                $accepted = strip_tags(mysqli_real_escape_string($conn, $_POST['accepted']));
                                 $setitem = $conn->query("UPDATE `store` SET `accepted` = '1' WHERE `id` = '".$itemID."'");
/* n o.					
					$conn->query("INSERT INTO `adminLogs`(`username`, `log`, `time`)
VALUES ('$user->username', 'accepted asset $itemID', '$currentTime')");
}
*/
                            }
                            if(isset($_POST['decline'])){
                                $accepted = strip_tags(mysqli_real_escape_string($conn, $_POST['accepted']));
                                 $setitem1 = $conn->query("UPDATE `store` SET `accepted` = '0' WHERE `id` = '".$itemID."'");
				  /* n o .
				  $conn->query("INSERT INTO `adminLogs`(`username`, `log`, `time`)
VALUES ('$user->username', 'Declined asset $itemID', '$currentTime')");
}
               
*/
			   }
                            ?>
                            <div style="<?php if (isset($_GET['accepted'])) { if($_GET['accepted'] == "1") { echo "display:block;"; }} if (isset($_GET['decline'])) { if($_GET['decline'] == "0") { echo "display:none;"; }} ?>">
                            <?php
							if($type != "pants") {$type = $type.'shirts';}
							echo '<div class="card">';
							echo '<div class="card-body">';
							echo '<div style="width:35%;float:left;text-align:center;">'.$name.'<br><img style="width:150px;" src="../storage/items/'.$type.'/'.$itemID.'.png"></div>';
							echo '<br><form method="post" action=""><input class="btn btn-success" style="width: 130px;" name="accepted" type="submit" value="Approve"><br><br><input class="btn btn-danger" type="submit" name="decline" style="width: 130px;" value="Decline"></form><div style="height: 20px;"></div>';
							echo '</div></div><br>';
					}
					
					} else {
						?>
      No items need to be approved!
    <?php
					}
      ?>
      
</div>  
</div>  


<div class="tab-pane fade" id="v-pills-executive" role="tabpanel" aria-labelledby="v-pills-executive-tab">
          <div style='border-bottom: 1px #eee solid;'>
      Executive Panel
      </div>
      <div style="height: 10px;"></div>
      This feature is being worked on. <i class="fa fa-warning"></i>
  </div>
      
</div>
</div>
</div>
</div>
</body>
</html>
