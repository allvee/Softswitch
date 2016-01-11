<?php
	include_once "config.php";

	$query = "SELECT * FROM users WHERE username='{$_POST['username']}' AND password ='{$_POST['password']}'";

	$result = mysql_query($query);
	$login = formatJSON($result);
	
	if ($login == '[]'){
		echo false;
	}else{
		echo $login;
	}
	die();
?>