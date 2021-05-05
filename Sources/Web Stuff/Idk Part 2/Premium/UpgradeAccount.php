<?php
	include "../Header.php";
		if (!$User) {
		
			header("Location: ../index.php");
		
		}
		echo "
<div class='container'>
<h1 class='center' style='color:#808a94;font-size:24px;font-weight:400;letter-spacing:1px;padding-bottom:50px;'>MEMBERSHIPS</h1>
<div class='row'>
<div class='col-md-3 col s3'>
<div class='center'>
					<div style='background:#fff;border:2px solid #D5D6D8;border-radius:5px;padding:30px;'>
                                        <div style='font-size:30px;'>Monthly</div>
                                        <div style='color:#999;font-size:12px;'>$2.95/month</div>
                                        <div style='height:20px;'></div>
                                        250 BUX Daily!
                                        <br>
                                        Create Groups for Free!
                                        <br>
                                        1 Special Item
                                        <div style='height:20px;'></div>
					<a href='/Account/Pay/Monthly/' style='display:block;background:#4098E6;padding:10px 40px;font-size:14px;color:white;font-weight:bold;border-radius:5px;text-decoration:None;'>Buy Now!</a></div>
</div></div>
		</div>
			</div>
			<br /></div>
		";
	
	include "../Footer.php";
?>