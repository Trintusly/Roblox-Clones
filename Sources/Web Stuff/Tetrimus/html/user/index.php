 <?php
 include '../func/connect.php';
 
 $url_request = $_SERVER['REQUEST_URI']; //Returns path requested, like "/user/foo/"
 $user_request = str_replace("/user/", "", $url_request); //this leaves only 'foo/'
 $user_name = str_replace("/", "", $user_request); //this leaves 'foo'
 ?>