<?php
include "../Header.php";
if (!$User) {
header("Location: index.php");
}
echo "
<table width='95%'>
	<Tr>
		<td>
			<div id='TopBar'>
				Account 
			</div>
			<div id='aB'>
				<fieldset style=''>
					<legend>Account Configuration</legend>
					<form action='' method='POST'>
						<table>
							<tr>
								<td>
									<font id='Text'>Description</font>
									<br /><br />
									<textarea name='Description' rows='3' cols='75'>$myU->Description</textarea>
									<br />
									<input type='submit' name='AllSubmit' value='Update Changes' />
									";
									$Description = mysql_real_escape_string(strip_tags(stripslashes($_POST['Description']))); 
									$AllSubmit = mysql_real_escape_string(strip_tags(stripslashes($_POST['AllSubmit'])));
									
									if ($AllSubmit) {
									
										$Description = filter($Description);
									
										if (strlen($Description) > 250) {
										
											echo "<b>Error: Please keep your description under two-hundred-fifty (250) characters.</b>";
										
										}
										else {
										
											mysql_query("UPDATE Users Set Description='$Description' WHERE ID='$myU->ID'");
											header("Location: user.php?ID=$myU->ID");
										
										}
									
									}
									echo "
								</td>
							</tr>
						</table>
					</form>
				</fieldset>
			</div>
		</td>
	</tr>
</table>
";
include "../Footer.php";