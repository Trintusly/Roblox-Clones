<?php
include('../func/connect.php');
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
//if(!$loggedIn){
	//header("Location: ../");
//}
?>
<div class='container'>
  <div class='row'>
      <div class='col-md-10' style="margin: 0 auto;float: none;">
        <a href="create.php" class="btn btn-outline-success">Create</a>
        <div style="height: 12px;"></div>
<div class="card">
    <div class="card-body">
        <div class="input-group">
      <input type="text" class="form-control" name="search" placeholder="Search">
  <div class="input-group-append">
    <input type="submit" class="btn btn-outline-success" value="Find" name="r">
  </div>
</div>
 <div style='height: 15px;'></div>
        <?php
$filter = trim($conn->real_escape_string($_GET['filter']));
$Find = trim($conn->real_escape_string($_GET['Find']));

$sql2 = "SELECT * FROM clubs ORDER BY club_members DESC";

echo "<div class='row'>";
$result = $conn->query($sql2);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='col-md-3'><div class='card'><div class='card-body'>";if($row['approved'] == 0){ echo "<a href='../clubs/club.php?id=" . $row["id"]. "'><img class='img-responsive' width='150' height='150' src='../storage/pending.png'></a>";}else {echo "<a href='../clubs/club.php?id=" . $row["id"]. "'><img
        class='img-responsive' src='../storage/club_thumbnails/" . $row["club_icon"]. "' width='150' height='150'></a>";}echo "<div style='height: 2px;'></div><div style='overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'><a href='../clubs/club.php?id=" . $row["id"]. "'>" . $row["club_name"]. "</a></div> <div style='height: 10px;'></div>Creator: <div style='overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'>" . $row["creator_name"]. "</div><div style='height: 2px;'></div>Members: ".$row["club_members"]."</div></div></div>";

    }
}
echo "</div>";
?>
	</div>
</div>
</div>
</div>