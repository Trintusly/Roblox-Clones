<?php
	include "Header.php";
?>
<style>b { font-size:8pt; } </style>
		<?php
		$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
		
		if (!$ID) {
		
		echo "Error.";
		include "Footer.php";
		die;
		
		}
		
		//get blog posts
		
		$getBlogs = mysql_query("SELECT * FROM BlogPosts WHERE ID='$ID' ORDER BY ID DESC");
		
		$numBlog = mysql_num_rows($getBlogs);
		
		if ($numBlog == 0) {
		
			echo "Error.";
			include "Footer.php";
			die;
		
		}
		
			while ($gB = mysql_fetch_object($getBlogs)) {
				
				echo "
					<div id='BlogPost'>
					<a name='".$gB->ID."'></a>
							<div id='Title'>
								".$gB->Title." Created By ".$gB->Poster."
							</div>
							<br />
							<div id='Text'>
								".nl2br($gB->Body)."
							</div>
					</div>
					<br />
				";
			}
		?>
<?
	include "Footer.php";