<?php
include '../func/connect.php';
// Has to be like this.
$Qtopic = $conn->query("SELECT * from topics");
$topic = mysqli_fetch_object($Qtopic);
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forum | Tetrimus</title>
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
include('../func/filter.php');
?>
<body>
<div class='container'>
  <div class='row'>
<div class='col-md-9' style="margin: 0px auto;float: none;">

<div style="padding:10px;border-radius:5px;background-color:#1fc111;border:1px solid #1fc111;color:#fff;">
    <div style='height: 2px;'></div>
			<div style="width:515px;display:inline-block;vertical-align:middle;">
				Tetrimus
			</div>
			<div style="width:10px;display:inline-block;"></div>
			<div style="width:130px;display:inline-block;vertical-align:middle;text-align:center;">
				Threads
			</div>
			<div style="width:105px;display:inline-block;vertical-align:middle;text-align:center;">
				Replies
			</div>
	<div style='height: 2px;'></div>
		</div>
        <?php
        $query1 = $conn->query('SELECT * FROM topics ORDER BY id ASC'); 
        $query2 = $conn->query('SELECT * FROM replies'); 
        $output2 = mysqli_fetch_assoc($query2);
    while ($output1 = mysqli_fetch_assoc($query1)){

    $fetchNewestID = $conn->query("SELECT * FROM `threads` WHERE `forumid`='".$output1['id']."' ORDER BY `id` DESC LIMIT 1");
    $newestIDResult = mysqli_fetch_array($fetchNewestID);
    $newestID = $newestIDResult['id'];

$findPostInfo = $conn->query("SELECT * FROM `threads` WHERE `id`='$newestID' AND `forumid`='".$output1['id']."'");
$findPostInfo = mysqli_fetch_object($findPostInfo);

$lastPoster = $conn->query("SELECT * FROM `users` WHERE `id`='$findPostInfo->poster'");
$lastPoster = mysqli_fetch_object($lastPoster);

$findThreadCount = $conn->query("SELECT * FROM `threads` WHERE `forumid`='".$output1['id']."'");
$threadCount = mysqli_num_rows($findThreadCount);


$findReplyCount = $conn->query("SELECT * FROM `replies` WHERE `forum_id`='".$output1['id']."'");
$replyCount = mysqli_num_rows($findReplyCount);
if($output1['category'] ==1){


echo "
   <div style='padding:10px;background-color:#fff;    border-radius:5px;border: 1px solid rgba(0,0,0,.125);border-top:0;'>
   <div style='width:515px;display:inline-block;vertical-align:middle;'>
   <a href='topics.php?id=".$output1['id']."' style='text-decoration:none;color:#363636;'>
	<div style='font-size:18px;font-weight:400;color:#363636;'>".$output1['name']."
	</div>
	<div style='font-size:14px;color:#666;font-weight:300;'>".$output1['description']."
	</div>
	</a>
	</div>
        <div style='width:130px;display:inline-block;vertical-align:middle;text-align:center;'>".$threadCount."</div>
        <div style='width:100px;display:inline-block;vertical-align:middle;text-align:center;'>".$replyCount."</div>
    </div>
    
";
}
if($output1['category'] ==2){
echo"<br>";
}
if($output1['category'] ==2){
/*
 this messes up the forums a lot but I need this
 <br>
<div style='padding:10px;border-radius:5px;background-color:#1fc111;border:1px solid #1fc111;color:#fff;'>
    <div style='height: 2px;'></div>
			<div style='width:515px;display:inline-block;vertical-align:middle;'>
				Clubs
			</div>
			<div style='width:10px;display:inline-block;'></div>
			<div style='width:130px;display:inline-block;vertical-align:middle;text-align:center;'>
				Threads
			</div>
			<div style='width:105px;display:inline-block;vertical-align:middle;text-align:center;'>
				Replies
			</div>
	<div style='height: 2px;'></div>
		</div>
		*/

echo"

   <div style='padding:10px;background-color:#fff;    border-radius:5px;border: 1px solid rgba(0,0,0,.125);border-top:0;'>
   <div style='width:515px;display:inline-block;vertical-align:middle;'>
   <a href='topics.php?id=".$output1['id']."' style='text-decoration:none;color:#363636;'>
	<div style='font-size:18px;font-weight:400;color:#363636;'>".$output1['name']."
	</div>
	<div style='font-size:14px;color:#666;font-weight:300;'>".$output1['description']."
	</div>
	</a>
	</div>
        <div style='width:130px;display:inline-block;vertical-align:middle;text-align:center;'>".$threadCount."</div>
        <div style='width:100px;display:inline-block;vertical-align:middle;text-align:center;'>".$replyCount."</div>
    </div>
";
}
}
?>
<?php
if($user->donator == 1) {
    $changeColor = trim($conn->real_escape_string($_POST['color']));
    if ($changeColor) {
    $color = trim($conn->real_escape_string($_POST['color']));
    $validation = str_replace("#","","$color");
        if (ctype_xdigit($validation)) {
            $conn->query("UPDATE `users` SET `name_color`='$color' WHERE id='$user->id'");
	    echo"<center><div class='alert alert-success'>Successfully updated forum name color.</div></center>";
        } else {
            echo "<center><div class='alert alert-danger'>The color you chose is not a valid color.</div></center>";
        }
    }
}
?>
</div>
<div class="col-md-3">
	<?php
	if($loggedIn){
?>
<h5>Forum stats:</h5>
  <div class='card' style='background-color: white;border-radius: 5px;max-width: 110%;width: 110%;padding: .75rem;border-collapse: collapse;margin-bottom: 1rem;'>
    <div class='card-body'>
      <div style="height: 10px;"></div>
      Username: <?php echo "$user->username"; ?>&nbsp;&nbsp;</a><br>
<?php
if($user->donator == 1) {
echo "
<form action='' method='POST'>
Name Color:<br><input style='width:50px;height:50px;display:inline-block;cursor:pointer;border:0px solid $user->name_color;' type='color' name='color' value='$user->name_color'><br>
<input class='btn btn-success' type='submit' value='change' name='changeColor'>
</form>
";
}
?>
      <div style="height: 15px;"></div>

    </div>
  </div>
  <?php
}
?>
  <div style="height: 10px;"></div>
<table style='background-color: white;border-radius: 5px;' class="table">
	<h5>Leaderboard:</h5>
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">User</th>
      <th scope="col">Level</th>
      <th scope="col">Points</th>
    </tr>
  </thead>
  <tbody>

<?php
$findLeaders = $conn->query("SELECT * FROM `users` ORDER BY `points` DESC LIMIT 5");
        $i = 1;
	while ($leaders = $findLeaders->fetch_assoc()) {
	        $rank = $i++;
		echo "
    <tr>
      <th scope='row'>".$rank."</th>
      <td>".$leaders['username']."</td>
      <td>".$leaders['level']."</td>
      <td>".$leaders['points']."</td>
    </tr>
		";
	}
?>

  </tbody>
</table>
</div>
</div>
</div>
<?php include '../func/footer.php'; ?>
</body>
