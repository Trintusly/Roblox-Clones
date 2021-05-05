<? include "../../header.php"; if ($myu->admin=="true"){ 
$id = $_GET['id'];
$handler->query("DELETE FROM threads WHERE threadId=" . $id); 
}
header("Location: /Forum"); ?>