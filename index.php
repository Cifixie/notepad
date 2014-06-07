<?php session_start();
include 'connectToMySQL.php';


function check_user($username,$password)
{ //Käyttäjänimen ja salasanan tarkistus
	$result = mysql_query("SELECT * FROM users WHERE username='" . $username . "'");
	$row = mysql_fetch_array($result);
	if ($row['password'] == $password)
		return true;
	return false;
}
function get_level($id)
{
	$result = mysql_query("SELECT * FROM rwrite WHERE id='" . $id . "'");
	$row = mysql_fetch_array($result);
	$result = mysql_query("SELECT * FROM groups WHERE name='" . substr($row['user'], 1, -1) . "'");
	$row = mysql_fetch_array($result);
	for ($i = 1; $row[$i]; $i++)
	{
		$names = explode("|",$row[$i]);
		if (in_array($_SESSION['user'], $names))
			break;
		elseif (in_array("all", $names))
			break;
	}
	return $i;
}


if ($_POST['username'])
{
	if (check_user($_POST['username'],$_POST['password']) == true)
	{
		$_SESSION['user'] = $_POST['username'];
	}
	else
		echo "Login failed!";
}

$level = get_level($_SESSION['open']);

if ($_POST['q']) {
	$operation = $_POST['q'];
	if ($operation == "end")
	{
		unset($_SESSION['user'],$_SESSION['open']);
		session_destroy();
	}
	elseif ($operation == "open")
	{
		$result = mysql_query("SELECT * FROM rwrite WHERE id='" . $_POST['info'] . "'");
		$row = mysql_fetch_array($result);
		$_POST['data'] = $row['data'];
		$_SESSION['open'] = $_POST['info'];
		if ($row['user'] == $_SESSION['user'])
			$level = 1;
		else
			$level = get_level($_POST['info']);
	}
	elseif ($operation == "rename")
	{
		mysql_query("UPDATE rwrite SET name = \"" . $_POST['info'] . "\" WHERE id = " . $_SESSION['open'] . "");
		$message = "Nimi vaihdettu onnistuneesti!";
	}
	elseif ($operation == "save" || $operation == "saveAs")
	{
		$modified = date("H:i:s/d.m.y") . "/" . $_SESSION['user'];
		if ($_SESSION['open'] && $operation != "saveAs")
		{
			mysql_query("UPDATE rwrite SET data = \"" . $_POST['data'] . "\" WHERE id = " . $_SESSION['open'] . "");
			mysql_query("UPDATE rwrite SET modified = \"" .  $modified . "\" WHERE id = " . $_SESSION['open'] . "");
			$message = "File saved!";
		}
		else
		{
			unset($level);
			$info = explode("|",$_POST['info']);
			if ($info[0] == $_SESSION['user'])
			{
				$level = 1;
				$user = $info[0];
			}
			else
			{
				$result = mysql_query("SELECT * FROM groups WHERE name='" . $info[0] . "'");
				$row = mysql_fetch_array($result);
				$names = explode("|",$row[1]);
				if (in_array($_SESSION['user'], $names))
					$level = 1;
				$user = "(".$info[0].")";
			}
			if ($level == 1)
			{
				$time = date("H:i:s/d.m.y");
				mysql_query("INSERT INTO rwrite (user, name, modified, data) VALUES ('" .
					$user . "', '" . $info[1] . "', '" . $modified . "', '" . $_POST['data'] . "')");
				
				$result = mysql_query("SELECT * FROM rwrite WHERE modified='" . $modified . "'");	
				$row = mysql_fetch_array($result);
				$_SESSION['open'] = $row["id"];
				$message = "File saved!";
			}
			else
				$message = "Virhe! Sinulla ei ole oikeuksia tallentaa uusia tiedostoja tähän ryhmään";
		}
	}
	elseif ($operation == "new")
	{
		$message = "New file.";
		unset($_SESSION['open'],$_POST['data'],$level);
	}
	elseif ($operation == "delete")
	{
		mysql_query("DELETE FROM rwrite WHERE id='" . $_SESSION['open'] . "'");
		$message = "File has been removed!";
		unset($_SESSION['open'],$level);
	}
}
$dir = opendir("tools/");
while ($file = readdir($dir))
{
	if ($file[0] == ".")
		continue;
	if (is_dir("tools/" . $file))
	{
		$list_of_tools[] = $file;
	}
}
function tool($name) { ?>
    <div class="tools" id="<?php echo $name; ?>" onclick="if (selected != this.id) selecting(this.id)">
        <div class="head">
            <div class="title"><?php echo $name; ?></div>
            <span onmousedown="if (selected == '<?php echo $name; ?>') move = '<?php echo $name; ?>'" onmouseup="move = ''">[move]</span>
            <span onclick="if (selected == '<?php echo $name; ?>') toggle_display('<?php echo $name; ?>')">[hide]</span>        </div>
      	<?php include("tools/" . $name . "/index.php"); ?>
    </div>
<?php } ?>
<html>
    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>rWrite - Easy access notepad</title>
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="md5.js"></script>
        <script type="text/javascript" src="ajax.js"></script>
        <script type="text/javascript" src="tools.js"></script>
        <script type="text/javascript" src="script.js"></script>
	</head>
    <body onLoad="adjusment_by_resolution()<?php if ($message) echo "; alert('" . $message . "');"; ?>">
    						<?php //TOOLS:
						$i = 0;
						do {
							tool($list_of_tools[$i]);
							$i++;
						} while ($list_of_tools[$i]);
						?>

<form action="index.php" method="post" id="form">
			<?php if($_POST['HTMLcode'])
            {
                if (!$_SESSION['user'])
                    echo "<input type=\"hidden\" name=\"HTMLcode\" value=\"" . str_replace("\\\\n","\n",str_replace("\\\"","\"",$_POST['HTMLcode'])) . "\" />\n";
                else
                {
                    $_POST['data'] = str_replace("\\\\n","\n",str_replace("\\\"","\"",$_POST['HTMLcode']));
                    $message = "HTML code readed!";
                }
            }?>
			<?php if ($_SESSION['user']) { ?>
<!-- Kirjautuminen onnistunut: Valikko -->
				<div class="drop_menu" onMouseDown="document.getElementById('drop_menu_file').style.display = 'block'" onMouseOut="document.getElementById('drop_menu_file').style.display = ''">File</div>
                <div class="drop_menu_item" id="drop_menu_file" onMouseOver="document.getElementById('drop_menu_file').style.display = 'block'" onMouseOut="document.getElementById('drop_menu_file').style.display = ''">
                    <input type="button" name="q" id="new" value="new" class="button" onClick="confirm_click(this.id)" /><br \>
                    <input type="button" value="open" class="button" onClick="display('open_file')" /><br \>
                  <?php if ($level < 3) { ?>
                        <input type="submit" name="q" id="save" value="save" class="button"
                            <?php if (!$_SESSION['open']) echo "onClick=\"ask_name(this.id)\""; ?>/><br \>
                        <input type="button" name="q" id="save_as" value="saveAs" class="button" onClick="ask_name(this.id)" /><br \>
                    <?php }
                    if ($level == 1) { ?>
                        <input type="button" name="q" id="delete" value="delete" class="button" onClick="<?php if ($_SESSION['open']) echo "confirm_click"; else echo "false_action"; ?>(this.id)" /><br \>
                        <input type="button" name="q" id="rename" value="rename" class="button" onClick="<?php if ($_SESSION['open']) echo "ask_name"; else echo "false_action"; ?>(this.id)" /><br \>
                    <?php } ?>
                </div>
                <hr \>
				<div class="drop_menu" onMouseDown="document.getElementById('drop_menu_tools').style.display = 'block'" onMouseOut="document.getElementById('drop_menu_tools').style.display = ''">tools</div>
                <div class="drop_menu_item" id="drop_menu_tools" onMouseOver="document.getElementById('drop_menu_tools').style.display = 'block'" onMouseOut="document.getElementById('drop_menu_tools').style.display = ''" style="left:30px;">
              	  <?php //TOOLS:
						$i = 0;
						do {
							echo "<input type=\"button\" class=\"button\" onClick=\"toggle_display('" . $list_of_tools[$i] . "')\" value=\"" . $list_of_tools[$i] . "\" /><br \>\n";
							$i++;
						} while ($list_of_tools[$i]);
						?>
                </div>
  				<hr \>
                <input type="button" name="q" id="end" value="end" class="button" onClick="confirm_click(this.id)" />
                <input type="hidden" name="info" id="hidden_info" />

<!-- Muokattava lehti -->
                <?php if ($_SESSION['open']) {
                    echo "<span class=\"right\">";
                    $result = mysql_query("SELECT * FROM rwrite WHERE id='" . $_SESSION['open'] . "'");
                    $row = mysql_fetch_array($result);
					$timedate = explode("/",$row["modified"]);
                    echo "Now editing: " . $row['name'] . " (saved: " . $timedate[0] . " / " . $timedate[1] . " by " . $timedate[2] . ")</span>\n";
                } ?>
                <input type="hidden" id="editing" value="<?php echo $row['name']; ?>" />
                <input type="hidden" id="hidden_status" value="<?php if ($operation == "save") echo "saved"; ?>" />
                <input type="hidden" id="hidden_username" value="<?php echo $_SESSION['user']; ?>" />
                <textarea name="data" id="datafield" rows="20" <?php if ($level == 3) echo "readonly"; ?> onChange="status = 'edited'" onClick="selecting('none')"><?php if ($_POST['data']) echo $_POST['data']; ?></textarea>
<!-- Kirjautumis "ikkuna": -->
			<?php } else { ?>
                <div class="login">
                    <h1>Log in</h1>
                    Username:<input type="text" name="username" /><br />
                    Password:<input type="password" name="password" id="password" /><br />
                    <input type="submit" value="login" class="button" onClick="hash('password')" />
                </div>
			<?php } ?>
            <div id="open_file">
                <div class="centered">
                    <h1>Open</h1>
                    <select size="12" id="list_open" onChange="display(parseInt(this.value))">
                    </select>
                    <div id="right_side"></div>
                    <div class="buttons">
                        <input type="hidden" id="hidden" value="aa" />
                        <input type="button" value="cancel" onClick="display('open_file')" />
                        <hr />
                        <input type="button" name="q" id="open" value="open" onClick="confirm_click(this.id)" />
                    </div>
                </div>
            </div>
        </form>
					<?php include("tools/index.php"); ?>
	<?php if ($operation == "end") echo "thank you for using my easy access internet notepad"; ?>
    </body>
</html>
<?php mysql_close($con); ?>