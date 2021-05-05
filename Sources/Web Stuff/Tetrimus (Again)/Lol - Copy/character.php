<?php
include 'func/connect.php';
if (!$loggedIn) {
    header("Location: /login");
}
?>



<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Character | Tetrimus</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css">
<link rel="icon" type="image/png" href="https://tetrimus.com/logo.png"><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<style>
html, body {
    max-width: 100%;
    overflow-x: hidden;
    overflow-x: hidden;
}
</style>
</head>
<?php
include 'func/navbar.php';
?>
<body style="overflow: hidden;" onload="render()">
    <div class="container">
<div class="row">
<div style="margin: 0px auto;float:none;" class="col-md-4">
    <div class="card">
<div class="card-body">
<?php
if ($loggedin) {
    $rand = rand(0, 1000);
    echo '
<script>


setTimeout(function(){
   window.location.reload(1);
}, 500000);
window.onload = function() {
    var image = document.getElementById("avatar");

    function updateImage() {
        image.src = image.src + Math.floor((Math.random() * 100) + 1);
    }

    setInterval(updateImage, 1500);
}
</script>
';
}
$rand = rand(1000, 10000000000000);
//purge functionality v v v v v
/*
$purge = trim($conn->real_escape_string($_POST['purge']));
if ($purge) {
$conn->query("UPDATE users SET Hat='none' WHERE id='$user->id'");
$conn->query("UPDATE users SET Hat2='none' WHERE id='$user->id'");
}
*/
?>

<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script>
      function render() {
        
        $('#avatar').html( '<img src="https://tetrimus.com/images/loading.gif" style="width:300px;height:300px;border-top: 30px solid #fff;border-bottom: 30px solid #fff;">' );
        
        $.get ('render.php', function ( result ) {
            
            if (result != "false") {
                document.getElementById("avatar").innerHTML = '<img src="https://tetrimus.com/images/' + result + '" style="width:300px">';
            } else {
                $.get ('render.php', function ( result ) {
                    document.getElementById("avatar").innerHTML = '<h4>There seems to be an issue! Please try again!</h4><img src="https://tetrimus.com/images/'+result+'.png" style="width:300px">';
                });
            }
            
        });
        
      };
</script>
<?php
echo '
<script>
setTimeout(function() {
                      document.getElementById("avatarr").setAttribute("src", "https://tetrimus.com/images/' . $user->id . '.png?r=' . $rand . '");
                  }, 800);
</script>
';
echo "
<center>
<div id='avatar'><img src='https://tetrimus.com/images/14.png?r=$rand' style='width:300px'></div>
<br>
</center>
";
?>
<center>
<button class="btn btn-outline-success btn-sm" onclick="will do l8r">Refresh</button>

<button class="btn btn-outline-danger btn-sm" name="purge">Purge</button>
</center>
    </div>
</div>
<div style="height: 25px;"></div>
<div class="card">
<div class="card-body">
<br>
<h5>Currently wearing</h5>
Hat one: <?php
echo $user->Hat;
?><br>
Hat two: <?php
echo $user->Hat2;
?><br>
</div>
</div>
</div>
    <div class="col-md-8" style="margin:0 auto;float:none;">
<div class="card-header">
<ul class="nav nav-tabs card-header-tabs flex-wrap">

<li class="nav-item"><a href="#" style="#" class="nav-link">Show All</a></li>
<li class="nav-item"><a href="?type=Hat" style="#" class="option1 nav-link">Hats</a></li>
<li class="nav-item"><a href="?type=Shirt" style="#" class="option2 nav-link">Shirts</a></li>
<li class="nav-item"><a href="?type=Shirt" style="#" class="option2 nav-link">Pants</a></li>
<li class="nav-item"><a href="?type=Gear" style="#" class="option3 nav-link">Gears</a></li>
<li class="nav-item"><a href="?type=Face" style="#" class="option4 nav-link">Faces</a></li>
</ul>
</div>
<div class="card" style="padding: 15px;">


<?php
$datatable = "inventory";
$results_per_page = 4;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
;
$start_from = ($page - 1) * $results_per_page;
$type = trim($conn->real_escape_string($_GET['type']));
if ($type) {
    $sql2 = "SELECT * FROM " . $datatable . " WHERE user_id='" . $user->id . "' AND Type='$type' ORDER BY ID DESC LIMIT $start_from, " . $results_per_page;
} else {
    $sql2 = "SELECT * FROM " . $datatable . " WHERE user_id='" . $user->id . "' ORDER BY ID DESC LIMIT $start_from, " . $results_per_page;
}
$result = $conn->query($sql2);
if ($result->num_rows > 0) {

    //------------------------------------------------- start wear and remove ------------------------------------------------------------------//
    $changeItem = trim($conn->real_escape_string($_POST['changeItem']));
    if ($changeItem) {
        $ItemID = trim($conn->real_escape_string($_POST['ItemID']));
        $ItemType = trim($conn->real_escape_string($_POST['ItemType']));
        $action = trim($conn->real_escape_string($_POST['action']));
        
        $FindItem = $conn->query("SELECT * FROM `store` WHERE `id`='" . $ItemID . "'");
        $FI = mysqli_fetch_object($FindItem);
        $IsOwned = $conn->query("SELECT * FROM `inventory` WHERE `item_id`='" . $ItemID . "' AND `user_id`='" . $user->id . "'");
        $ownedItem = mysqli_num_rows($IsOwned);
        
        if ($ownedItem != 0) {
            switch($ItemType) {
                case "Hat":
                    if($action == "wear") {
                        if ($user->Hat == "none") {
                            $conn->query("UPDATE `users` SET `Hat`='$FI->texture' WHERE `id`='$user->id'");
                        } else if ($user->Hat != $FI->texture) {
                            $conn->query("UPDATE `users` SET `Hat2`='$FI->texture' WHERE `id`='$user->id'");
                        }
                    }else{
                        if($user->Hat == $FI->texture) {
                            $conn->query("UPDATE `users` SET `Hat`='none' WHERE `id`='$user->id'");
                        }else if ($user->Hat2 == $FI->texture) {
                            $conn->query("UPDATE `users` SET `Hat2`='none' WHERE `id`='$user->id'");                
                        }
                    }
                    break;
                case "Gear":
                    if($action == "wear") {
                        $conn->query("UPDATE `users` SET `Gear`='$FI->texture' WHERE `id`='$user->id'");
                    }else{
                        $conn->query("UPDATE `users` SET `Gear`='none' WHERE `id`='$user->id'");
                    }
                    break;
                case "Shirt":
                    if($action == "wear") {
                        $conn->query("UPDATE `users` SET `shirt`='$FI->texture' WHERE `id`='$user->id'");
                    }else{
                        $conn->query("UPDATE `users` SET `shirt`='none' WHERE `id`='$user->id'");
                    }
                    break;
                case "Face":
                    if($action == "wear") {
                        $conn->query("UPDATE `users` SET `Face`='$FI->texture' WHERE `id`='$user->id'");
                    }else{
                        $conn->query("UPDATE `users` SET `Face`='Face' WHERE `id`='$user->id'");
                    }
                    break;
            }
	 echo '<meta http-equiv="refresh" content="0">';
        }
    }
    //------------------------------------------------- end wear and remove ------------------------------------------------------------------//

    echo "<div class='row'>";
    $rand = rand(0, 1000);
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        $fetchstoreitem = $conn->query("SELECT * FROM store WHERE id='" . $row['item_id'] . "'");
        $storeitem = mysqli_fetch_object($fetchstoreitem);
        if ($storeitem->Collectible == 0) { //if the item is NOT collectible 
            echo " 
<div class='col-md-3'>
        <div class='card'>
        <div class='card-body'>
         <a href='../store/item.php?id=$storeitem->id'>
            <img style='width: 130px;height: 130px;margin-top: 10px;' src='../images/s" . $storeitem->id . ".png?r=8' alt='$storeitem->name'>
          </a>";
            if ($storeitem->texture == $user->Hat || $storeitem->texture == $user->Hat2 || $storeitem->texture == $user->Face || $storeitem->texture == $user->Gear) {
                echo "
                    <center>
                      <form action='' method='POST'>
                        <input type='hidden' name='ItemID' value='$storeitem->id'>
			  <input type='hidden' name='ItemType' value='$storeitem->type'>
			  <input type='hidden' name='action' value='remove'>
                        <div id='choice'><input onclick='remove()' class='btn btn-outline-danger' type='submit' value='Remove' name='changeItem'></div>
                      </form>
                      </center>";
            } else {
                echo "
                    <center>
                    <form action='' method='POST'>
                        <input type='hidden' name='ItemID' value='$storeitem->id'>
			  <input type='hidden' name='ItemType' value='$storeitem->type'>
			  <input type='hidden' name='action' value='wear'>
                        <div id='choice'><input onclick='wear()' class='btn btn-outline-success' type='submit' value='Wear' name='changeItem'></div>
                      </form>
                      </center>";
            }
            echo "</div></div></div>";
        } else {
            $rand = rand(0, 1000);
            echo "
<div class='col-md-3'>
        <div class='card'>
        <div class='card-body'>
          <a href='../store/item.php?id=$storeitem->id'>
            <img style='width: 130px;height: 130px;margin-top: 10px;' src='../images/items/$storeitem->id.png' alt='$storeitem->name'>
          </a><br>
                    <form action='' method='POST'>
                        <input type='hidden' name='ItemID' value='$storeitem->id'>
                        <input class='btn btn-outline-success' type='submit' value='Wear' name='wear'>
                      </form>
                      <form action='' method='POST'>
                        <input type='hidden' name='ItemID' value='$storeitem->id'>
                        <input class='btn btn-outline-danger' type='submit' value='Remove' name='remove'>
           </form></div></div></div>";
        }
        if ($i < 3)
            $i++; //if it is greater than the number, create a new page
        else {
            echo "<div style='clear: both;'></div>";
            $i = 1;
        }
    }
} else {
    echo "You have no items! <a href='/store'>Buy some</a>";
}
echo "<br>";
if ($type) {
    $TotalItems = $conn->query("SELECT * FROM " . $datatable . " WHERE user_id='" . $user->id . "' AND Type='$type'");
    $TotalItems = mysqli_num_rows($TotalItems);
} else {
    $TotalItems = $conn->query("SELECT * FROM " . $datatable . " WHERE user_id='" . $user->id . "'");
    $TotalItems = mysqli_num_rows($TotalItems);
}
$total_pages = $TotalItems / $results_per_page;
$back = $page - 1;
$next = $page + 1;
if ($type) {
    if ($page != 1) {
        echo "<a class='btn btn-default' href='?type=$type&page=$back'><i class='fa fa-arrow-left'></i> Back</a>";
    }
    if ($page < $total_pages) {
        echo "<a class='btn btn-default' href='?type=$type&page=$next'>Next <i class='fa fa-arrow-right'></i></a>";
    }
} else {
    if ($page != 1) {
        echo "<a class='btn btn-default' href='?page=$back'><i class='fa fa-arrow-left'></i> Back</a>";
    }
    if ($page < $total_pages) {
        echo "<a class='btn btn-default' href='?page=$next'>Next <i class='fa fa-arrow-right'></i></a>";
    }
}
$r = trim($conn->real_escape_string($_GET['r']));
if ($user->power != 0) {
    if (!$r) {
        header("Location: ../character.php?r=" . $user->id . "&type=" . $type . "&page=" . $page . "");
    }
} else {
    if (!$r) {
        header("Location: ../character.php?r=" . $user->id . "&type=" . $type . "&page=" . $page . "");
    } else if ($r != $user->id) {
        header("Location: ../character.php?r=" . $user->id . "&type=" . $type . "&page=" . $page . "");
    }
}
//$conn->close();
?>
</div>
</div>
<?php
function GetHex($rgb) {
    $rgbColor = str_replace("/255", "", "$rgb");
    $RGBexplode = explode(",", $rgbColor, 3);
    $HEX = sprintf("#%02x%02x%02x", $RGBexplode[0], $RGBexplode[1], $RGBexplode[2]);
    return $HEX;
}
function GetRgb($hex) {
    list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
    $RGB = "$r/255,$g/255,$b/255";
    return $RGB;
}
$update = trim($conn->real_escape_string($_POST['updateColor']));
if ($update) {
    $bodyPart = trim($conn->real_escape_string($_POST['bodyPart']));
    $ChangeColor = trim($conn->real_escape_string($_POST['ChangeColor']));
    $color = GetRgb($ChangeColor);
    switch ($bodyPart) {
        case "head":
            $conn->query("UPDATE `users` SET `HeadColor`='$color' WHERE `id`='" . $user->id . "'");
            echo "<script>window.location = '../character.php?r=" . $user->id . "&type=" . $type . "&page=" . $page . "&l=1'</script>";
            die();
            break;
        case "torso":
            $conn->query("UPDATE `users` SET `TorsoColor`='$color' WHERE `id`='" . $user->id . "'");
            echo "<script>window.location = '../character.php?r=" . $user->id . "&type=" . $type . "&page=" . $page . "&l=1'</script>";
            die();
            break;
        case "rightArm":
            $conn->query("UPDATE `users` SET `RightArmColor`='$color' WHERE `id`='" . $user->id . "'");
            echo "<script>window.location = '../character.php?r=" . $user->id . "&type=" . $type . "&page=" . $page . "&l=1'</script>";
            die();
            break;
        case "leftArm":
            $conn->query("UPDATE `users` SET `LeftArmColor`='$color' WHERE `id`='" . $user->id . "'");
            echo "<script>window.location = '../character.php?r=" . $user->id . "&type=" . $type . "&page=" . $page . "&l=1'</script>";
            die();
            break;
        case "rightLeg":
            $conn->query("UPDATE `users` SET `RightLegColor`='$color' WHERE `id`='" . $user->id . "'");
            echo "<script>window.location = '../character.php?r=" . $user->id . "&type=" . $type . "&page=" . $page . "&l=1'</script>";
            die();
            break;
        case "leftLeg":
            $conn->query("UPDATE `users` SET `LeftLegColor`='$color' WHERE `id`='" . $user->id . "'");
            echo "<script>window.location = '../character.php?r=" . $user->id . "&type=" . $type . "&page=" . $page . "&l=1'</script>";
            die();
            break;
    }
}
?>
<div style="height: 25px;"></div>
<center><h5>Avatar Colors</h5></center>
<div class="card">
<div class='card-header'>
                   <ul id='myTab' class='nav nav-tabs card-header-tabs flex-wraps'>
                        
                        <li class="nav-item"><a class="option nav-link" href='#service-one' data-toggle='tab'>Head</a></li>&nbsp;
                        <li class="nav-item"><a class="option nav-link" href='#service-two' data-toggle='tab'>Torso</a></li>&nbsp;
                        <li class="nav-item"><a class="option nav-link" href='#service-three' data-toggle='tab'>Right Arm</a></li>&nbsp;
                        <li class="nav-item"><a class="option nav-link" href='#service-four' data-toggle='tab'>Left Arm</a></li>&nbsp;
                        <li class="nav-item"><a class="option nav-link" href='#service-five' data-toggle='tab'>Right Leg</a></li>&nbsp;
                        <li class="nav-item"><a class="option nav-link" href='#service-six' data-toggle='tab'>Left Leg</a></li>
                        
                    </ul>
</div>

<div class="card-body">
                <div id='myTabContent' class='tab-content'>
                        <div class='tab-pane fade in active' id='service-one'>
                        
<?php
$HeadHex = getHex($user->HeadColor);
$TorsoHex = getHex($user->TorsoColor);
$RightArmHex = getHex($user->RightArmColor);
$LeftArmHex = getHex($user->LeftArmColor);
$RightLegHex = getHex($user->RightLegColor);
$LeftLegHex = getHex($user->LeftLegColor);
?>
<style>
.input-color-container {
  position: relative;
  overflow: hidden;
  width: 40px;
  height: 40px;
  border: solid 2px #ddd;
  border-radius: 40px;
}

.input-color {
  position: absolute;
  right: -8px;
  top: -8px;
  width: 56px;
  height: 56px;
  border: none;
}
</style>

<section class='container product-info'>
    <form action='' method='POST'>
        Head Color: <input type="hidden" name='bodyPart' value='head'><div class='input-color-container'><input class='input-color' type="color" name='ChangeColor' value='<?php
            echo $HeadHex;
            ?>'></div>
        <input class='btn btn-success' type='submit' value='Submit' name='updateColor'>
    </form>
</section>
</div>
<div class='tab-pane fade' id='service-two'>
    <section class='container'>
        <form action='' method='POST'>
            Torso Color: <input type="hidden" name='bodyPart' value='torso'><div class='input-color-container'><input class='input-color' type="color" name='ChangeColor' value='<?php
                echo $TorsoHex;
                ?>'></div>
            <input class='btn btn-success' type='submit' value='Submit' name='updateColor'>
        </form>
    </section>
</div>
<div class='tab-pane fade' id='service-three'>
    <section class='container'>
        <form action='' method='POST'>
            Right Arm Color: <input type="hidden" name='bodyPart' value='rightArm'><div class='input-color-container'><input class='input-color' type="color" name='ChangeColor' value='<?php
                echo $RightArmHex;
                ?>'></div>
            <input class='btn btn-success' type='submit' value='Submit' name='updateColor'>
        </form>
    </section>
</div>
<div class='tab-pane fade' id='service-four'>
    <section class='container'>
        <form action='' method='POST'>
            Left Arm Color: <input type="hidden" name='bodyPart' value='leftArm'><div class='input-color-container'><input class='input-color' type="color" name='ChangeColor' value='<?php
                echo $LeftArmHex;
                ?>'></div>
            <input class='btn btn-success' type='submit' value='Submit' name='updateColor'>
        </form>
    </section>
</div>
<div class='tab-pane fade' id='service-five'>
    <section class='container'>
        <form action='' method='POST'>
            Right Leg Color: <input type="hidden" name='bodyPart' value='rightLeg'><div class='input-color-container'><input class='input-color' type="color" name='ChangeColor' value='<?php
                echo $RightLegHex;
                ?>'></div>
            <input class='btn btn-success' type='submit' value='Submit' name='updateColor'>
        </form>
    </section>
</div>
<div class='tab-pane fade' id='service-six'>
    <section class='container'>
        <form action='' method='POST'>
            Left Leg Color: <input type="hidden" name='bodyPart' value='leftLeg'><div class='input-color-container'><input class='input-color' type="color" name='ChangeColor' value='<?php
                echo $LeftLegHex;
                ?>'></div>
            <input class='btn btn-success' type='submit' value='Submit' name='updateColor'>
        </form>
    </section>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<style>
.footer{
bottom: -20px;
}

