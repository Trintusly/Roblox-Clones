<?php
include '../func/connect.php';
include('../func/navbar.php');
$id = mysqli_real_escape_string($conn, intval($_GET['id']));
	
$topicQ = $conn->query("SELECT * FROM `topics` WHERE `id` = '".$id."'");
$topic = mysqli_fetch_object($topicQ);

if($topic == 0) {
echo'<meta http-equiv="refresh" content="0;url=http://tetrimus.com/forum/" />';    
}

?>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo "".$topic->name.""; ?> | Tetrimus</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body style="overflow-x: hidden;">
<div class='container'>
	<div class='row'>
<div class='col-md-9' style="margin: 0px auto;float: none;">
<div style="padding:10px;border-radius:5px;background-color:#1fc111;border:1px solid #1fc111;color:#fff;">
    <div style='height: 2px;'></div>
			<div style="width:515px;display:inline-block;vertical-align:middle;">
				<b><?php echo "".$topic->name."" ?></b>
			</div>
			<div style="width:10px;display:inline-block;"></div>
			<div style="width:130px;display:inline-block;vertical-align:middle;text-align:center;">
				<b>Views</b>
			</div>
			<div style="width:100px;display:inline-block;vertical-align:middle;text-align:center;">
				<b>Replies</b>
			</div>
	<div style='height: 2px;'></div>
		</div>
<?php
$results_per_page = 12;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
if(!$page || !is_numeric($page)) {
    header("Location: topics.php?id=$id&page=1");
    die();
}
$start_from = ($page - 1) * $results_per_page;
$sqll = "SELECT * FROM `threads` WHERE `forumid` = '$id' ORDER BY lastpostdate DESC LIMIT $start_from, " . $results_per_page;
$output1 = mysqli_fetch_assoc($conn->query($sqll));

$sqlll = "SELECT * FROM `threads` WHERE `forumid` = '$id' ORDER BY pinned DESC, lastpostdate DESC LIMIT $start_from, " . $results_per_page;
$query2 = $conn->query($sqlll);
$check = mysqli_num_rows($query2);
if ($check == 0) {
	echo "    
	<div style='padding:10px;background-color:#fff;border-radius:8px;border:1px solid #efefef;border-top:0;'>
        <div>No topics found. Return <a href='/forum'>here</a>.</div>
		      </div>
			  ";
			  //<div class='text-center'>  <i class='fa fa-question fa-2x' style='color: #31ff00;'></i>  </div>
}else{
$i = 1;
	while ($output2 = mysqli_fetch_assoc($query2))
	{
	$findposter = $conn->query("SELECT * FROM users WHERE `id`='".$output2['poster']."'");
	$poster_info = mysqli_fetch_object($findposter);
	$findlastposter = $conn->query("SELECT * FROM `users` WHERE `id`='".$output2['lastposter']."'");
		$last_poster_info = mysqli_fetch_object($findlastposter);
		echo "<div style='padding:10px;background-color:#fff;    border-radius:5px;border: 1px solid rgba(0,0,0,.125);border-top:0;'>";
		if($output2['views'] >= 200 && $output2['replies'] >= 10){
			echo "<img src='../storage/emotes/fire1.png' style='height: 25px;width: 25px;'>&nbsp;";
		}else{
			echo "<img src='../storage/emotes/file4.png' style='height: 25px;width: 25px;'>&nbsp;";
		}
		echo "<div style='width:129px;display:inline-block;vertical-align:middle;font-size: 11px;border-radius:8px;'><a style='font-size:13px;font-weight:300;' href='view.php?id=".$output2['id']."'><div style='overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'>";echo htmlentities($output2['name']);echo "</div></a>";
		echo "
		<font style='font-size: 11px;'>Posted by: <a style='font-size:13px;font-weight:300;' href='../profile.php?id=".$output2['poster']."'>".$poster_info->username."</a></font>
		";if($output2['pinned'] == 1){
			echo '<i class="fa fa-thumb-tack" aria-hidden="true"></i>';
		}
		if($output2['locked'] == 1){
			echo '&nbsp;<i class="fa fa-lock" aria-hidden="true"></i>';
		}
		echo "</div>";
		echo "<div style='width:395px;display:inline-block;vertical-align:middle;text-align:center;'></div>";
		echo "<div style='width:130px;display:inline-block;vertical-align:middle;text-align:center;'>".$output2['views']."</div>";
        echo "<div style='width:100px;display:inline-block;vertical-align:middle;text-align:center;'>".$output2['replies']."</div>";
		echo "</div>";
	}
$TotalItems = $conn->query("SELECT * FROM `threads` WHERE `forumid` = '$id'");
$TotalItems = mysqli_num_rows($TotalItems);
$section_limit = 10;
$total_pages = $TotalItems / $section_limit;


//this will most likely need some editing, ill fix it later
if ($total_pages < 1) {
    $total_pages = 1;
} else {
    $total_pages = ceil($total_pages);
}

//echo "<h5 style='color:yellow'>for error reporting, current_page:$page and TotalItems: $TotalItems and total_pages: $total_pages and section_limit:$section_limit</h5>";

$back = $page - 1;
$next = $page + 1;

	echo '<nav aria-label="Page navigation example"> <ul class="pagination">';
if ($page != 1) {
echo '<li class="page-item"><a class="page-link" href="topics.php?id=' . $id . '&page=' . $back . '">Previous</a></li>';
}

if ($page != 1) {
    echo '<li class="page-item"><a class="page-link" href="topics.php?id=' . $id . '&page=' . $back . '">'.$back.'</a></li>';
}
echo '<li class="page-item"><a class="page-link" href="topics.php?id=' . $id . '&page=' . $page . '">'.$page.'</a></li>';
if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="topics.php?id=' . $id . '&page=' . $next . '">'.$next.'</a></li>';
}
if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="topics.php?id=' . $id . '&page=' . $next . '">Next</a></li>';
}
echo' </ul> </nav>';
//for testing
//echo "tp = $total_pages and Ti = $TotalItems and SL = $section_limit";
}
?>
<?php
if($user->donator == 1) {
    $changeColor = trim($conn->real_escape_string($_POST['changeColor']));
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
	<h5>Forum stats:</h5>
	<div class="card" style="background-color: white;border-radius: 5px;max-width: 110%;width: 110%;padding: .75rem;border-collapse: collapse;margin-bottom: 1rem;">
    <div class="card-body">
            <div style="height: 10px;"></div>
      <?php echo "".$topic->name.""; ?>
      <?php
      if($loggedIn){
		  ?>
      <div style="height: 10px;"></div>
      Username: <?php echo "$user->username"; ?>&nbsp;&nbsp;</a><br>
	<div style="height: 15px;"></div>
			<?php
		}
if($loggedIn){
if($topic->locked =="false"){
	echo"
  <a class='btn btn-outline-success' style='margin-bottom: 10px;' href='create.php?id=".$topic->id."'>Create</a>
  ";
 }
}
if($loggedIn){

if($topic->locked =="true"){

}
if($topic->id == 1){
    //if($user->power >= 1){
        echo"
  <a class='btn btn-outline-success' style='margin-bottom: 10px;' href='create.php?id=".$topic->id."'>Create</a>
  ";
//    }
}
}
 ?>
 </div>
</div>
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
</html>
