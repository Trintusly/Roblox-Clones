<?php 
    include("../SiT_3/config.php");
    include("../SiT_3/header.php");
    include("../SiT_3/PHP/helper.php");
    
if($power > 0) {
//Let them continue. They must be a admin :o
} 
else {
header('Location: ../');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Shop List - Brick Hill</title>
</head>
<body>
	<!--
2017/03/22 - Balloon
2017/03/24 - Long Locks of Brown Hair
2017/03/26 - Tree Stump
2017/03/27 - Chicken Hat
2017/04/01 - Paper Bag
2017/04/01 - Flag
2017/04/03 - Basketball
2017/04/05 - Lampshade
2017/04/07 - Traffic Cone
2017/04/09 - Bottle
2017/04/10 - Sunglasses
2017/04/12 - Wooden Barrel
2017/04/13 - Chocolate Milk
2017/04/16 - Books
2017/06/21 - Ice Cream
2018/01/15 - MLK
2018/02/14 - Heart Shades -->
	<div id="body">
		<table border="0" cellpadding="4" cellspacing="1" style="background-color:#000;" width="100%">
			<tbody>
			<a style="color:white;" href="add/"><button style="padding: 6px;margin-bottom: 10px;font-size: 17px;width: 100%;font-weight: bold;background-color: #ff7777;margin-left: 0px;" class="blue-button">Add</button></a>
				<tr>
					<th width="36%">
						<p class="title" style="color:#FFF;">Name</p>
					</th>
					<th width="14%">
						<p class="title" style="color:#FFF;">Date</p>
					</th>
					<th width="8%">
						<p class="title" style="color:#FFF;">Uploaded</p>
					</th>
				</tr>
				<?php 
				$listSQL = "SELECT * FROM `list`";
				$list = $conn->query($listSQL);
				$listRow = $list->fetch_assoc();
				while($listRow = $list->fetch_array()) {
				//$listrow = (object) $listrow;		
				echo '<tr class="forumColumn">
					<td>
						<p>'.$listRow->{"name"}.'</p>
					</td>
					<td>
						<p>'.$listRow->{"date"}.'</p>
					</td>
					<td>
						<p>'.$listRow->{"uploaded"}.'</p>
					</td>
				</tr>';}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>