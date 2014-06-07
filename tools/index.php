<script type="text/javascript">
<?php
$name = "calc";
$tool[$name][] = array("left","10px");
$tool[$name][] = array("top","50px");
$tool[$name][] = array("width","160px");
$tool[$name][] = array("height","175px");

foreach($tool as $name => $info) {
	$i = 0;
	while ($info[$i])
	{
		echo "\tdocument.getElementById('" . $name . "').style." . $info[$i][0] . " = '" . $info[$i][1] . "';\n";
		$i++;
	}
}
?>
</script>