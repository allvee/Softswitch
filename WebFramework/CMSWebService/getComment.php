<?php
	include_once "config.php";
    $comment = $_POST;
	$query = "SELECT * FROM comment WHERE content_id = {$comment['content_id']}";
	$result = mysql_query($query) or die(mysql_error());

	$str=formatJSON($result);
	echo($str);

?>