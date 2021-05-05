<?php
include ('../func/connect.php');


$id = trim($conn->real_escape_string($_GET['id']));

$fetchclub = $conn->query("SELECT * FROM `clubs` WHERE `id`='$id'");
$club = mysqli_fetch_object($fetchclub);

$creator = $conn->query("SELECT * FROM `users` WHERE `id`='$club->creator_name'");
$owner = mysqli_fetch_object($creator);

$FetchTotoalMembers = $conn->query("SELECT * FROM `club_members` WHERE `club_id`='$id'");
$TotalMembers = mysqli_num_rows($FetchTotoalMembers);
$TotalMembers = $TotalMembers+1; //we add +1 because of the owner who is on a different table

$IsMember = $conn->query("SELECT * FROM `club_members` WHERE `club_id`='$id' AND `user_id`='$user->id'");
$IsMember = mysqli_num_rows($IsMember);
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo"$club->club_name"?> | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content='<?php echo"$club->club_description"?>'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://tetrimus.xyz/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
<script>
// Replace source
$('img').error(function(){
        $(this).attr('src', 'https://www.tetrimus.xyz/images/default.png');
});
</script>
</head>
<?php
include('../func/navbar.php');
?>
<div class='container'>
  <div class='row'>
      <div class='col-md-10' style="margin: 0 auto;float: none;">
<div class="card">
    <div class="card-body">
<?php
//if ($IsMember == 0) {</i></div>";
//echo "
    //</div>
//";

//leave and join query start
if (isset($_POST['join'])) {
	$exists = mysqli_fetch_array($conn->query("SELECT * FROM `clubs` WHERE `id`='$id'"));
	if ($IsMember == 0) {
		if ($exists != 0) {
			$join = "INSERT INTO club_members (club_id, user_id, role) VALUES ('$id', '$user->id', 'Members')";
			$conn->query("UPDATE `clubs` SET `club_members` = $TotalMembers+1 WHERE `id` = '$id'");
			echo '<script>window.location.replace("club.php?id='.$id.'&joined=true");</script>';
			if ($conn->query($join) === TRUE) {
			}else{
				echo "Error: <br />" . $conn->error;
			}
		}
	}
}
       

if (isset($_POST['leave'])) {
	$leave = "DELETE FROM club_members WHERE club_id='$id' AND user_id='$user->id'";
  $conn->query("UPDATE `clubs` SET `club_members` = $TotalMembers-1 WHERE `id` = '$id'");
	if ($conn->query($leave) == TRUE) {
		header("Location: club.php?id=$id&left=true");
	}else{
		echo "Error: <br />" . $conn->error;
	}
}
//leave and join query end

//main part of group start
echo "
<div class='row'>
  <div class='col-md-3'>
  ";
  if($club->approved == 0){
     echo "<img class='img-responsive' width='150' height='150' src='../storage/pending.png'>";
  }else{
  echo "
    <img style='width:150;heigh:150;' class='img-responsive' src='https://tetrimus.xyz/storage/club_thumbnails/$club->club_icon'>
";
}
echo "<br>Creator: $club->creator_name <br>Members: $TotalMembers
<br>";
if($user->username !== $club->creator_name){
    if($loggedIn){
if($IsMember == 0) {
echo "
<form method='POST' action=''>
	<button class='btn btn-success' name='join' type='submit'>Join</button>
</form>

";
}else{
echo "
<form method='POST' action=''>
	<button class='btn btn-danger' name='leave' type='submit'>Leave</button>
</form>
";
if($user->username == $club->creator_name){
    echo"<form method='POST' action=''>
	<button class='btn btn-primary' name='manage' type='submit'>Manage Club</button>
</form>";
}
if($user->power > 1){
    echo"
	<button class='btn btn-primary' name='manage' type='submit' data-toggle='modal' data-target='#manageClub'>Manage Club</button>
";
  
}

}
}
}
echo "</div>";
echo "<div class='col-md-5' style='border-right: 1px #eee solid;'>$club->club_name<div style='height: 25px;'></div> $club->club_description</div>";
echo "<div class='col-md-4'>Club news<div style='height: 25px;'></div><h5>$club->club_news</h5>
	//if ($IsMember == 0) {</i></div>";
echo "
    </div>
";
?>
<!-- Club Management -->
<div class="modal fade bd-example-modal-lg" id="manageClub" tabindex="-1" role="dialog" aria-labelledby="manageClub" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Manage <?php echo"$club->club_name"?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link" id="manageGeneral" data-toggle="tab" href="#manageGeneral" role="tab" aria-controls="manageGeneral" aria-selected="false">General</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="manageRoles" data-toggle="tab" href="#manageRoles" role="tab" aria-controls="manageRoles" aria-selected="false">Roles</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" id="manageMembers" data-toggle="tab" href="#manageMembers" role="tab" aria-controls="manageMembers" aria-selected="false">Members</a>
    </li>
  <li class="nav-item">
    <a class="nav-link" id="manageShirts" data-toggle="tab" href="#manageShirts" role="tab" aria-controls="manageShirts" aria-selected="false">Shirts</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="#managePants" data-toggle="tab" href="#managePants" role="tab" aria-controls="managePants" aria-selected="false">Pants</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="#manageRealms" data-toggle="tab" href="#manageRealms" role="tab" aria-controls="#manageRealms" aria-selected="false">Realms</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="#manageNews" data-toggle="tab" href="#manageNews" role="tab" aria-controls="#manageNews" aria-selected="false">News</a>
</ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?php
/* some broken code 
<div class="tab-pane fade" id="#manageGeneral" role="tabpanel" aria-labelledby="manageGeneral">
<div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Club Description" aria-label="Club Description" aria-describedby="basic-addon2">
  </div>
  */?>

<div style="height: 10px;"></div>
</div>
<div class='col-md-10' style="margin: 0 auto;float: none;">
<div class="card">
    <div class="card-body">
      <div class='col-md-3'>
        <select class="form-control" id="exampleFormControlSelect1">
            <?php
            echo "<option id='$club->role1'>$club->role1</option>";
            echo "<option id='$club->role2'>$club->role2</option>";
            echo "<option id='$club->role3'>$club->role3</option>";

            ?>     
        </select>
        </div>
        <div style="height: 35px;"></div>
      <div class="row">
<?php

$sql2 = "SELECT * FROM club_members WHERE club_id = '$id'";

$result = $conn->query($sql2);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $mem = $conn->query("SELECT * FROM `users` WHERE `id`='".$row['user_id']."'");
        $member = mysqli_fetch_object($mem);
        echo "<div class='col-md-3' style='margin-bottom: 15px;'><div class='card'><div class='card-body'><center><a href='../profile.php?id=".$row['user_id']."'><img style='width:150;height:150px;' src='https://www.tetrimus.xyz/images/".$row['user_id'].".png'onerror='this.src='../images/default.png'"?>onerror='this.src="../images/default.png"'><?php echo"<div style='height: 10px;'></div>$member->username</a></center></div></div></div>";
    }
}
?>
</div>
</div>
</div>

</div>
</div>