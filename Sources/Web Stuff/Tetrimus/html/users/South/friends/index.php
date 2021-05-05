<?php
include '../../../func/connect.php';
include '../../../func/navba.php';
$RefreshRate = rand(0,100000);

include '../../../../func/filter.php';
$id = trim($conn->real_escape_string($_GET['id']));

/*
Hi, this is noynac aka Sushi!
I'll be adding friends here

Sorry if I get some stuff wrong, I've been doing a lot of PDO recently 
rather than MySQLi so I've gotten used to using prepared statements.

Anyways, if you have any questions about it just ask me!
*/

/*
I added this during testing but now I'm done so it's not needed.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

//start friends 

$displayAdd = false;
$displayRemove = false;
$displayPending = false;
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Friends | Tetrimus</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../../style.css?=854204">
</head>
<?php
include("../../../func/navbar.php");
?>
 <div style="height: 15px;"></div>
         <div class="card">
            <div class="card-body">
            <div style="border-bottom: 1px solid #eee;">
             <font style="font-size: 20px;"><strong>South's</strong> Friends</font>
            </div>
            <div style="height: 15px;"></div>
            <div class="row">
              <div class="row">
             
              
            <div>
            
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../../../images/321.png" width="120px"></center>
                    <center><a href="../profile.php?id=321" "="">sushii</a></center>
                    </div>
                
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../../../images/318.png" width="120px"></center>
                    <center><a href="../profile.php?id=318" "="">Baldi</a></center>
                    </div>
                
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../../../images/22.png" width="120px"></center>
                    <center><a href="../profile.php?id=22" "="">diam</a></center>
                    </div>
                
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../../../images/9.png" width="120px"></center>
                    <center><a href="../profile.php?id=9" "="">Layout</a></center>
                    </div>
                
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../../../images/21.png" width="120px"></center>
                    <center><a href="../profile.php?id=21" "="">plainoldbread</a></center>
                    </div>
                
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../../../images/85.png" width="120px"></center>
                    <center><a href="../profile.php?id=85" "="">SpearitBlackwell</a></center>
                    </div>
                
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../../../images/167.png" width="120px"></center>
                    <center><a href="../profile.php?id=167" "="">Pancake Killer</a></center>
                    </div>
                
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../../../images/5.png" width="120px"></center>
                    <center><a href="../profile.php?id=5" "="">dox</a></center>
                    </div>
                
                    <div style="width:150px;display:inline-block;">
                    <center><img src="../../../images/14.png" width="120px"></center>
                    <center><a href="../profile.php?id=14" "="">Cosmic</a></center>
                    </div>
                    </div>
          </div>
              </div>
  
</div>            
            </div></div>

