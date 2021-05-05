<? include "../../header.php"; 
if($user){
$id = $_GET['id'];
$handler->query("INSERT INTO groupmembers (userid, groupid) VALUES ('$myu->id','$id')");
}
header('Location: /Groups');
?>