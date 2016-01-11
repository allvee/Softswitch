<?php
session_start();
//require_once "../../commonlib.php";
//require_once "../../Lib/filewriter.php";
include_once "../lib/common.php";

	$cn = connectDB();
	$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
	$host_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['host_name']));
	$server1 = mysql_real_escape_string(htmlspecialchars($_REQUEST['server1']));
	$server2 = mysql_real_escape_string(htmlspecialchars($_REQUEST['server2']));
	
	$last_updated = date('Y-m-d H:i:s');
	$last_updated_by = $_SESSION["USER_ID"];
	
	$is_error = 0;
	
	if($action == "update"){
		//$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['id']));
		$msg = "Successfully Updated";
		$qry = "update tbl_dns_servers set host_name='$host_name',server1='$server1',server2='$server2',last_updated='$last_updated',last_updated_by='$last_updated_by'";
		//$qry .= " where id='$action_id'";
	} else {
		$qry = "INSERT INTO tbl_dns_servers (host_name, server1, server2,last_updated,last_updated_by) VALUES ('$host_name', '$server1', '$server2','$last_updated','$last_updated_by')";
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