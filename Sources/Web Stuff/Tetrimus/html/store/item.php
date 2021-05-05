<?php
$RefreshRate = rand(0,100000);
include ('../func/connect.php');
include ('../func/navbar.php');


$id = trim($conn->real_escape_string($_GET['id']));

if(!$id || !is_numeric($id)) {
    header("Location: item.php?id=1");
    die();
}

$buy = trim($conn->real_escape_string($_GET['buy']));
$Own = $conn->query("SELECT * FROM inventory WHERE user_id='$user->id' AND item_id='$id'");
$Owned = mysqli_num_rows($Own);
$getItemInfo = $conn->query("SELECT * FROM store WHERE id='$id'");
$item = mysqli_fetch_object($getItemInfo);
$sale = $conn->query("SELECT * FROM `inventory` WHERE `item_id`='$id'");
$sales = mysqli_num_rows($sale);
$amountLeft = $item->quantity - $sales;
$creator = $conn->query("SELECT * FROM `users` WHERE `id`='$item->creator_id'");
$creator = mysqli_fetch_object($creator);

?>
<head>    
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo "$item->name"; ?> | Tetrimus</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<?php
include('../func/navbar00.php');
$inc = +1;

echo "<div class='container'>	
	<div class='row'>";

if(isset($_POST['buy'])) {
if($Owned == 0){
	if ($item->sale == 1) {
		if ($item->payment == "tokens") {
			if ($item->price <= $user->tokens) {
				$conn->query("UPDATE users SET tokens=tokens-'$item->price' WHERE username='$user->username'");
				if ($item->rare == 0) {
					$conn->query("INSERT INTO inventory(user_id,name,item_id,serialnum,rare,type) VALUES('$user->id','$item->name','$item->id','0','0','$item->type')");
				echo "<div class='col-md-10' style='margin: 0px auto; float: none;'><div class='alert alert-success'>You have successfully purchased this item.</div></div>
				";
				}
				else {
					$serialNumber = $item->quantity - $sales;
					$conn->query("INSERT INTO inventory(user_id,name,item_id,serialnum,rare,type) VALUES('$user->id','$item->name','$item->id','$SerialNumber','1','$item->Type')");
				echo "<div class='col-md-10' style='margin: 0px auto; float: none;'><div class='alert alert-success'>You have successfully purchased this item.</div></div>
				";
				}
			}
		}

//the one for coins has not been edited to work correctly
		if ($item->payment == "coins") {
			if ($item->price <= $user->coins) {
				$conn->query("UPDATE users SET coins=coins-'$item->price' WHERE username='$user->username'");
				if ($item->rare == 0) {
					$conn->query("INSERT INTO inventory(user_id,name,item_id,serialnum,rare,type) VALUES('$user->id','$item->name','$item->id','0','0','$item->type')");
				echo "<div class='col-md-10' style='margin: 0px auto; float: none;'><div class='alert alert-success'>You have successfully purchased this item.</div></div>
				";
				}
				else {
					$SerialNumber = $item->quantity - sales;
					$conn->query("INSERT INTO inventory(user_id,name,item_id,serialnum,rare,type) VALUES('$user->id','$item->name','$item->id','$SerialNumber','1','$item->type')");
				echo "<div class='col-md-10' style='margin: 0px auto; float: none;'><div class='alert alert-success'>You have successfully purchased this item.</div></div>
				";
				}
			}
		}
	}
}
//$conn->query("UPDATE `store` SET `sale` = sale + 1 WHERE `id` = '$id'");
}

	echo"
		<div class='col-md-10' style='margin: 0px auto; float: none;'>
			<div class='card'>
			    <div class='card-body'>
			    ";
                    echo "
                    <img class='rounded float-left' src='../images/s".$item->id.".png?r=7' style='width: 250px;height: 250px;'>
					<div style='font-size:25px;'>$item->name</div>
					<div style='height: 10px;'></div>
					<div style='color:#aaa;font-size:16px;'>$item->description</div>
					<div style='height: 10px;'></div>
					<div class='row'>
					<div class='col-md-2'>
					<div style='color:#aaa;font-size:16px;'>Price:</div>";
					if($item->payment == "coins"){echo "".$item->price." Coin(s)";}else{
					echo "".$item->price." Token(s)";
					}
					
					echo "
					</div>
					<div class='col-md-2'>
					<div style='color:#aaa;font-size:16px;'>Creator:</div>
					$creator->username
					</div>
					";
					if($item->rare == 1){
						echo "<div class='col-md-2'>
					<div style='color:#aaa;font-size:16px;'>Quantity:</div>
					$item->quantity
					</div>";
					}
					echo "
					<div class='col-md-2'>
					<div style='color:#aaa;font-size:16px;'>Sales:</div>
					$sales
					</div>
					</div>
					<div style='height: 10px;'></div>
					<form method='post' action=''>
					<input type='submit' value='Buy' name='buy' class='btn btn-outline-success'>
					</form>
		        </div>
		    </div>
	    </div>
	    ";
	    ?>
	    
	    <div class='col-md-10' style='margin: 0px auto; float: none;margin-top: 15px;'>
			<div class='card'>
			    <div class='card-body'>
				<?php if($loggedIn){
					echo"
				
			    <form method='POST' action=''>
				<textarea placeholder='Comment' style='height: 100px;' class='form-control' name='comment'></textarea>
				<div style='height: 15px;'></div>
				<input type='submit' class='btn btn-outline-success' name='create'>
				</form>
				";}
				$sql2 = "SELECT * FROM itemComments WHERE itemID = '$id' ORDER BY time DESC";

				$result = $conn->query($sql2);
				if ($result->num_rows > 0) {
    				while($row = $result->fetch_assoc()) {
				echo "
				<div style='height: 15px;'></div>
				<div class='card'>
				<div class='card-body'>
				<span style='float:left;'>
				<a href='/profile.php?id=".$row['userID']."'>
				<img src='../images/".$row['userID'].".png?r=$rand.' height='100' width='100'><br> ".$row['username']."
				</a>
				</span>
				<br>
				Posted: ".$row['date']."
				<br>
				   ".$row['post']."
				</div>
				</div>
				";
				}
				}
				
				if(isset($_POST['create'])) {
$comment = strip_tags($_POST['comment']);
$comment = trim($conn->real_escape_string($comment));
$comment = htmlentities($comment);
if(!empty($comment)){
	$time = time();
	$conn->query("INSERT INTO `itemComments`(`username`,`userID`,`itemID`,`post`,`time`) VALUES('$user->username','$user->id','$id','$comment','$time')"); //('$user->$username','$user->id','$id','$comment','0')"); ORDER by id DESC
	echo"CREATED!";
	}
}
				echo "
		        </div>
		    </div>
	    </div>
	    
    </div>
</div>
";

?>
<?php include '../func/footer.php'; ?>
