<?php
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
    <div class="tools" id="<?php echo "tool_" . $name; ?>" onclick="if (selected != this.id) selecting(this.id)">
        <div class="head">
            <div class="title"><?php echo $name; ?></div>
            <span onmousedown="if (selected == '<?php echo "tool_" . $name; ?>') move = '<?php echo "tool_" . $name; ?>'" onmouseup="move = ''">[move]</span>
            <span onclick="toggle_display('<?php echo "tool_" . $name; ?>',1)">[hide]</span>
        </div>
      	<?php include("tools/" . $name . "/index.php"); ?>
    </div>
<?php } ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Window</title>
        <link type="text/css" rel="stylesheet" href="style.css" />
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
    <p><?php
		$i = 0;
		do {
			echo "<input type=\"button\" onclick=\"toggle_display('" . $list_of_tools[$i] . "')\" value=\"" . $list_of_tools[$i] . "\" />\n";
			$i++;
		} while ($list_of_tools[$i]);
		?></p>
        <textarea cols="100" rows="20" onclick="selecting('none')"></textarea>
        <?php
		$i = 0;
		do {
			tool($list_of_tools[$i]);
			$i++;
		} while ($list_of_tools[$i]);
		?>
    </body>
    <?php include("tools/index.php"); ?>
</html>
