<?php
include '../func/connect.php';

if(isset($_POST['upload'])){
    $name = strip_tags(mysqli_real_escape_string($conn, $_POST['name']));
    $description = strip_tags(mysqli_real_escape_string($conn, $_POST['description']));
	$coins = mysqli_real_escape_string($conn,$_POST['coins']);
	
	if(isset($_FILES['image'])) {
		$imgName = $_FILES['image']['name'];
		$imgSize = $_FILES['image']['size'];
		$imgTmp = $_FILES['image']['tmp_name'];
		$imgType = $_FILES['image']['type'];
		$isImage = getimagesize($imgTmp);
	}

    if(substr($name,-1) == " " || substr($name,0,1) == " ") {
        $error = "<br><div class='alert alert-danger' role='alert'>You can't have spaces at the beginning of your name!</div>";
    }
    if(strlen($name) < 3 || strlen($name) > 25) {
        $error = "<br><div class='alert alert-danger' role='alert'>The name needs to be between 3 & 25 Characters!</div>";
    }
    if(substr($description,-1) == " " || substr($description,0,1) == " ") {
        $error = "<br><div class='alert alert-danger' role='alert'>You can't have spaces at the beginning of your description!</div>";
    }
    if(strlen($description) < 3 || strlen($description) > 150) {
        $error = "<br><div class='alert alert-danger' role='alert'>The description needs to be between 3 & 25 Characters!</div>";
    }
    
    if(empty($error)){
    if(!empty($name) && !empty($description)) {
	$createitemquery = "INSERT INTO `store`(name, creator_id, description, type, payment, price, rare, quantity, sale, accepted, object, texture) VALUES('$name','$user->id','$description','shirt','coins','$coins','0','0','1','0','','$imgName')";
	$new = $conn->query($createitemquery);
    $item_id = $conn->insert_id;
    move_uploaded_file($imgTmp,"../storage/store_storage/shirts/".$item_id.".png");
    header("Location: ../store/item.php?id=".$item_id."");
    
    }
}
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Store | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
<body style="overflow-x: hidden;">
<?php include '../func/navbar.php'; ?>   
<div class="contanier">
    <div class="row">
        <div class="col-md-8" style="margin: 0 auto;">
            <?php
        if(!empty($error)){
            echo $error;
        }
        ?>
            <div class="card">
                <div class="card-body">
                    <form enctype="multipart/form-data" method="post" action="">
                    <input type="text" placeholder="Name" name="name" style="width: 50%;" class="form-control">
                    
                    <div style="height: 10px"></div>
                    <textarea style="width: 50%;height: 200px;" name="description" placeholder="Description" class="form-control"></textarea>
                    <div style="height: 10px"></div>
 <div style="height: 10px"></div>Template<input class="form-control-file" id="exampleFormControlFile1" type="file" name="image">
    <div style="height: 10px"></div>
    
   
    <input class="form-control" style="width:50%;" type="number" min="1" name="coins" placeholder="0 coins">
    <div style="height: 10px"></div>
    <a href="http://tetrimus.xyz/store/create/template">
        <button class="btn btn-primary">Template</button></a>
                    <input type="submit" style="background-color: #1fc111;border-color: #1fc112;" class="btn btn-success" name="upload" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>