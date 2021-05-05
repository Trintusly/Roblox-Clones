<?php 
include '../func/connect.php';
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login | Tetrimus</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="https://storage.tetrimus.com/logo.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body>
<?php include '../func/navbar.php'; ?>


<head>
	<title>purchase testomg</title>
</head>
  
<?php 
	echo '<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<!--Payments may go wrong if you edit this form, of which we are not responsible-->
	<input type="hidden" name="cmd" value="_donations">
	<input type="hidden" name="business" value="rockinriver2001@gmail.com">
	<input type="hidden" name="currency_code" value="USD">
	<input type="hidden" name="amount" value="$1.00">
	<input type="hidden" name="notify_url" value="http://tetrimus.com/paypal/notify.php">
	<input type="hidden" name="return" value="http://www.tetrimus.com/paypal/thanks.php">
	<input type="hidden" name="item_number" value="'.$user->id.'">
	<input type="hidden" name="item_name" value="DiamondMonthly">
	<div class="membership-image">
		<input style="height:105px;" type="image" src="" name="submit" alt="Buy Diamond for 1 month: $1">
	</div>
	</form>';
?>