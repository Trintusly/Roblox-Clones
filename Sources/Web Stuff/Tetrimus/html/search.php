<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Users | Tetrimus</title>
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
include('func/connect.php');
include('func/filter.php');
include('func/navbar.php');
if($loggedIn){
}else{
	header("Location: ../");
}
?>
<body>
<div class="container">
<div class="row">
  <div class="col-md-10" style="float:none;margin: 0px auto;">
  <div class="card">
    <div class='card-body'>

<form action='../search.php' method='GET' role="search">
  <div class="input-group">
        <input type="text" class="form-control" name="query" placeholder="Search">
  <div class="input-group-append">
    <input type="submit" class="btn btn-outline-success" value="Find">
  </div>
</div>
</form>
<?php

    $query = strip_tags($_GET['query']);
    $query = trim($conn->real_escape_string($query));
    $query = htmlentities($query);  
    $query = filter($query);     
$min_length = 1;
     
if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
          
    $raw_results = $conn->query("SELECT * FROM users
            WHERE (`username` LIKE '%".$query."%') OR (`description` LIKE '%".$query."%')") or die(mysqli_error());
			
    if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
             
    while($results = mysqli_fetch_array($raw_results)){
             
    echo "<div class='card' style='margin-bottom: 10px;'><div class='card-body'>
<a href='../profile.php?id=".$results['id']."'>".$results['username']."
"; 
echo"
</a><br>".$results['description']."<div style='height: 10px;'></div></div></div>";
            }
        }
        else{ 
            echo "<center>No results</center>";
        }
         
    }
    else{ // if query length is less than minimum
        echo "<center>The minimum character length is ".$min_length." </center> ";
    }
	
?>
</div>
</div>
</div>
</div>
</div>
</body>