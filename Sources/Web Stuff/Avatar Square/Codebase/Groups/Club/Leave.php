<? include "../../header.php"; 
if($user){
$handler->query("DELETE FROM groupmembers WHERE userid='$myu->id'");
}
header('Location: /Groups');
?>