<?php

include_once "config.php";

$imageUrl = "";

 //echo "<pre>";
// print_r($_POST);
//exit;
$validationFields = array('title','details');

    //////Dynamic form content processing//////////////
        
    $dynamicFormFields = array("cmsformLayout","statusDiv","cmsContentAdd","cmsContentList","contentFormHeader","cmsFormDiv","cmsContentForm","addEditURL","deleteURL","listURL","contentExtraField","contentSubmitButton","contentSubmitButtonText","addAction","editAction","listAction","deleteAction","defaultDisplayAction");
    
    if($_POST["type"] == "TEXT")
    { 
        $_POST['formData'] = "";      
    }
    else if($_POST["type"] == "FORM")
    {
        // formData variable processing
        $formFieldData = array();
        foreach($dynamicFormFields as $dynamicFormField){ 
            if( ($dynamicFormField == "addAction") || ($dynamicFormField == "editAction") || ($dynamicFormField == "listAction") || ($dynamicFormField == "deleteAction") ){
                $formFieldData[$dynamicFormField] = (@$_POST[$dynamicFormField] == "on")?1:0;
            }else{
                $formFieldData[$dynamicFormField] = $_POST[$dynamicFormField];
            }
        }                 
        $_POST['formData'] = json_encode($formFieldData);            
    }
    
    foreach($dynamicFormFields as $dynamicFormField){                
        unset($_POST[$dynamicFormField]); // unsetting dynamic form fields for content type TEXT
    } 
    
    ////////////////////    
    
 //echo "<pre>";
 //print_r($_POST);
//exit;

/*** an array to hold errors ***/
$errors = array();

/*** check fields have been posted ***/

foreach($validationFields as $validationField){

	if(empty($_POST[$validationField])){
		$errors[] = $validationField.' must be given';
	}
}

// Uploading image file

if(!empty($_FILES["url"]['name']))
{

	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["url"]["name"]);
	$extension = end($temp);
	$_FILES["url"]["name"] = date("yis").str_replace(" ","_",$_FILES["url"]["name"]);

	//	echo "<pre>";
	//	print_r($_FILES); exit;

	if ((($_FILES["url"]["type"] == "image/gif")
		|| ($_FILES["url"]["type"] == "image/jpeg")
		|| ($_FILES["url"]["type"] == "image/jpg")
		|| ($_FILES["url"]["type"] == "image/pjpeg")
		|| ($_FILES["url"]["type"] == "image/x-png")
		|| ($_FILES["url"]["type"] == "image/png"))
		&& in_array($extension, $allowedExts)) {

		if ($_FILES["url"]["error"] > 0) {
			$errors[] = "Return Code: " . $_FILES["url"]["error"] . "<br>";
		} else {

			move_uploaded_file($_FILES["url"]["tmp_name"], $www_root ."img/" . $_FILES["url"]["name"]);

			$imageUrl = "img/".$_FILES["url"]["name"];
			$_POST["url"] = $imageUrl;
		}
	} else {
		$errors[] = "Invalid file extension";
	}

}
 
$_POST['status'] = (@$_POST['status'] == "on")?1:0;
$_POST['allow_like'] = (@$_POST['allow_like'] == "on")?1:0;
$_POST['allow_comment'] = (@$_POST['allow_comment'] == "on")?1:0;

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
}else{

	if(empty($_POST["cid"]))
	{
		$query_data = jsonDataToQueryString($_POST);
		 

		$query = "INSERT INTO content ({$query_data['fields']}) VALUES({$query_data['values']})";
		
		
		// print_r( mysql_query($query) ); exit;

		if(mysql_query($query,$conn)){
			$id = mysql_insert_id();
			$message="Data has been saved";
			$idUpdatesql = "UPDATE content SET id = '$id' WHERE cid = ".$id."";
			mysql_query($idUpdatesql);
			$result["success"] = 1;
		}
		else
		{
			$result["success"] = 0;
			$message= substr(mysql_error(),0,-9);
		}
	}
	else // updating category fields
	{

		$id = $_POST['cid'];
		unset($_POST['cid']);

		$query_data = jsonEditQuery($_POST);
		

		//echo "<pre>";
		//print_r($query_data); exit;


		$sql = "UPDATE content SET $query_data WHERE id = ".$id."";
		
		// exit;


		if(mysql_query($sql))
		{
			$message= "Data has been updated";
			$result["success"] = 1;
		}else{
			$message= substr(mysql_error(),0,-9);
			$result["success"] = 0;
		}
	}
	//exit;
	 
	$result["message"] = $message;

	echo json_encode($result);
}

 
?>