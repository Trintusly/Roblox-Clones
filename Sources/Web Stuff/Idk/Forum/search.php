<?php


require_once("../Header.php");



echo "<br />
<b><font size='4'>Search Threads</font></b><br /><br />

<form action='' method='post'>

<b>Key Words: </b> <input type='text' name='q' style='width:20%;'>
<br />
<input type='submit' name='find' value='Search'>
</form>


";

$KeyWord = $_POST['q'];

$Submit = $_POST['find'];


if ($Submit) {
$getThreads = mysql_query("SELECT * FROM Threads WHERE Title LIKE '%$KeyWord%' LIMIT 10");
echo "
<table width='900'>
<tr>
<td width='500'>
<b>Title</b>
</td>
<td>
<td width='400'>
<b>Poster</b>
</td>
</tr>
</table><br />";
while ($gT = mysql_fetch_object($getThreads)) {
$getPoster = mysql_query("SELECT * FROM Users WHERE ID='$gT->PosterID'");
$Poster = mysql_fetch_object($getPoster);
echo"
<div style='border:1px solid lightgrey;'>
<table width='900'>
<tr>
<td width='500'>
<a href='ViewThread.php?ID=$gT->ID'>$gT->Title</a>
</td>
<td width'400'>
<a href='../user.php?ID=$Poster->ID'>$Poster->Username</a>
</td>
</tr>
</table></div><br />
";
}
}


