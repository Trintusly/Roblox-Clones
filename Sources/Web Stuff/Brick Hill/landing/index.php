<?php
    include("../SiT_3/config.php");
    include("../SiT_3/header.php");
   
?>
<!DOCTYPE html>
<html>
<head>
<style>
@font-face {
	font-family: "pixel";
	src: url('../download/FSEX300.ttf');
}

.button {
    padding: 5px;
    /* margin: 50px; */
    font-size: 1.5rem;
    background-color: #08ca08;
    border-bottom: 5px solid #008600;
    text-align: center;
}
.button:hover {
	cursor: pointer;
}
.button:active {
    border-bottom: 0px solid transparent;
    margin-top: 15px;
}
.red-button {
	background-color: #FF5747;
	border-bottom: 5px solid #CB4538;
}
.green-button {
	background-color: #2BDC32;
	border-bottom: 5px solid #22B229;
}
  .blue-button {
    background-color: #15BFFF;
    border-bottom: 5px solid #109ACD;
    color: white;
}
</style>
	<style>
	#landing {
	   background-image: url(http://beta.brick-hill.com/assets/game1.png);
	   height: 480px;
	   background-repeat: round;
	   background-size: cover;
	}
	</style>
	<title>Landing - Brick Hill</title>
</head>
<body>
	<div id="body">
		<div id="box" style="padding: 10px;">
			<div id="landing">
				<div style="display: inline-table;padding-top: 5%;padding-left: 5%;">
					<h3 style=" color: white;">Welcome to Brick Hill.</h3>
					<h4 style=" color: white;">Sign up to get started!</h4>
          
          <div>
            
          <div class="button pixel-text blue-button" style="display:inline-block;">
					Sign Up
          </div></div>
				</div>
			</div>
			<h5 style="color:black;margin:0px;margin-top:5px;">Brick Hill is a free, multi platform brick-based video game made around a community of brick characters. <a href="/signup/" style="color:#77B9FF;">Sign up today!</a></h5>
			<hr><?php 
    include("about-us.php");
    ?>
    </div>
	</div><?php
	        include("../SiT_3/footer.php");
	    ?>
</body>
</html>