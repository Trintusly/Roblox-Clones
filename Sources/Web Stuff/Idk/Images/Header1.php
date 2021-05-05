<?php
include "../Global.php";
require_once("../Error/Sub.php");
echo"
<style>
.btn {
	padding-left: 15px;
	padding-right: 15px;
	padding-top: 5px;
	padding-bottom: 5px;
	border: 1px solid grey;
	background-color: #DFDFDF;
        font-weight:bold;
	color: #000;
        box-shadow: inset 0px -5px 10px 0px rgba(204,204,204,1);
	
}
.btn a:hover {
	text-decoration: none;
}
.btn:hover {
	background-color: #FFF;
	border: 1px solid #999;
	box-shadow: inset 0px -5px 10px 0px rgba(204,204,204,1);
}
}</style>";

echo "

<div id='nav'>

<a href='../index.php'><img src='../Imagess/SPNewLogo.png' height='50'></a>
</div><center>
<div style='background-color:white;width:100%;height:400px;'>
";
