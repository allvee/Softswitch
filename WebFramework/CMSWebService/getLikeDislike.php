<?php
	include_once "config.php";
    $likedislike = $_POST;
	$query = "SELECT * FROM likes_dislikes WHERE content_id = {$likedislike['content_id']}"; 
	$result = mysql_query($query) or die(mysql_error());

	$str=formatJSON($result);
	echo($str);

?>