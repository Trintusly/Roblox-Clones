function nightTime() {
	var clientTime = (new Date()).getHours();
		if ([0,1,2,3,4,5,20,21,22,23,24].indexOf(clientTime) > -1) {

			var cssLocation = "http://beta.brick-hill.com/assets/night.css";
			var head = document.getElementsByName("head");
			var nightElement = document.createElement("link");
			nightElement.setAttribute("rel", "stylesheet");
			nightElement.setAttribute("type", "text/css");
			nightElement.setAttribute("href", cssLocation);
			
		//	head.appendChild(nightElement);
			document.head.appendChild(nightElement);

		
		}
};

nightTime();
