<? include"../header.php"; 
$game = $handler->query("SELECT * FROM users ORDER by id ASC");
$all = ($game->rowCount());
?>

<div class="bc-content">
<table>
<tbody>
<tr>
<td width="80%">
<div class="header-text">Search Users</div>
</td>
<td width="20%" class="right-align">
<? echo $all ?> Total Users
</td>
</tr>
</tbody>
</table>
<div style="height:15px;"></div>

<?php
if (isset($_POST['bt']))
{
    header("Location: /Profile/?username=" . $_POST['folder']);
}
?>
<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="text" name="folder" id="folder" class="general-textarea" placeholder="Username" />
<div style="height:5px;"></div>

<button name="bt" id="bt" class="btn waves-effect waves-light" type="submit" name="action">Search
    <i class="material-icons right">send</i>
  </button>

</form>
</div>

<div class="row"> <div class="col s3 m3">
      <div class="card">
        <div class="card-image">
          <img src="http://i.imgur.com/82xGDXr.png">
          
          <a href="/Profile/?username=BrickCreate" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">person</i></a>
        </div>
        <div class="card-content">
          <p>BrickCreate</p>
        </div>
      </div>
    </div></div>