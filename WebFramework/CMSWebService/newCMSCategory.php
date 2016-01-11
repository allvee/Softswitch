<?php
	include_once "config.php";

	$titleThumb = "";

    //echo "<pre>";
    //print_r($_POST); exit;
    $validationFields = array('title','catLayout','catListLayout','catListLayoutName','catListTarget','contentListTarget','contentListLayout','contentListLayoutName');
    
    /*** an array to hold errors ***/
    $errors = array();    
    
    /*** check fields have been posted ***/
    
    foreach($validationFields as $validationField){
        
        if(empty($_POST[$validationField])){
             $errors[] = $validationField.' must be given';
        }
    }
    
	// Uploading image file

	if(!empty($_FILES["titleThumb"]['name']))
    {

		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["titleThumb"]["name"]);
		$extension = end($temp);
		$_FILES["titleThumb"]["name"] = date("yis").str_replace(" ","_",$_FILES["titleThumb"]["name"]);

	//	echo "<pre>";
	//	print_r($_FILES); exit;

		if ((($_FILES["titleThumb"]["type"] == "image/gif")
		|| ($_FILES["titleThumb"]["type"] == "image/jpeg")
		|| ($_FILES["titleThumb"]["type"] == "image/jpg")
		|| ($_FILES["titleThumb"]["type"] == "image/pjpeg")
		|| ($_FILES["titleThumb"]["type"] == "image/x-png")
		|| ($_FILES["titleThumb"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts)) {

		  if ($_FILES["titleThumb"]["error"] > 0) {
			$errors[] = "Return Code: " . $_FILES["titleThumb"]["error"] . "<br>";
		  } else {

			  move_uploaded_file($_FILES["titleThumb"]["tmp_name"], $www_root ."img/" . $_FILES["titleThumb"]["name"]);

			  $titleThumb = "img/".$_FILES["titleThumb"]["name"];
              $_POST["titleThumb"] = $titleThumb;
		  }
		} else {
		  $errors[] = "Invalid file";
		}

	}


	$name = str_replace(" ","_",@$_POST['title']);

    $_POST['name'] = $name;
    $_POST['status'] = (@$_POST['status'] == "on")?1:0;

    //echo "<pre>";
    //print_r($_POST); exit;

    if(sizeof($errors) > 0)
    {
        $errHtml = "";
        foreach($errors as $err)
        {
            $errHtml.=$err.'<br />';
        }
        
        $result["success"] = 0;
        $result["message"] = $errHtml;
        
        echo json_encode($result);
    }else
    { 
   // dbInsert($_POST);
    if(empty($_POST["tbid"]))
    {
        $query_data = jsonDataToQueryString($_POST);
	    $query = "INSERT INTO category ({$query_data['fields']}) VALUES({$query_data['values']})";
                
        
        if(mysql_query($query)){
            $id = mysql_insert_id();
            $message="Data has been saved";
             $idUpdatesql = "UPDATE category SET id = '$id' WHERE tbid = ".$id."";
             mysql_query($idUpdatesql);
             $result["success"] = 1;
        }
        else
        {
             $result["success"] = 0;
             $message= substr(mysql_error(),0,-9);
        } 
    }
    else{ // updating category fields

        $id = $_POST['tbid'];
        unset($_POST['tbid']);

        $query_data = jsonEditQuery($_POST);


        $sql = "UPDATE category SET $query_data WHERE tbid = ".$id."";
       // exit;


        if(mysql_query($sql))
        {
            $result["success"] = 1;
            $message= "Data has been updated";
        }else{
              $result["success"] = 0;
             $message= substr(mysql_error(),0,-9);
        }
    }
     //exit;     
        $result["message"] = $message;
        
        echo json_encode($result);  
   }  





?>