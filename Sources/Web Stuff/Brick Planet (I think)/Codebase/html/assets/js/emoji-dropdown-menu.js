
function handleEmojiDropDown() {
	document.getElementById("EmojiDropdown").classList.toggle("menushow");
}

window.onclick = function(event) {
  if (!event.target.matches('.dropdownbutton, .dropdownbutton i, .emoji-dropdown')) {
    var dropdowns = document.getElementsByClassName("emoji-dropdown");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('menushow')) {
        openDropdown.classList.remove('menushow');
      }
    }
  }
}

