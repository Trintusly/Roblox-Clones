<?php 
include('../SiT_3/config.php');
include('../SiT_3/header.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Rewards - Brick Hill</title>
</head>
<body>
	<div id="body">
		<div id="box" style="padding:10px;">
			<table>
				<tbody>
					<?php 
					$awardsSQL = "SELECT * FROM `awards`";
					$awardsQuery = $conn->query($awardsSQL);
					
					while($awardRow = $awardsQuery->fetch_assoc()) {
						$awardRow = (object) $awardRow;
					?>
					<tr>
						<td><img src="/assets/awards/<?php echo $awardRow->{'id'}; ?>.png" style="border: 1px solid #000;background-color: #FDFDFD;width: 118px;height: 118px;"></td>
						<td style="display: block;">
							<span style="font-size: 25px;font-weight: bold;color: #333;"><?php echo $awardRow->{'name'}; ?></span>
							<p style=" padding: 3px; font-size: 16px; margin-top: 0px;"><?php echo $awardRow->{'description'}; ?></p>
						</td>
					</tr>
					<?php 
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>