<?php

include_once "config.php";

// echo "<pre>";
// print_r($_POST);
//exit;

	$query_data = jsonDataToQueryString($_POST);

	$query = "INSERT INTO comment ({$query_data['fields']}) VALUES({$query_data['values']})";

	if(mysql_query($query,$conn)){

		$result["success"] = 1;
        $message= $_POST["comment"];
	}
	else
	{
		$result["success"] = 0;
		$message= substr(mysql_error(),0,-9);
	}


	$result["message"] = $message;

	echo json_encode($result);

?>