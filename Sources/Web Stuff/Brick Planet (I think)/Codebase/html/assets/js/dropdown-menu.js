
var dropdown_open = 0;
var emoji_dropdown_open = 0;
var emojis_loaded = 0;

function handleDropdown() {
	document.getElementById("MenuDropdown").classList.toggle("menushow");
	if (dropdown_open == 0) { dropdown_open = 1; } else if (dropdown_open == 1) { dropdown_open = 0; }
}

function handleEmojiDropDown() {
	document.getElementById("EmojiDropdown").classList.toggle("menushow");
	if (emoji_dropdown_open == 0) { emoji_dropdown_open = 1; } else if (emoji_dropdown_open == 1) { emoji_dropdown_open = 0; }
	if (emojis_loaded == 0) {
		emojis_loaded = 1;
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "https://www.bloxcity.com/emoji/get.php", true);
		xhr.onload = function (e) {
		  if (xhr.readyState === 4) {
			if (xhr.status === 200) {
				document.getElementById('emojis-body').innerHTML = xhr.responseText;
		    }
		  }
		};
		xhr.onerror = function (e) {
		  alert("There was an issue loading emojis. Try refreshing the page.");
		};
		xhr.send(null);
	}
}

function functionSearch(search) {
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "https://www.bloxcity.com/emoji/get.php?q=" + search, true);
	xhr.onload = function (e) {
	  if (xhr.readyState === 4) {
		if (xhr.status === 200) {
			document.getElementById('emojis-body').innerHTML = xhr.responseText;
		}
	  }
	};
	xhr.onerror = function (e) {
	  alert("There was an issue loading emojis. Try refreshing the page.");
	};
	xhr.send(null);
}

window.onclick = function(event) {
  if (dropdown_open == 1) {
	  if (!event.target.matches('.dropdownbutton, .dropdownbutton *,  .top-bar-dropdown, .top-bar-dropdown *')) {
		var dropdowns = document.getElementsByClassName("top-bar-dropdown");
		var i;
		for (i = 0; i < dropdowns.length; i++) {
		  var openDropdown = dropdowns[i];
		  if (openDropdown.classList.contains('menushow')) {
			openDropdown.classList.remove('menushow');
			dropdown_open = 0;
		  }
		}
	  }
  }
  
  if (emoji_dropdown_open) {
	  if (!event.target.matches('.dropdownbutton, .dropdownbutton *, .emoji-dropdown, .emoji-dropdown *')) {
		var dropdowns = document.getElementsByClassName("emoji-dropdown");
		var i;
		for (i = 0; i < dropdowns.length; i++) {
		  var openDropdown = dropdowns[i];
		  if (openDropdown.classList.contains('menushow')) {
			openDropdown.classList.remove('menushow');
			emoji_dropdown_open = 0;
		  }
		}
	  }
  }
}

