<?php

session_start();
//require_once "../.././commonlib.php";
//require_once "../../Lib/filewriter.php";
include_once "../lib/common.php";


    $action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
   $data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
    if ($data_info != 'action') {
    $action = $data_info['action'];
    $action_id = $data_info['action_id'];
}

if (!empty($_POST))
{
	$cn = connectDB();
	
	
	$is_error = 0;
	$err_field = array();
	$count = 0;
	$seperator = "";
	if($action == "insert"){
		$msg = "Successfully Inserted";
		$qry = "insert into tbl_ch_call_routing (";	
		$values = "";	
	} elseif($action == "update") {
		$msg = "Successfully Updated";
		$qry = "update tbl_ch_call_routing set ";		
	} elseif($action == "delete"){
		$msg = "Successfully Deleted";
		$qry = "delete from tbl_hosts where host_name='$action_id'";
	}
	
	/*
	
	foreach($_POST as $pname => $pvalue){
		$pname = mysql_real_escape_string(htmlspecialchars(trim($pname)));
		$$pname = mysql_real_escape_string(htmlspecialchars(trim($pvalue)));
			
		if(!($pname == "action" || $pname == "action_id")){
			if($count>0){
				$seperator = ",";
			}
			
			if($action == "insert"){
				$qry .= $seperator.$pname;
				$values .= $seperator."'".$$pname."'";
			} elseif($action == "update") {
				$qry .= $seperator." ".$pname."='".$$pname."'";
			}
			$count++;
		}
	}
	
	if($action == "insert"){
		$qry .= ") values (".$values.")";
	} elseif($action == "update") {
		$qry .= "  where is_active='active' and id = '$action_id'";
	}
*/	
	

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

echo json_encode($return_data);
}

?>