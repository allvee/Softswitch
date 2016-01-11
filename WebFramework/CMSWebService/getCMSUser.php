<?php
	include_once "config.php";
	
	if(isset($_POST['id'])){
		
		$query = "SELECT * FROM users WHERE id = '{$_POST['id']}'";
		$result = mysql_query($query) or die(mysql_error());
		
		$str=formatJSON($result);
		echo($str);
	}else{
		$query = "SELECT * FROM users";
		$result = mysql_query($query) or die(mysql_error());
		
		$str=formatJSON($result);
		echo($str);
	}
	
	 
	
?>