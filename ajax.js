var xmlhttp;
var area = "";

function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject)
	{ // code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}
function stateChanged()
{
	if (xmlhttp.readyState == 4)
	{
			document.getElementById(area).innerHTML = xmlhttp.responseText;
	}
}

function get(id,user,object)
{
	xmlhttp = GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return false;
	}
	var url = "get.php";
	url = url + "?user=" + user + "&id=" + id;
	url = url + "&sid=" + Math.random();
	area = object;
	xmlhttp.onreadystatechange = stateChanged;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}