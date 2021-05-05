<?php
include('func/connect.php');
$auth_key = trim($conn->real_escape_string($_GET['auth_key']));
if($auth_key != "034444ryf83i87gft903") {
echo "Incorrect authentication key.";
die();
}
?>

<script>
var hookurl =
   "https://discordapp.com/api/webhooks/500137517710966794/AEcWSxE4_XtqqtViRJotEbnc2jlpXHh94LoqMR7HAZx_D3h71gdeGadzmQosxGN3Teix" +
   "/slack";

var username = "Tetrimus";
setUser = function() {
   if (document.getElementById("user").value.length === 0) {
      var username = "Tetrimus";
   } else {
      username = user.value;
   }

   document.getElementById("username").innerHTML = username;
};

function send() {
   if (document.getElementById("content").value.length === 0) {
      return;
   }

   var msgJson = {
      username: username,
      icon_url: "https://cdn.discordapp.com/attachments/486312166060720129/492432481849442311/tetrimus.png",
      text: document.getElementById("content").value
   };
   post(hookurl, msgJson);
   document.getElementById("content").value = "";
}

function post(url, jsonmsg) {
   xhr = new XMLHttpRequest();
   xhr.open("POST", url, true);
   xhr.setRequestHeader("Content-type", "application/json");
   var data = JSON.stringify(jsonmsg);
   console.log("jsonmsg = ", jsonmsg);
   console.log("data = " + data);
   xhr.send(data);
   xhr.onreadystatechange = function() {
      if (this.status != 200) {
         alert(this.responseText);
      }
   };
}

// document.getElementById("content")
//    .addEventListener("keyup", function(event) {
//       event.preventDefault();
//       if (event.keyCode == 13) {
//          document.getElementById("send").click();
//       }
//    });

$("#content").keydown(function(e) {
   if (e.keyCode == 13) {
      if (e.shiftKey) {
         // alert("Enter was pressed")
         send();
      } else {
         $(this).val($(this).val() + "\n");
      }
      return false;
   }
});

</script>
<style>
#content {
   width: 350px;
   height: 280px;
   box-sizing: border-box;
   resize: none;
}

h2 {
   font-size: 1.5em;
   color: #f9f9f9;
}

input, textarea {
   font-family: monospace;
   color: #000;
}

div.chat-frame {
   display: flex;
   flex-direction: column;
   padding: 5px;
   margin: 7px 12px 7px 7px;
   background-color: #999;
   border: #666;
   border-width: thin;
   border-radius: 3px;
   font-size: 10pt;
}

div[class*="embossed"] {
   text-shadow: 0 1px 1px rgba(255, 255, 255, 0.9);
}

.embossed {
   border: 1px solid rgba(0, 0, 0, 0.05);
   box-shadow: inset 0 2px 3px rgba(255, 255, 255, 0.3),
      inset 0 -2px 3px rgba(0, 0, 0, 0.3),
      0 1px 1px rgba(255, 255, 255, 0.9);
}

.emphasize {
   box-shadow: 0 0 5px 2px rgba(0, 0, 0, .35);
}

.outer-container {
   display: flex;
   flex-direction: row;
   justify-content: flex-start;
}

.right {
   display: flex;
   flex-direction: column;
}
</style>
<div class='outer-container'>
   <div class="chat-frame emphasize">
      <textarea id="content" type="text" placeholder="Message"></textarea>

      <br>
      <button id="send" onclick="send()">Send (Shift+Enter)</button>
   </div>


   <div class='right'>
      <embed id='live-channel-feed' height='400' width='400' src='https://widgetbot.voakie.com/widget/index.html?g=257734324839907329&c=336606858347413515&sCN=true&sGI=true&bS=small&t=dark&uT='>
   </div>
</div>