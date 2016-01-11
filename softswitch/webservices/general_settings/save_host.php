<?php

session_start();
//require_once "../../commonlib.php";
//require_once "../../Lib/filewriter.php";
include_once "../lib/common.php";
	
	$cn = connectDB();
	$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
	$host_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['host_name1']));
	$ip = '0.0.0.0';
	
	$last_updated = date('Y-m-d H:i:s');
	$last_updated_by = $_SESSION["UserID"];
	
	$is_error = 0;
		//print_r($_SESSION);
		if($action == "insert"){
		$msg = "Successfully Saved";
		$qry = "INSERT INTO tbl_hosts (host_name,IP,last_updated, last_updated_by)VALUES('$host_name', '$ip','$last_updated', '$last_updated_by')";
		}
    
//echo $qry;

try {
    $res = Sql_exec($cn, $qry);
} catch (Exception $e) {
    $is_error = 1;
}

ClosedDBConnection($cn);

if ($is_error == 1) {
    $return_data = array('status' => false, 'message' => 'Submission Failed');
} else {
    $return_data = array('status' => true, 'message' => $msg);
}

//$msg="dssd";
//echo $msg;

echo json_encode($return_data);
	

?>