/* Globals -> */
	var move = '';
	var resize = '';
	var selected = "";
	var posX = 0;
	var posY = 0;
	X = 0;
	Y = 0;
/* <- Globals */

/* Mouse position -> */
	document.onmousemove = getPos;
	function getPos(event) {
		X = event.clientX;
		Y = event.clientY;
		if (move)
			moving();
		else if (resize)
			aaa();
		posX = X;
		posY = Y;
	}
/* <- Mouse position */

/* Windows manipulation -> */
	var move = '';
	var resize = '';
	var selected = "";
	var posX = 0;
	var posY = 0;
	X = 0;
	Y = 0;

	document.onmousemove = getPos;
	function getPos(event) {
		X = event.clientX;
		Y = event.clientY;
		if (move)
			moving();
		else if (resize)
			aaa();
		posX = X;
		posY = Y;
	}
	function moving() {
		var left = document.getElementById(selected).style.left;
		var top = document.getElementById(selected).style.top;
		var left = parseInt(left) - (posX - X);
		var top = parseInt(top) - (posY - Y);
		
		document.getElementById(selected).style.left = left + "px";
		document.getElementById(selected).style.top = top + "px";
	}
	function selecting(id) {
		if (selected)
		{
			document.getElementById(selected).style.zIndex = 0;
			document.getElementById(selected).style.opacity = 0.5;
		}
		if (id != "none")
		{
			document.getElementById(id).style.zIndex = 10;
			document.getElementById(id).style.opacity = 1;
			selected = id;
		}
		else
			selected = "";
	}
	function toggle_display(id,button) {
		if (!button || (button && id == selected))
		if (document.getElementById(id).style.display == "block")
			document.getElementById(id).style.display = "none";
		else
			document.getElementById(id).style.display = "block";
	}
/* <- Windows manipulation */