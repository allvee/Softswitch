<?php

include_once "config.php";

 //echo "<pre>";
 //print_r($_POST);
//exit;
    
    if($_POST["like_dislike"] == 1){
        $likeDislike = "Like";
    }else{
        $likeDislike = "DisLike";
    }

	$query_data = jsonDataToQueryString($_POST);
	 
	$query = "INSERT INTO likes_dislikes ({$query_data['fields']}) VALUES({$query_data['values']})";

	if(mysql_query($query,$conn)){

		$result["success"] = 1;
        $message = $likeDislike." is saved successfully";
	}
	else
	{
		$result["success"] = 0;
		$message = mysql_error();
	}

	 
	$result["message"] = $message;

	echo json_encode($result);

?>