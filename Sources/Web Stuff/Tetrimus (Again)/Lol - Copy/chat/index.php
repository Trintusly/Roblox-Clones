<?php
/*
<?php
include('func/connect.php');
$currentTime = time();

$qChat = $conn->query("SELECT * FROM `chat`");
$chatFetch = mysqli_fetch_object($qChat);
?>
<html>
  <head>
  <style>
  body{
  margin: 0;
  padding: 0;
}

#view_ajax {
  display: block;
  overflow: auto;
  width: 500px; 
  height: 300px; 
  border: 1px solid #333;
  margin: 0 auto;
  margin-top: 20px;
}

#ajaxForm{
  display: block;
  margin: 0 auto;
  width: 500px; 
  height: 50px;
  margin-top: 10px;
}

#chatInput{
  width: 454px;
}
</style>
    <title>Tetrimus | Chat</title>
    <script src="jquery.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="css/main.css" />
  </head>
  <body>
  
 <?php
 if(isset($_POST['send'])){
  $text = htmlentities($_POST['text']);

  //$conn->query("UPDATE users SET WHERE id='$id'");
  
  $conn->query("INSERT INTO `chat`(`username`, `color`, `chattext`, `chattime`)
VALUES ('$user->username', '#000', '$text', '$currentTime')");
}
?>
    <div id="view_ajax"></div>
    <div id="ajaxForm">
	<form name="send" action="#" method="POST">
      <input name="text" type="text" id="chatInput" />
	  
	  <input name="send" type="button" value="Send" id="btnSend" />
	  
	  </form>
    </div>
	<?php echo $chat->username $chat->chattext $chat->chattime; ?>
  </body>
</html>
*/