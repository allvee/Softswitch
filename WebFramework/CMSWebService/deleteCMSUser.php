<?php
	include_once "config.php";
	$id = $_POST;
	$query = "DELETE FROM users WHERE id = {$id['id']}"; 
	$result = mysql_query($query) or die(mysql_error());
	$str=formatJSON($result);
	echo($str);
?>