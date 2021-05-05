<?php include 'Header.php';

	if (!$AUTH) {
		echo '
		<div class="page-header" id="banner">
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				  <ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				  </ol>
				  <div class="carousel-inner">
					<div class="carousel-item active">
					  <img class="d-block w-100" src="./DOC/IMG/Placeholder.png" alt="First slide">
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="./DOC/IMG/Placeholder.png" alt="Second slide">
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="./DOC/IMG/Placeholder.png" alt="Third slide">
					</div>
				  </div>
				</div>
			</div>
		</div>
		<div style="height:120px;"></div>
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-3">
				</div>
				<div class="col-12 col-md-6">
					<div class="card border-dark">
					  <div class="card-body">
					  <center><h6>All the Moose Outfitters Apparel youve been waiting for</h6></center>
					  </div>
					</div>
				</div>
				<div class="col-12 col-md-3">
				</div>
			</div>
			<div style="height:60px;"></div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="card text-black bg-light">
					  <div class="card-body">
						<img src="http://placehold.it/450x450">
					  </div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="card text-black bg-light">
					  <div class="card-body">
						<img src="http://placehold.it/450x450">
					  </div>
					</div>
				</div>
			</div>
		</div>
	  </body>
	</html>
		';
	} else if ($AUTH) {
		echo '
		<div style="height:120px;"></div>
		<div class="container">
			<div class="page-header" id="banner">
					<div class="col-12 col-md-4">
						<div class="list-group">
						  <a href="#" class="list-group-item  list-group-item-action active">
							'.$gU->email.'
						  </a>
						  <a href="#" class="list-group-item list-group-item-action">View Cart
						  </a>
						  <a href="#" class="list-group-item list-group-item-action">Your Orders
						  </a>
						  <a href="#" class="list-group-item list-group-item-action">Account Settings
						  </a>
						</div>
					</div>
				</div>
			</div>
		</div>
		';
	}