<?php
include('../func/connect.php');
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Currency | Tetrimus</title>
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
if ($loggedIn) {
} else {
    header("location: ../");
}
?>
<div class="container">
<div class="col-md-10" style="margin: 0px auto;float:none;">
<?php
function fix_num($num)
{
    $num = str_replace("-", " ", $num);
    $num = floor($num);
    return $num;
}

if (isset($_POST['exchange'])) {
    $type   = htmlentities($_POST['type']);
    $amount = htmlentities($_POST['amount']);
    $amount = fix_num($amount);
    if (is_numeric($amount)) {
        if ($type == "coins") {
            if ($amount % 10 == 0) {
                if ($user->coins >= $amount) {
                    $new_amount_tokens = $amount / 10;
                    $conn->query("UPDATE users SET coins=coins-'$amount' WHERE id='$user->id'");
                    $conn->query("UPDATE users SET tokens=tokens+'$new_amount_tokens' WHERE id='$user->id'");
                    echo'<script>window.location.replace("../currency");</script>';
                } else {
                    echo "<center><div class='alert alert-danger' >You don't have enough to trade!</div></center>";
                }
                
                
            } else {
                echo "<center><div class='alert alert-danger'>Number must be divisible by 10.</div></center>";
            }
        } else {
            if ($user->tokens >= $amount) {
                $new_amount_coins = $amount * 10;
                $conn->query("UPDATE users SET tokens=tokens-'$amount' WHERE id='$user->id'");
                $conn->query("UPDATE users SET coins=coins+'$new_amount_coins' WHERE id='$user->id'");
                                    echo'<script>window.location.replace("../currency");</script>';
            } else {
                echo "<center><div class='alert alert-danger'>You dont have enough to trade!</div></center>";
            }
            
            
        }
    } else {
        echo "<center><div class='alert alert-danger'>Please enter a real number.</div></center>";
    }
}
?>

    <div class="card">
    <div class="card-body">
    <h4>Currency</h4>
    <p>You have

<?php
echo "" . $user->tokens . " tokens and " . $user->coins . " coins";
?>

<form method="POST" action="">
<div class="form-group" style="margin:0 auto;text-align:center;">
    <label>Exchange currency</label>
	<select class="form-control" name="type">
        <option value="bucks">Tokens to Coins</option>
        <option value="coins">Coins to Tokens</option>
    </select>
    <label>Enter amount</label>
	<input class="form-control" name="amount" placeholder="Enter a value to exchange">
    <br>
    <button type="submit" class="btn btn-outline-success" name="exchange">Exchange</button>
    </div>
</div>
</form>
</div>
</div>
</div>