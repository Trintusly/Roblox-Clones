<?php
include '../func/connect.php';
if($loggedIn){
}else{
    header("Location: ../");
}
$RefreshRate = rand(0,1000);
$id = trim($conn->real_escape_string($_GET['id']));

if(!$id || !is_numeric($id)) {
    header("Location: $user->username");
    die();
}else{
    $checkExists = $conn->query("SELECT * FROM `users` WHERE `username`='$user->username'");
    $exists = mysqli_num_rows($checkExists);
    if($exists == 0) {
        header("Location: $user->username");
        die();	
    }
}

$select = $conn->query("SELECT * FROM users WHERE id='".$id."'");
$fetchuser = mysqli_fetch_object($select);

if (!$fetchuser) { 
    header("Location: ../");
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chat | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/488139976169488395/493220149575548938/tetrimus.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body>
<?php include '../func/navbar.php'; ?>
