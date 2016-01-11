<?php
	include_once "config.php";

	$layid = $_GET['layoutid'];
	$query = "SELECT * FROM layout where id = '$layid' LIMIT 0,1"; 
	$result = mysql_query($query) or die(mysql_error());

	$str=formatJSON($result);
	echo($str);

?>