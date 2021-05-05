<?php
include("../func/connect.php");
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Create | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=526556">
</head>
<body>

<head>
  <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  
<title>Tetrimus</title>
  
<meta name="description" content="Tetrimus is a new up and coming sandbox game. Join today for free!">
  
<meta name="author" content="Tetrimus">
  <link rel="stylesheet" type="text/css" href="../css/darkthem">
  
<link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png">

<link rel="shortcut icon" type="image/png" href="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png"/>

  
 <link rel="icon" href="https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png">
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-9372911432095214",
    enable_page_level_ads: true
  });
</script>
</head>
<?php
include("../func/navbar.php");
?>
<div class="container">
  <div class="row">
  <div class="col-md-10" style="margin: 0px auto;float: none;">
  <div class="card">
  <div class="card-body">
 <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Realms</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Shirts</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Pants</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="club-tab" data-toggle="tab" href="#club" role="tab" aria-controls="contact" aria-selected="false">Clubs</a>
  </li>
</ul>
</div>
</div>
<div style="height: 15px;"></div>
</div>
<div class="col-md-10" style="margin: 0px auto;float: none;">
  <div class="card">
  <div class="card-body">
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><div class="col-md-3" style="margin-bottom: 15px;"></center></div></div></div></div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><?php if(isset($_POST['upload'])){
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
<
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
                    <input type="submit" style="background-color: #1fc111;border-color: #1fc112;" class="btn btn-success" name="upload" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html></div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"></div>
  <div class="tab-pane fade" id="club" role="tabpanel" aria-labelledby="club-tab"><div class='container'>
  <div class='content'>
	<div style="margin:0 auto;text-align: center;">
	<h4>Create Club</h4>

<?php 
if(isset($_POST["submit"])) {
$clubName = htmlentities($_POST['clubName']);
$clubCreator = htmlentities($_POST['creator_name']);
$clubImage = htmlentities($_POST['clubImage']);
$clubDesc = htmlentities($_POST['clubDesc']);

//remove later.
    //if(empty($clubName) || empty($cubImage) || empty($clubDesc)) {
		echo"<div class='alert alert-success'>$clubName has been created!</div>";
		$conn->query("INSERT INTO `clubs`(`creator_name`, `club_name`, `club_members`, `club_description`, `club_icon` `approved`, `role1`, `role2`, `role3`)
 VALUES('1', '1', '0', '1', '1', '1', 'Member', 'Admin', 'Owner')");
 
 //$conn->query("INSERT INTO `clubs`(`creator_name`, `club_name`, `club_members`, `club_description`, `club_icon` `approved`, `role1`, `role2`, `role3`)
// VALUES('$user->username', '$clubName', '0', '$clubDesc', '$clubImage', '0', 'Member', 'Admin', 'Owner')");

/*
}else{
	echo"You have empty fields!";
}
*/
}
?>
	
	<form action="#" method="post">
    Club name:
    <input type="text" name="clubName" id="#" placeholder="Club name"><br>
    Club image: <input name="clubImage" id="#" type="file"><br>
    Club description: <input name="clubDesc" id="#" type="name" placeholder="Club description"><br>
    <input class="btn btn-success" value="Upload Club" name="submit" type="submit">
</form>
	
	</div>
	
</div>
</div>
</div>
      
      
      
      
</div>
  </div>
</div>
</div>
</div>
</div>

</body>
</html>