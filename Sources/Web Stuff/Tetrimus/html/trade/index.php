<?php
include('../func/connect.php')
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Trading | Tetrimus</title>
<meta name="description" content="Want to trade something cool with your friends? This is the right place.">
<meta name="author" content="Tetrimus inc."
<script type="text/javascript" src="https://ajax.cloudflare.com/cdn-cgi/scripts/b7ef205d/cloudflare-static/rocket.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script data-rocketsrc="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous" type="text/rocketscript"></script>
<script data-rocketsrc="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous" type="text/rocketscript"></script>
<script data-rocketsrc="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous" type="text/rocketscript"></script>
<script src="https://web.archive.org/web/20180707155901js_/https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://web.archive.org/web/20180707155901js_/https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://web.archive.org/web/20180707155901js_/https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<link rel="stylesheet" href="../style.css?=<?php echo rand(10000,1000000) ?>">
</head>
<?php
include('../func/navbar.php')
?>
<center>
    <h2>Trading, Coming Soon.</h2>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Began Trade</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Trading with South</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <h5>South</h5>
  <p>Trading is a work in progress feature</p>
  <div class="card" style="width:200px;height:100px">
                  <img class="card-img-top" src="https://www.tetrimus.xyz/images/s3.png?r=290635" alt="Card image">
                  <div class="card-body">
                    <h3 class="card-title">Beard</h3>
                    <p class="card-text">Worth: 10 Coins.</p>
                    <a href="" class="btn btn-primary">Inspect</a>
										<br>
                </div>

  <hr>
  <h5>You</h5>
  <p>Test</p>
  <div class="card" style="width:200px;height:100px">
                  <img class="card-img-top" src="https://tetrimus.xyz/images/s4.png?r=7" alt="Card image">
                  <div class="card-body">
                    <h3 class="card-title">Glasses Smile</h3>
                    <p class="card-text">Worth: 10 Coins.</p>
                    <a href="" class="btn btn-danger">Remove</a>
										<br>
                </div>


      </div>
      </div>
    
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>