<?php
include('../func/connect.php');
?>
<h6>This Page is undergoing heavy maintenance.</h6>
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
if(!$loggedIn){
	header("Location: ../clubs");
}
?>
<div class='container'>
  <div class='content'>
	<div style="margin:0 auto;text-align: center;">
	<h4>Create Club</h4>

<?php 
if(isset($_POST["submit"])) {
$clubName = htmlentities($_POST['clubName']);
$clubCreator = '$user->username';
$clubImage = htmlentities($_POST['clubImage']);
$clubDesc = htmlentities($_POST['clubDesc']);

//remove later.
    //if(empty($clubName) || empty($cubImage) || empty($clubDesc)) {
		echo"<div class='alert alert-success'>$clubName has been created!</div>";
		$conn->query("INSERT INTO `clubs`(`creator_name`, `club_name`, `club_members`, `club_description`, `club_icon`, `approved`, `role1`, `role2`, `role3`)
 VALUES('1', '1', '0', '1', '1', '1', 'Member', 'Admin', 'Owner')");
 
 $conn->query("INSERT INTO `clubs`(`creator_name`, `club_name`, `club_members`, `club_description`, `club_icon`, `approved`, `role1`, `role2`, `role3`)
 VALUES('$user->username', '$clubName', '0', '$clubDesc', '$clubImage', '0', 'Member', 'Admin', 'Owner')");


}else{
	echo"You have empty fields!";
}

?>
	
	<div class="container">
  <div class="row">
    <div class="col-md-10" style="margin: 0px auto; float:none;">
     
          Create a club
          <div style="height: 15px;"></div>
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label>Club name</label>
              <input type="text" class="form-control" placeholder="Club name" name="clubName">
              <small class="form-text text-muted">Make a club with a very cool name! Be original!</small>
            </div>
            <label>Club logo</label><br>

              <input type="file" name="clubImage">
           <small class="form-text text-muted">Choose a good club logo this will represent your club.</small>
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="clubDesc" placeholder="Club description" rows="5"></textarea>
            <small class="form-text text-muted">This will describe your club.</small>
          </div>
                           <button type="submit" class="btn btn-primary" name="submit">Create</button>
        </form>
        </div>
        </div>
      </div>
    </div>
  </div>
	
	</div>
	
</div>
</div>
