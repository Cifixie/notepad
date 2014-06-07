<?php
$con = mysql_connect("mysql.metropolia.fi","tommikes","vFHR3WUi90Na8DcVbO");
if (!$con)
	die('Could not connect: ' . mysql_error());
mysql_select_db("tommikes", $con);
?>