<? include "../../header.php"; 
$id = $_GET['id'];
$getGroup = $handler->query("SELECT * FROM groups WHERE id=" . $_GET['id']);
$gG = $getGroup->fetch(PDO::FETCH_OBJ);
?>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<script>
		function about() {
			document.getElementById("about-tab").style.backgroundColor = "#FAFAFA";
			document.getElementById("about-tab").style.borderRight = "5px solid #0288d1";
			
			document.getElementById("announcements-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("announcements-tab").style.borderRight = "none";
			document.getElementById("members-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("members-tab").style.borderRight = "none";
			document.getElementById("events-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("events-tab").style.borderRight = "none";
			document.getElementById("divisions-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("divisions-tab").style.borderRight = "none";
			document.getElementById("about").style.display = "block";
			
			document.getElementById("announcements").style.display = "none";
			document.getElementById("members").style.display = "none";
			document.getElementById("events").style.display = "none";
			document.getElementById("divisions").style.display = "none";
		}
		
		function announcements() {
			document.getElementById("about-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("about-tab").style.borderRight = "none";
			
			document.getElementById("announcements-tab").style.backgroundColor = "#FAFAFA";
			document.getElementById("announcements-tab").style.borderRight = "5px solid #0288d1";
			document.getElementById("members-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("members-tab").style.borderRight = "none";
			document.getElementById("events-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("events-tab").style.borderRight = "none";
			document.getElementById("divisions-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("divisions-tab").style.borderRight = "none";
			document.getElementById("about").style.display = "none";
			
			document.getElementById("announcements").style.display = "block";
			document.getElementById("members").style.display = "none";
			document.getElementById("events").style.display = "none";
			document.getElementById("divisions").style.display = "none";
		}
		function members() {
			document.getElementById("about-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("about-tab").style.borderRight = "none";
			
			document.getElementById("announcements-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("announcements-tab").style.borderRight = "none";
			document.getElementById("members-tab").style.backgroundColor = "#FAFAFA";
			document.getElementById("members-tab").style.borderRight = "5px solid #0288d1";
			document.getElementById("events-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("events-tab").style.borderRight = "none";
			document.getElementById("divisions-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("divisions-tab").style.borderRight = "none";
			document.getElementById("about").style.display = "none";
			
			document.getElementById("announcements").style.display = "none";
			document.getElementById("members").style.display = "block";
			document.getElementById("events").style.display = "none";
			document.getElementById("divisions").style.display = "none";
		}
		function events() {
			document.getElementById("about-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("about-tab").style.borderRight = "none";
			
			document.getElementById("announcements-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("announcements-tab").style.borderRight = "none";
			document.getElementById("members-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("members-tab").style.borderRight = "none";
			document.getElementById("events-tab").style.backgroundColor = "#FAFAFA";
			document.getElementById("events-tab").style.borderRight = "5px solid #0288d1";
			document.getElementById("divisions-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("divisions-tab").style.borderRight = "none";
			document.getElementById("about").style.display = "none";
			
			document.getElementById("announcements").style.display = "none";
			document.getElementById("members").style.display = "none";
			document.getElementById("events").style.display = "block";
			document.getElementById("divisions").style.display = "none";
		}
		function divisions() {
			document.getElementById("about-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("about-tab").style.borderRight = "none";
			
			document.getElementById("announcements-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("announcements-tab").style.borderRight = "none";
			document.getElementById("members-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("members-tab").style.borderRight = "none";
			document.getElementById("events-tab").style.backgroundColor = "#FFFFFF";
			document.getElementById("events-tab").style.borderRight = "none";
			document.getElementById("divisions-tab").style.backgroundColor = "#FAFAFA";
			document.getElementById("divisions-tab").style.borderRight = "5px solid #0288d1";
			document.getElementById("about").style.display = "none";
			
			document.getElementById("announcements").style.display = "none";
			document.getElementById("members").style.display = "none";
			document.getElementById("events").style.display = "none";
			document.getElementById("divisions").style.display = "block";
		}
		
		function changeMembers(page, rank) {
			var xmlHttp = new XMLHttpRequest();
			xmlHttp.open( "GET", "https://www.bloxcity.com/groups/members.php?GroupID=1&Rank=" + rank + "&Page=" + page, true);
			xmlHttp.send(null);
			xmlHttp.onload = function(e) {
				if (xmlHttp.readyState == 4) {
					document.getElementById("members-area").innerHTML = xmlHttp.responseText;
				}
			}
		}
		
		window.onload = function() {
			
					about();
					changeMembers(1, 1);
					
			$(".modal-trigger").leanModal();
		}
	</script>
<form action="#">
<div class="row">
<div class="col s12 m2 l2">
<select class="browser-default market-dropdown" name="type">
<option value="all">All</option>
<option value="business">Business</option>
<option value="war">War</option>
<option value="roleplay">Roleplay</option>
<option value="club">Club</option>
<option value="shop">Shop</option>
</select>
</div>
<div class="col s12 m10 l10">
<input type="text" class="general-textbar" placeholder="Search a group name" onchange="updateSearch(this.value)" name="query">
</div>
</div>
</form>
<div class="row">
<div class="col s12 m2 l3">
<div class="content-box" style="padding:0;padding:15px;">
<img src="<? echo " $gG->image"; ?>" class="responsive-img center-align">
<div style="padding-top:3px;text-align:center;font-size:22px;word-wrap:break-word;"><? echo"$gG->title"; ?></div>
<div style="padding-top:3px;text-align:center;font-size:14px;">Owned by: <a href="/Profile?username=<? echo $gG->owner ?>"><? echo"$gG->owner"; ?></a></div>
<div style="height:12px;"></div>
<? $groupmember = $handler->query("SELECT * FROM groupmembers WHERE userid=" . $myu->id);
if (!$groupmember->fetch(PDO::FETCH_OBJ)){ ?>
<div class="center-align"><form action="/Groups/Club/Join.php?id=<? echo $id ?>" method="POST"><input type="submit" name="JoinGroup" class="waves-effect waves-light btn grey darken-2" value="Join Group"><input type="hidden" name="csrf_token" value="VoCrOP9owOTkoCXLNxpR5AkeGaiTYAhk1xH1Bjyivso="></form></div>
<? } else { ?>
<div class="center-align"><form action="/Groups/Club/Leave.php" method="POST"><input type="submit" name="JoinGroup" class="waves-effect waves-light btn grey darken-2" value="Leave"><input type="hidden" name="csrf_token" value="VoCrOP9owOTkoCXLNxpR5AkeGaiTYAhk1xH1Bjyivso="></form></div>
<? } ?>
</div>
<? $getGroup = $handler->query("SELECT * FROM groupmembers WHERE groupid='$id' LIMIT 12"); 
$getGroupM = $handler->query("SELECT * FROM groupmembers WHERE groupid='$id'"); ?>
<div style="height:15px;"></div>
<div class="group-tab-link" id="about-tab" onclick="about()" style="background-color: rgb(250, 250, 250); border-right: 5px solid rgb(2, 136, 209);">About</div>
<div class="group-tab-link" id="announcements-tab" onclick="announcements()" style="background-color: rgb(255, 255, 255); border-right: none;">Announcements</div>
<div class="group-tab-link" id="members-tab" onclick="members()" style="background-color: rgb(255, 255, 255); border-right: none;">Members</div>
<div class="group-tab-link" id="events-tab" onclick="events()" style="background-color: rgb(255, 255, 255); border-right: none;">Events</div>
<div class="group-tab-link" id="divisions-tab" onclick="divisions()" style="background-color: rgb(255, 255, 255); border-right: none;">Divisions</div>
<div style="height:15px;"></div>
<div class="content-box" style="padding:0;padding:15px;">
<div style="text-align:center;font-size:24px;color:#444444;"><? echo $getGroupM->rowCount(); ?></div>
<div style="text-align:center;font-size:16px;color;#666666;">Members</div>
<div style="height:15px;"></div>
<div style="text-align:center;font-size:24px;color:#15BF6B;"><? echo"$gG->vault"; ?></div>
<div style="text-align:center;font-size:16px;color;#666666;">Vault</div>
</div>
</div>
<div class="col s12 m10 l9">
<div id="about" style="display: block;">
<div class="content-box">
<div class="header-text" style="font-size:18px;padding-bottom:15px;">About</div>
<div><? echo"$gG->description"; ?></div>
</div>
</div>
<div id="announcements" style="display:none;">
<div style="background:#0288d1;padding:10px 15px;font-size:20px;color:white;">This feature</div>
<div class="content-box" style="border-radius:0;border-top:0;padding:0;padding:15px;font-size:16px;">
Is coming soon.
</div>
</div>

<div id="members" style="display: block;">
<div class="content-box">
<div class="row">
<div class="col s8"><div class="header-text" style="font-size:18px;margin-top:8px;">Members</div></div>
<div class="col s4">
<select class="browser-default market-dropdown" onchange="changeMembers(1, this.value)">
<option value="1">Members</option>
</select>
</div>
</div>
<div id="members-area"><div class="row" style="margin-bottom:0;">
<? while($gG = $getGroup->fetch(PDO::FETCH_OBJ)){ 
$user = $handler->query("SELECT * FROM users WHERE id=" . $gG->userid);
$gU = $user->fetch(PDO::FETCH_OBJ)
?>
<div class="col s2 center-align" style="margin-top:15px;">

<img class="circle" src="http://i.imgur.com/hAdq5Gu.png" width="75" height="75">
<div style="padding-top:3px;">
<a href="/Profile?username=<? echo $gU->username ?>" style="font-size:12px;"><? echo $gU->username ?></a>
</div>
</div>
<? } ?>
</div>
<div style="height:25px;"></div>
<ul class="pagination center-align">
<li class="waves-effect"><a><i class="material-icons">chevron_left</i></a></li>
<li class="active"><a>1</a></li>
<li class="waves-effect"><a><i class="material-icons">chevron_right</i></a></li>
</ul>
</div>
</div>
</div>

<div id="events" style="display:none;">
<div class="content-box">
<div class="header-text" style="font-size:18px;padding-bottom:15px;">Events</div>
<div>No events found.</div>
</div>
</div></div>

<div id="divisions" style="display: block;">
<div class="content-box">
<div class="header-text" style="font-size:18px;padding-bottom:15px;">Divisions</div>
<div>No divisions found.</div>
</div>
</div>

</div>
</div>
</div>
<? include "../../footer.php"; ?>