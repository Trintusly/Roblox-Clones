<?php
include('../func/connect.php');
$RefreshRate = rand(0,1000);

$id = trim($conn->real_escape_string($_GET['id']));

$getthreadquery = $conn->query("SELECT * FROM `threads` WHERE `id` = '".$id."'");
$getthread = mysqli_fetch_object($getthreadquery);

if($getthreadquery->num_rows == 0) {
    header("Location: ../forum/");
}
if($getthread->poster !== $user->username) {
    $add1view = $conn->query("UPDATE `threads` SET `views` = views + 1 WHERE `id` = '$id'");
}
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo "".$getthread->name.""; ?> | Tetrimus</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body style="overflow-x: hidden;">
<?php
include('../func/filter.php');
include('../func/navbar.php');



//$thread = $conn->query("SELECT * FROM `threads`");
//$thread = mysqli_fetch_object($thread);
// del ^
$OriginalPost = $conn->query("SELECT * FROM `threads` WHERE `id`='$id'");
$OriginalPost = mysqli_fetch_object($OriginalPost);

$OriginalPoster = $conn->query("SELECT * FROM `users` WHERE `id`='$OriginalPost->poster'");
$OriginalPoster = mysqli_fetch_object($OriginalPoster);

$FindOriginalPostCount = $conn->query("SELECT * FROM `threads` WHERE `poster`='$OriginalPost->poster'");
$OriginalPostCount = mysqli_num_rows($FindOriginalPostCount);

$FindOriginalReplyCount = $conn->query("SELECT * FROM `replies` WHERE `poster`='$OriginalPost->poster'");
$OriginalReplyCount = mysqli_num_rows($FindOriginalReplyCount);

$posts = ($OriginalReplyCount + $OriginalPostCount);

?>
<div class="container">
  <div class="col-md-10" style="margin: 0px auto;float: none;">
    <?php
    if($loggedIn){
    if($user->power >= 1){
    echo '<form method="POST" action=""><button type="submit" name="delete" class="btn btn-outline-danger" style="float:right;margin-left: 10px; data-toggle="modal" data-target="#myModal">Delete thread</button></button>';
    }
    echo "<a href='/forum/reply.php?id=$OriginalPost->id' style='float:right;' class='btn btn-outline-success'>Reply</a>";
    }
     ?>
     <div style="height:55px;"></div>
<div style="width:100%;">
<div style="border-radius:5px;padding:10px;background-color:#1fc111;border:1px solid #1fc111;color:#fff;margin:0 auto;">
    <div style='height: 2px;'></div>
    <div class='col-md-1'>
			<div style="width:515px;font-size: 17px;display:inline-block;vertical-align:middle;">
				<b><?php echo "$OriginalPost->name"; ?></b>
			</div>
	</div>
	<div style='height: 2px;'></div>
</div>
<?php
//---------------------------------------------------original post below---------------------------------------------------//

echo "
   <div style='padding:15px;background:#fff;border-radius:5px;border: 5px solid rgba(0, 0, 0, 0.12);border-top:0;margin:0 auto;'>";
   echo '<div class="row">';
   echo"
      <div class='col-md-3 text-center'>";
      if (time() < $OriginalPoster->expireTime) {
    echo "<i style='color:#29d840;border-radius: 10px;width: 12px;height: 12px;' class='fa fa-circle' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='" . $cleanuser . " is online'></i>";
}
if (time() > $OriginalPoster->expireTime) {
    echo "<i style='color:#eaedeb;border-radius: 10px;width: 12px;height: 12px;' class='fa fa-circle' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='" . $cleanuser . " is offline'></i>";
}
      echo"<a href='../profile.php?id=$OriginalPoster->id' style='margin-left: 7px;color:$OriginalPoster->name_color;";if($OriginalPoster->donator == 0){echo "color: #4d89ea;";}echo"'>$OriginalPoster->username<br><img class='img-fluid' style='width:200px;' src='../images/" . $OriginalPoster->id . ".png?r=$RefreshRate'></a><br>

";
if ($OriginalPoster->power >= 3) {
       echo "<br><img style='width:150px;' src='../assets/images/admin.png?r=1'><div style='height: 1px;'></div>";
}
if ($OriginalPoster->donator >= 1) {
       echo "<img style='width:150px;' src='../assets/images/donator.png?r=1'><div style='height: 1px;'></div>";
}
echo "
<br><font style='font-size: 14px;'>Join date: ".date('m/d/y', $OriginalPoster->join_date)."</font> <br>
";
$posts = ($OriginalPoster->posts+$OriginalPoster->replies);
echo "
<font style='font-size: 14px;'>Posts: ".$posts."</font>
";

echo "</div>";

// Delete thread.
if (isset($_POST["delete"])) {
    $conn->query("DELETE FROM `replies` WHERE `topic_id`='".$id."'");
    $conn->query("DELETE FROM `threads` WHERE `id`='".$id."'");
    //add refresh loser
    echo"the deed has been done..";
}

echo "
    <div class='col-md-8'>
    <div style='float: right;'>
    </div>
    <div style='color:#9c9c9c;font-size:14px;'><i class='fa fa-clock-o' aria-hidden='true'></i> Posted at ".date('m/d/y', $OriginalPost->date)."<a href=''><i class='fa fa-flag-o' style='float:right;' aria-hidden='true'></i></a>&nbsp;&nbsp;
    <a href='/forum/reply.php?id=$OriginalPost->id'><i class='fa fa-quote-left' style='float:right;margin-right: 15px;' aria-hidden='true'></i></a></div>
    <div style='padding-top:10px;color:#323a46;word-break:break-word;font-size:16px;'><div style='white-space: pre-wrap'>";echo htmlentities(filter($OriginalPost->message));echo "</div></div>";
   
    if($user->power >= 1){
        echo'
<form action="" method="POST">

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>&nbsp;
          <h4 class="modal-title">Delete Thread Confirmation</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this thread?<br>This will completely remove it from the database!</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" name="delete">Delete thread</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</div>
</form>
    ';
    }
echo "</div>";
echo "</div>";
echo "</div>";

$results_per_page = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
if(!$page || !is_numeric($page)) {
    header("Location: view.php?id=$id&page=1");
    die();
}
$start_from = ($page - 1) * $results_per_page;

$query1 = $conn->query("SELECT * FROM `replies` WHERE `topic_id`='$id' ORDER BY id ASC LIMIT $start_from, $results_per_page");

    while ($output = mysqli_fetch_assoc($query1)) {
  $repliesPoster = $conn->query("SELECT * FROM `users` WHERE `id`='".$output['poster']."'");
$repliesPoster = mysqli_fetch_object($repliesPoster);

	$FindPostCount = $conn->query("SELECT * FROM `threads` WHERE `poster`='".$output["poster"]."'");
	$PostCount = mysqli_num_rows($FindPostCount);

	$FindReplyCount = $conn->query("SELECT * FROM `replies` WHERE `poster`='".$output["poster"]."'");
    $ReplyCount = mysqli_num_rows($FindReplyCount);
	
	$posts1 = ($PostCount + $ReplyCount);

        echo "
   <div style='padding:15px;background:#fff;border-radius:5px;border: 1px solid rgba(0,0,0,.125);border-top:0;margin:0 auto;'>";
   echo '<div class="row">';
   echo"
      <div class='col-md-3 text-center'>";
      if (time() < $repliesPoster->expireTime) {
    echo "<i style='color:#29d840;border-radius: 10px;width: 12px;height: 12px;' class='fa fa-circle' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='" . $cleanuser . " is online'></i>";
}
if (time() > $repliesPoster->expireTime) {
    echo "<i style='color:#eaedeb;border-radius: 10px;width: 12px;height: 12px;margin-left: 7px;' class='fa fa-circle' aria-hidden='true' data-toggle='tooltip' data-placement='top' title='" . $cleanuser . " is offline'></i>";
}
      echo "<a href='../profile.php?id=$repliesPoster->id' style='margin-left: 7px;color:$repliesPoster->name_color;";if($repliesPoster->donator == 0){echo "color: #4d89ea;";}echo"'>$repliesPoster->username<br><img style='width:200px;' class='img-fluid' src='../images/" . $repliesPoster->id . ".png?r=$RefreshRate'></a><br>
";
if ($repliesPoster->power >= 3) {
    echo "<br><img style='width:150px;' src='../assets/images/admin.png?r=1'><div style='margin-top:-35px;'></div><br>";
}
if ($repliesPoster->donator >= 1) {
       echo "<br><img style='width:150px;' src='../assets/images/donator.png?r=1'><div style='height: 1px;'></div>";
}
echo "
<br><font style='font-size: 14px;'>Join date: ".date('m/d/y', $repliesPoster->join_date)."
</font> <br>
";
$posts2 = ($repliesPoster->posts+$repliesPoster->replies);
echo "
<font style='font-size: 14px;'>Posts: ".$posts2."</font>
";
echo "</div>";
echo "
    <div class='col-md-8'>
<div style='color:#9c9c9c;font-size:14px;'><i class='fa fa-clock-o' aria-hidden='true'></i> Posted at ".date('m/d/y', $output['date'])."<a href=''><i class='fa fa-flag-o' style='float:right;' aria-hidden='true'></i><a/>&nbsp;&nbsp;
    <a href='/forum/reply.php?id=$OriginalPost->id'><i class='fa fa-quote-left' style='float:right;margin-right: 15px;' aria-hidden='true'></i></a></div>
    <div style='padding-top:10px;word-break:break-word;font-size:16px;color:#323a46;'><div style='white-space: pre-wrap'>";echo htmlentities(filter($output['message'])); echo "</div>";
    if($user->power >1){
        echo"<a style='color: #ff3838;' href='#' name='#'>Delete message</a>";
    }
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";     
}
echo "<div style='height: 10px;'></div>";
$TotalItems = $conn->query("SELECT * FROM `replies` WHERE `topic_id`='$id'");
$TotalItems = mysqli_num_rows($TotalItems);
$section_limit = 5;
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

	echo '<nav aria-label="Page navigation example"> <ul class="pagination justify-content-center">';
if ($page != 1) {
echo '<li class="page-item"><a class="page-link" href="view.php?id=' . $id . '&page=' . $back . '">&laquo;</a></li>';
}

if ($page != 1) {
    echo '<li class="page-item"><a class="page-link" href="view.php?id=' . $id . '&page=' . $back . '">'.$back.'</a></li>';
}
echo '<li class="page-item"><a class="page-link" href="view.php?id=' . $id . '&page=' . $page . '">'.$page.'</a></li>';
if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="view.php?id=' . $id . '&page=' . $next . '">'.$next.'</a></li>';
}
if ($page < $total_pages) {
    echo '<li class="page-item"><a class="page-link" href="view.php?id=' . $id . '&page=' . $next . '">&raquo;</a></li>';
}
echo' </ul> </nav>';
//for testing
//echo "tp = $total_pages and Ti = $TotalItems and SL = $section_limit";


?>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include '../func/footer.php'; ?>
</body>
