<?php
$pagename = "Members";
$pagelink = "http://www.dimensious.com/user/members.php";
include('../header.php');
?>
<?php
$setting = array(
	"perPage" => 100
);
$perPage = 100;
$page = $_GET['page'];
if ($page < 1) { $page=1; }
if (!is_numeric($page)) { $page=1; }
$minimum = ($page - 1) * $Setting["perPage"];
$getall = $handler->query("select * from users");
$all = ($getall->rowCount());
$allusers = $handler->query("SELECT * FROM users ORDER BY id");
$num = ($allusers->rowcount());
$i = 0;
$numb = ($Page+8);
$a = 1;
$log = 0;
$amount=ceil($num / $setting["perPage"]);
$getMembers = $handler->query("SELECT * FROM users ORDER BY id ASC LIMIT {$minimum},  ". $setting["perPage"]);
?>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<div class="content-box">
		<div class="membr-hold">
			<h2 class="basic-font all-mmbrs">There are currently <?php echo "$all"; ?> users</h2>
			<?php
while ($gM = $getMembers->fetch(PDO::FETCH_OBJ)) {
$counter++;
echo "<a href='#' border='0' class='mmbr-usr basic-font'>
<img src='../Market/Storage/".$gM->body."' width=128 height=128><br />
<p>" . $gM->username . "</p>
</a>";
}
if ($page > 1) {
echo '<a href="/user/members.php?Page='.($page-1).'">Prev</a> - ';
}
echo '<p class="mmbr-pg-cnt basic-font">';
echo ''.$page.'/'.(ceil($num / $setting["perPage"]));
echo '</p>';
if ($page < ($amount)) {
echo ' - <a href="/user/members.php?Page='.($page+1).'">Next</a>';
}
?>
		</div>
<?php
include('../footer.php');
?>