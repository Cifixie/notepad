var opening = "";
function hash(id) {
	document.getElementById(id).value = hex_md5(document.getElementById(id).value);
}
function false_action(e) {
	if (e == "rename")
		alert("You need to open a file first!");
	if (e == "delete")
		alert("you need to open a file first!");
}
function ask_name(e) {
	var name = prompt("Tiedoston nimi");
	if (name == "")
		alert("incorrect value!");
	else if (name != null)
	{
		if (e == "save" || e == "save_as")
		{
			var owner = prompt("mihin haluat tallentaa?",document.getElementById('hidden_username').value);
			if (owner == "")
				alert("incorrect value!");
			else if (name != null)
			{
				document.getElementById(e).type = "submit";
				document.getElementById('hidden_info').value = owner + "|" + name;
				return true;
			}
		}
		else if (name != null)
		{
			document.getElementById(e).type = "submit";
			document.getElementById('hidden_info').value = name;
			return true;
		}
	}
	document.getElementById(e).type = "button";
}
function confirm_click(e) {
	var editing_file = document.getElementById('editing').value;
	var selection;
	if (e == "new")
	{
		if (status == "edited")
			selection = confirm("You haven't save current file. Do you want still continue?");
		else
			selection = true;
	}
	else if (e == "delete")
		selection = confirm("Do you really want to delete file '" + editing_file + "'?");
	else if (e == "end")
	{
		if (status == "edited")
			selection = confirm("Are you sure?\n You will lose everything that is not saved.");
		else
			selection = confirm("Are you sure?");
	}
	else if (e == "open")
	{
		document.getElementById('hidden_info').value = opening;
		if (status == "edited")
			selection = confirm("Are you sure? " + editing_file + "is unsaved after modified...\n You will lose everything that is not saved.");
		else
			selection = true;
	}
	
	if (selection)
		document.getElementById(e).type = "submit";
	else
		document.getElementById(e).type = "button";
}
function display(e)
{
	if (typeof(e) == "number")
	{
		get(e,document.getElementById('hidden_username').value,'right_side');
		opening = e;
	}
	else if (typeof(e) == "string")
	{
		
		if (document.getElementById(e).style.display == "block")
		{
			document.getElementById(e).style.display = "none";
			document.getElementById(right_side).innerHTML = "";
		}
		else
		{
			document.getElementById(e).style.display = "block";
			get('all',document.getElementById('hidden_username').value,'list_open');
		}
	}
}

function adjusment_by_resolution()
{
	var height = 0;
	if (typeof(window.innerHeight) == 'number') //Non-IE
    	height = window.innerHeight;
	else
	{
	    alert("ERROR! your browser suck!");
		return false;
	}
	document.getElementById('datafield').style.height = (height - 30) + "px";
}