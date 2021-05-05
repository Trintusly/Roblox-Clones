<?php
include('func/connect.php');
    
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>We are offline...</title>
<script type="text/javascript" src="https://ajax.cloudflare.com/cdn-cgi/scripts/b7ef205d/cloudflare-static/rocket.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script data-rocketsrc="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous" type="text/rocketscript"></script>
<script data-rocketsrc="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous" type="text/rocketscript"></script>
<script data-rocketsrc="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous" type="text/rocketscript"></script>
<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<body style="background: #1fc111;">
<div class="container">
    <div style="height: 250px;"></div>
    <div class="col-md-8" style="margin: 0px auto;float: none;">
    <div style='background: #fff;color:#000;padding: 25px;'>
    Tetrimus is undergoing maintenance.<br>
    Our web devleopers are working hard to release new features!<br><i style="color:#aaa;">*Accounts will reset by the time site comes out*</i>
    <hr>
Expected downtime: <p id="timer" style="color:#1fc111;"></p>

<script>
// Set the date we're counting down to
var countDownDate = new Date("Mar 11, 2018 1:37:25").getTime();

var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    var distance = countDownDate - now;
    
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("timer").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
    
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "<p style='font-weight:bold;color:#1fc111;'>Site will be up shortly.</p>";
    }
}, 1000);
</script>
</div>
</div>
</div>
</body>