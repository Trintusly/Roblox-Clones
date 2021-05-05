<?php include './connection.php';

	if ($AUTH) {
		echo '
		<body>
			<div class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
				<div class="container">
					<a href="#" class="navbar-brand">MOOSE</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarResponsive">
						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="nav-link" href="#">Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Blog</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download">Shop </span></a>
								<div class="dropdown-menu" aria-labelledby="download">
									<a class="dropdown-item" href="#">Mens</a>
									<a class="dropdown-item" href="#">Womens</a>
									<a class="dropdown-item" href="#">Kids</a>
								</div>
							</li>
						</ul>
						<ul class="nav navbar-nav ml-auto">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download">'.$gU->email.'</span></a>
								<div class="dropdown-menu" aria-labelledby="download">
									<a class="dropdown-item" href="./Logout.php">Logout</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download">Cart (0)</span></a>
								<div class="dropdown-menu" aria-labelledby="download">
									<a class="dropdown-item" href="#">Your Cart is Empty</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		';
	} else if (!$AUTH) {
		echo '
		<body>
			<div class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
				<div class="container">
					<a href="#" class="navbar-brand">MOOSE</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarResponsive">
						<ul class="navbar-nav">
							<li class="nav-item">
								<a class="nav-link" href="#">Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Blog</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download">Shop </span></a>
								<div class="dropdown-menu" aria-labelledby="download">
									<a class="dropdown-item" href="#">Mens</a>
									<a class="dropdown-item" href="#">Womens</a>
									<a class="dropdown-item" href="#">Kids</a>
								</div>
							</li>
						</ul>
						<ul class="nav navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="./Login.php">Login</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download">Cart (0)</span></a>
								<div class="dropdown-menu" aria-labelledby="download">
									<a class="dropdown-item" href="#">Your Cart is Empty</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		';
	}
