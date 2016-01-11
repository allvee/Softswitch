<?php
	include_once "config.php";

	$query = "SELECT * FROM content"; 
	$result = mysql_query($query) or die(mysql_error());

	$str=formatJSON($result);
	echo($str);

?>