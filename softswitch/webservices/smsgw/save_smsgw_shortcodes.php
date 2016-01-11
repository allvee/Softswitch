<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/21/2015
 * Time: 4:56 PM
 */

require_once "../lib/common.php";
$remoteCn = remote_connectDB('SMSGW');
$is_error = 1;
$action = "";
$shortcode = "";
$ErrorSMS = "";
$DefaultKeyword = "";
$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['deleted_id'];
}
if (isset($_REQUEST['info']) || isset($_REQUEST['action'])) {

    if (isset($_REQUEST['info'])) {
        $data = $_REQUEST['info'];
        $action = mysql_real_escape_string(htmlspecialchars($data['action']));
        $action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
        if (isset($data['shortcode'])) {
            $shortcode = mysql_real_escape_string(htmlspecialchars($data['shortcode']));
            $ErrorSMS = mysql_real_escape_string(htmlspecialchars($data['ErrorSMS']));
            $DefaultKeyword = mysql_real_escape_string(htmlspecialchars($data['DefaultKeyword']));
        }
    } else {
        $action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
        $shortcode = mysql_real_escape_string(htmlspecialchars($_REQUEST['shortcode']));
        $ErrorSMS = mysql_real_escape_string(htmlspecialchars($_REQUEST['ErrorSMS']));
        $DefaultKeyword = mysql_real_escape_string(htmlspecialchars($_REQUEST['DefaultKeyword']));
    }

    if ($action == "update") {
        $msg = "Successfully Updated";

        $qry = "update shortcode set shortcode='$shortcode',ErrorSMS='$ErrorSMS', DefaultKeyword='$DefaultKeyword'";
        $qry .= " where shortcode='$action_id'";
		
    } elseif ($action == "delete") {
        $action_id = $deleted_id;
        $msg = "Successfully Deleted";
        $qry = "delete from `shortcode` where `shortcode`='" . $action_id . "'";
    } else {
        $msg = "Successfully Saved";
        $qry = "insert into shortcode (shortcode,ErrorSMS,DefaultKeyword)
			 values ('$shortcode','$ErrorSMS','$DefaultKeyword')";
    }

    try {

        $res = Sql_exec($remoteCn, $qry);
		
		if($action == "update"){
			
			$action_name = $action;
			$id_val = $shortcode; 
		}else{
			$action_name = 'add';
			$id_val = $shortcode;	
		}
		
		ClosedDBConnection($remoteCn);
		rollback_main_connectDB();
		
        $is_error = 0;
		
		
		
		
		/* Audit Trail Functionality : Ensure action type value for add */
		$options['page_name'] = "SMS Gateway Shortcode";
		$options['action_type'] = $action_name;
		$options['table'] = "shortcode";
		$options['id_name'] = 'shortcode';
		$options['id_value'] = $id_val;
		$options['remote'] = true;
		$options['pname'] = 'SMSGW';
		
		setHistory($options);
			
		
			
		
    } catch (Exception $e) {

    }
	
		
}

if ($is_error) {
    $return_data = array('status' => false, 'message' => 'Submission Failed');
} else {
    $return_data = array('status' => true, 'message' => $msg);
}

echo json_encode($return_data);



?>