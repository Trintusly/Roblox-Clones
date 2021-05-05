<?php
include ('../func/connect.php');
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Clubs | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
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
    <img style='width:150;heigh:150;' class='img-responsive' src='../storage/club_thumbnails/$club->club_icon'>
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
}
}
}
echo "</div>";
echo "<div class='col-md-5' style='border-right: 1px #eee solid;'>$club->club_name<div style='height: 25px;'></div> $club->club_description</div>";
echo "<div class='col-md-4'>Club news<div style='height: 25px;'></div><i>*This feature is a work in progress.*</i></div>";
echo "
    </div>
";
?>
</div>
</div>
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
        echo "<div class='col-md-3' style='margin-bottom: 15px;'><div class='card'><div class='card-body'><center><a href='../profile.php?id=".$row['user_id']."'><img style='width:150;height:150px;' src='../images/".$row['user_id'].".png'><div style='height: 10px;'></div>$member->username</a></center></div></div></div>";
    }
}
?>
</div>
</div>
</div>

</div>
</div>