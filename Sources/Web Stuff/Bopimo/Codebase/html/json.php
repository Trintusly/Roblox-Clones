<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$json_raw = file_get_contents("https://www.bopimo.com/json.txt");
$json = json_decode($json_raw);
?>
<style>
body {
	font-family:Arial;
}
a {
	text-decoration:none;
}
#myBtn {
    display: none; /* Hidden by default */
    position: fixed; /* Fixed/sticky position */
    bottom: 20px; /* Place the button at the bottom of the page */
    right: 30px; /* Place the button 30px from the right */
    z-index: 99; /* Make sure it does not overlap */
    border: none; /* Remove borders */
    outline: none; /* Remove outline */
    background-color: red; /* Set a background color */
    color: white; /* Text color */
    cursor: pointer; /* Add a mouse pointer on hover */
    padding: 15px; /* Some padding */
    border-radius: 10px; /* Rounded corners */
    font-size: 18px; /* Increase font size */
}

#myBtn:hover {
    background-color: #555; /* Add a dark-grey background on hover */
}
</style>
<button onclick="topFunction()" id="myBtn" title="Go to top">Back to Top</button>
<?php
if(isset($_GET['start']) && isset($_GET['amount'])) {
	if(is_numeric($_GET['start']) && $_GET['start'] > 0 && is_numeric($_GET['amount']) && $_GET['amount'] > 0)
	{
		$amount = intval($_GET["amount"]);
		$account_limit = intval($_GET['amount'] + $_GET["start"]) - 1;
		$curAcc = intval($_GET['start']);
		$accounts = [];
		if($amount > 1500)
		{
			$amount = 1500;
		}
		?>
		<form action="" method="GET">
		Start At (Out of <?=count($json)?>):<input type="number" name="start" value="<?=$curAcc?>" placeholder="Start At">
		and show <input type="number" name="amount" value="<?=$amount?>" placeholder="Amount Here (MAX 150)">
		<input type="submit">
		</form>
		<a href="/json.php?amount=<?=$amount?>&start=<?=rand(1, 31327 - 1500)?>">Random Start</a>
		<hr>
		<?php
		$true = 0;
		foreach($json as $thing) //sort better
		{
			if($curAcc <= ($_GET['amount'] + $_GET["start"]) - 1 && $true >= $curAcc && $curAcc <= 31327)
			{
				$arr = (object) $json[$curAcc - 1];
				$account = [];
				array_push($account, ["username" => $arr->username, 
										"id" => $arr->user_id, 
										"robux" => $arr->robux,
										"money" => $arr->credit,
										"bc" => $arr->bc
										]);
				array_push($account, "lastactive", Array($arr->lastactive));
				$emails = $arr->emails;
				$email_thing = [];
				foreach($emails as $elementt) //another array
				{
					array_push($email_thing, $elementt[0]);
				}
				$string_email = $emails[0][0];
				if(count($emails) == 1 && (strpos($string_email, "@yahoo.com") || strpos($string_email, "@gmail.com") || strpos($string_email, "@aol.com") || strpos($string_email, "@hotmail.com") || strpos($string_email, "@hotmail.co.uk") || strpos($string_email, "@verizon.net") || strpos($string_email, "@msn.com")))
				{
					array_push($account, "emails", $email_thing);
					$accounts[$arr->username] = $account;
					unset($emails, $email_thing, $account, $elementt, $yes, $arr);
				}
				$curAcc++;
				
			}
			$true++;
		}
		$curAcc = intval($_GET['start']);
		foreach($accounts as $account)
		{
			if($curAcc <= ($_GET["amount"] + $_GET["start"]) - 1)
			{
				$rnd = uniqid() . uniqid() . uniqid();
				?>
				<div style="float:left;border:solid black 1px;margin-left:5px;margin-right:5px;width:calc(20% - 25px);height:225px;margin-bottom:10px;padding:5px;">
				<font color="sky-blue">ID: <?=$account[0]["id"]?></font><br>
				<font color="red">Username:<input value="<?=$account[0]["username"]?>" id="<?=$rnd?>_u" type="text"></font>
				<br>
				<font color="blue">Email: <input id="<?=$rnd?>" value="<?=implode(", ", $account[4])?>" type="text">
				</font>
				<br>
				<font color="orange">
				Last Online: <?=$account[2][0]?>
				</font>
				<br>
				<img src="https://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&username=<?=$account[0]["username"]?>" style="width:50%;float:right;margin-top:-10%;margin-right:-20px;">
				<a onclick="var thing = document.getElementById('<?=$rnd?>').select(); document.execCommand('copy');">Copy Email</a><br><a onclick="var thing = document.getElementById('<?=$rnd?>_u').select(); document.execCommand('copy');">Copy Username</a>
				<br>
				<a href="https://www.roblox.com/users/<?=$account[0]["id"]?>/profile" target="_blank">Profile</a>
				</font>
				<br>
				<font color="purple">BC: <?=$account[0]["bc"]?></font>
				<br>
				<font color="green">R$: <?=$account[0]["robux"]?>
				<br>
				$: <?=$account[0]["money"]?>
				</div>
				<?php
			}
			$curAcc++;
		}
	}
} else {
	?>
	<form action="" method="GET">
	Start At (Out of <?=count($json)?>):<input type="number" name="start" placeholder="Start At">
	and show <input type="number" name="amount" placeholder="Amount Here (MAX 150)">
	<input type="submit">
	</form>
	<?php
}

?>
<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>