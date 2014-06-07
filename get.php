<?php
include 'connectToMySQL.php';

$get = $_GET['id'];
$user = $_GET['user'];

if($get == "all") {
	$name = $user;
	$list = mysql_query("SELECT * FROM groups");
	do
	{
		if ($groups['name'])
		{
			unset($name);
			for ($i = 0; $groups[$i]; $i++)
			{
				$username = explode("|",$groups[$i]);
				if (in_array($user, $username) || in_array("all", $username))
					$name = "(" . $groups['name'] . ")";
			}
		}
		$result = mysql_query("SELECT * FROM rwrite WHERE user='" . $name . "'");
		if ($name != $user)
			$name = substr($name, 1, -1);
		else
			$name = "Yours";
		echo "<optgroup label=\"". $name ."\">\n";
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value=\"". $row["id"] . "\">";
			echo $row["name"];
			echo "</option>\n";
		}
	} while($groups = mysql_fetch_array($list));
}
else {
	$access = array("Full", "Half", "Read only");
	$result = mysql_query("SELECT * FROM rwrite WHERE id='" . $get . "'");
	$row = mysql_fetch_array($result);
	$modified = explode("/",$row["modified"]);
	/* get level ->*/
	$result = mysql_query("SELECT * FROM groups WHERE name='" . substr($row['user'], 1, -1) . "'");
	$row2 = mysql_fetch_array($result);
	for ($i = 1; $row2[$i]; $i++) 
	{
		$names = explode("|",$row2[$i]);
		if (in_array($user, $names))
			break;
		elseif (in_array("all", $names))
			break;
	}
	/*<- get level */
	?>
	<table> <!-- HTML taulukko, tulostetaan saadut arvot n�tiss� taulukossa -->
		<tr>
			<th colspan="2"><?php echo $row['name']; ?></th>
        </tr><tr>
			<td>Access:</td>
			<td><?php echo $access[$i-1]; ?></td>
		</tr>
		<tr>
			<td class="modified">modified:</td>
		</tr>
		<tr>
			<td>
				date:<br />
				time:
			</td>
			<td><?php echo $modified[0] . "<br />" . $modified[1]; ?></td>
		</tr>
	</table>
	<?php
}
mysql_close($con);
?> 