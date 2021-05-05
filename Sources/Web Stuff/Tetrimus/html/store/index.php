<?php
include '../func/connect.php';

?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Store | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
<link rel="stylesheet" href="../assets/css/storeFramework.css">
</head>
<body>
    <style>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #007bff;
}
</style>
<?php include '../func/navbar.php';
echo'<center><div class="alert alert-primary" role="alert">
  Store is complete obsolete. Check the status at: <a href="https://www.tetrimus.xyz/discord">Our Discord</a>
</div></center>';

if (isset($_GET["r"])) {
    $search = trim($conn->real_escape_string($_GET['search']));
}
$type = trim($conn->real_escape_string($_GET['type']));
echo "
<div class='container'>
  <div class='row'>
    <div class='col-md-3' style='margin: 0px auto; float: none;'>
    <div class='card'>
            <div class='card-body'>
    ";
    echo '<a href="http://tetrimus.xyz/store/create" class="btn btn-primary">Create</a>
    <br>
    <br>
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">All</a>
  <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Hats</a>
  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Heads</a>
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Shirts</a>
  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Pants</a>
</div>
</div>
</div>
</div>
';
echo "
<div class='col-md-9' style='margin: 0px auto; float: none;'>
<div class='card' style='padding: 15px;'>
<div class='card-body'>
  <form action='' method='Post'>
  ";
  ?>
  
<div class="input-group">
      <input type="text" class="form-control" name="r" placeholder="Search">
  <div class="input-group-append">
    <input type="submit" class="btn btn-outline-success" value="Find" name="search">
  </div>
</div>
<?php
echo "</div>";
    if (isset($_GET["search"])) {
        $sql2 = "SELECT * FROM store WHERE `accepted`='1' AND `type`='$type' AND (`name` LIKE '%" . $search . "%') ORDER BY ID DESC";
    } else {
        $sql2 = "SELECT * FROM store WHERE accepted='1' AND `type`='$type' ORDER BY ID DESC";
    }
    if (isset($_GET["search"])) {
        $sql2 = "SELECT * FROM store WHERE `accepted`='1' AND (`name` LIKE '%" . $search . "%') ORDER BY ID DESC";
    } else {
        $sql2 = "SELECT * FROM store WHERE accepted='1' ORDER BY ID DESC";
    }
echo "<div class='row'>";
$result = $conn->query($sql2);
$rand = rand(1000,1000000);
if ($result->num_rows > 0) {
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        if ($row['collectable'] == 0) { //if the item is NOT collectible 
            if ($row['accepted'] == 1) { //if the item IS onsale
                $sale = $conn->query("SELECT * FROM inventory WHERE ItemID='" . $row["id"] . "'");
                $sales = mysqli_num_rows($sale);
                    echo "<div class='col-md-3 text-center' style='margin-bottom: 10px;'id='itemCard'><div class='card'><div class='card-body'>";
                    echo "<img class='img-responsive' style='max-height: 10031px;max-width: 100px;margin:0 auto;float: none;' src='https://tetrimus.xyz/storage/store_storage/thumbnails/".$row['id'].".png?r=$rand'><a href='https://tetrimus.xyz/store/item.php?id=".$row['id']."'><a href='http://tetrimus.xyz/store/item.php?id=".$row['id']."'><div style='overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'>".$row['name']."</div></a><div style='height: 5px;'></div>";if ($row['price'] == 0) { echo "Free ";}else{if($row['payment'] == "coins"){ echo '<div style="color: #e6b13f;"><i class="fa fa-circle" aria-hidden="true"></i> '.$row['price'].'</div>';}if($row['payment'] == "tokens"){ echo '<div style="color: #2def51;"><i class="fa fa-certificate" aria-hidden="true"></i> '.$row['price'].'</div>';}}echo "<div style='height: 5px;'></div>";if($row['rare'] == 1) {echo "<div style='color: #DAA520;'>Rare</div>";}echo "</div></div></div>";
                
            } //if the item is NOT onsale
                if ($row['accepted'] == 0) {
                $sale = $conn->query("SELECT * FROM inventory WHERE ItemID='" . $row["id"] . "'");
                $sales = mysqli_num_rows($sale);
                echo "<div class='col-md-3 text-center' style='margin-left: 61px;margin-top:10px;margin-bottom:10px;'><center><img class='img-responsive' style='width: 150px;height: 150px;' class='rounded float-left' src='../storage/store_storage/thumbnails/".$row['id'].".png?r=$RefreshRate'><a href='http://tetrimus.xyz/store/item.php?id=".$row['id']."'><div style='overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'>".$row['name']."</div></a><div style='height: 5px;'></div>Off-Sale</div>";

            }
        }
    }
}


$conn->close();
echo "</div>";
echo "</div>";
echo "</div>";
?>
</body>
</html>