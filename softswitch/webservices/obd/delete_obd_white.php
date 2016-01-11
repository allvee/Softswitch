<?php
session_start();
require_once "../lib/common.php";


$cn = connectDB();
$is_error = 1;
if (isset($_REQUEST['info'])) {
    $data = $_REQUEST['info'];
    $action = $data['action'];
    $action_id = $data['action_id'];
	
	$arr = explode("S", $action_id);
	$server_id = $arr[1];
	$arr[0] = str_replace('D', '-', $arr[0]);
	$arr[0] = str_replace('T', ' ', $arr[0]);
	$time_stamp = str_replace('C', ':', $arr[0]);

	
	$err_field = array();
	$count = 0;
	$seperator = "";
	$user_id = $_SESSION['USER_ID'];
	

	if($action == "insert" ){
		$qry = "insert into tbl_obd_white_list (";	
		$values = "";	
	} elseif($action == "update") {
		$qry = "update tbl_obd_white_list set ";		
	} elseif($action == "delete"){
		//$qry = "update tbl_obd_dnd_list set is_active='inactive' where is_active='active'";
		//$qry = "DELETE FROM `tbl_obd_dnd_list` WHERE `user_id`='".$user_id."' AND `server_id`='".$server_id."'";
		$qry = "DELETE FROM `tbl_obd_white_list` WHERE `server_id`='".$server_id."' AND `time_stamp`='".$time_stamp."'";
	}

	
	
	try {
		$res = Sql_exec($cn, $qry);
		$is_error = 0;
	} catch (Exception $e) {
		
		
	}
}
	if ($is_error) {
    	$return_data = array('status' => false, 'message' => 'Data Not Saved.');
	} else {
		$return_data = array('status' => true, 'message' => 'Successfully Deleted');
	   // $is_error = file_writer_vpn_ipsec($cn);
	}
	
	echo json_encode($return_data);

ClosedDBConnection($cn);

?>

