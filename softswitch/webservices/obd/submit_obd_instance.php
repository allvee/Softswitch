<?php
session_start();
/*$return_data = array('status' => false, 'message' => 'Data Not Saved.');
echo json_encode($return_data);
exit;*/
include_once "../lib/common.php";
//	$action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
	
	//var_dump($_FILES);
	$is_error = 1;
	$err_field = array();
	$count = 0;
	$seperator = "";
	//$upload_directory_for_obd_prompt_upload = "D://";
	$upload_directory_for_obd_prompt_upload = "/var/www/html/ocmportal_new/rcportal/download/obd_upload_prompt/";
	$uploaddir = $upload_directory_for_obd_prompt_upload;
	$existingFile = "/var/www/html/ocmportal_new/rcportal/download/"; // $_REQUEST['prompt_location'];
	
	$cn = connectDB();
	//$existingFile = $_REQUEST['prompt_location'];
	foreach($_FILES as $file){
		
		if(file_exists($uploaddir .basename($file['name']))) 
			unlink($uploaddir .basename($file['name']));
		//echo $file['tmp_name'];
		//if(move_uploaded_file($file['tmp_name'], $uploaddir.basename($existingFile)))
		move_uploaded_file($file['tmp_name'], $uploaddir);
		if(move_uploaded_file($file['tmp_name'], $existingFile))
		{
			//$files[] = $uploaddir .$file['name'];
			$files[] = $uploaddir .$file['tmp_name'];
		//	echo 'sad';
		}
		else {
			$is_error = 2;
		}
	}
	
	if($is_error){
		
		$user_id = $_SESSION['USERID'];
		$server_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['server_id']));
		$display_no = mysql_real_escape_string(htmlspecialchars($_REQUEST['display_number']));
		$original_no = mysql_real_escape_string(htmlspecialchars($_REQUEST['original_number']));
		$schedule_date = mysql_real_escape_string(htmlspecialchars($_REQUEST['schedule_date']));
		$service_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['service_name']));
		$prompt_location = mysql_real_escape_string(htmlspecialchars($_REQUEST['prompt_location']));
		$is_active = 'active';//mysql_real_escape_string(htmlspecialchars($_REQUEST['is_active']));	
		$white_list = mysql_real_escape_string(htmlspecialchars($_REQUEST['white_list']));	
			
		$qry = "INSERT INTO `tbl_obd_instance_list` (`user_id`, `server_id`, `display_no`, `original_no`, `schedule_date`, `service_id`, `prompt_location`,`id_operator_distribution`, `is_active`)";	
		$qry .= " values ('$user_id','$server_id','$display_no','$original_no', '$schedule_date', '$service_id', '$prompt_location', '$white_list','active')";
		
		
		try {
			$res = Sql_exec($cn,$qry);
			$is_error = 0;
		} catch (Exception $e){
			
			array_push($err_field,$qry);
		}
	}
	
	
    if ($is_error) {
    	$return_data = array('status' => false, 'message' => 'Data Not Saved.');
	} else {
		$return_data = array('status' => true, 'message' => 'Suceessfully Saved.');
	   // $is_error = file_writer_vpn_ipsec($cn);
	}
	
	echo json_encode($return_data);
	
	ClosedDBConnection($cn);
	
	//echo $is_error;
?>
 