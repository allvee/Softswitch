<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/21/2015
 * Time: 4:56 PM
 */

include_once "../lib/common.php";
$remoteCn = remote_connectDB('SMSGW');
$is_error = 1;
$action = "";
$shortcode = "";
$keyword = "";
$ServiceID = "";
$SrcType = "";
$URL = "";
$Status = "";

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['deleted_id'];
}

$Shortcode = mysql_real_escape_string(htmlspecialchars($_REQUEST['Shortcode']));
$ServiceID = mysql_real_escape_string(htmlspecialchars($_REQUEST['ServiceID']));
$Tps = mysql_real_escape_string(htmlspecialchars($_REQUEST['Tps']));
$SMSClientID = mysql_real_escape_string(htmlspecialchars($_REQUEST['SMSClientID']));

$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));



    if ($action == "update") {
        $msg = "Successfully Updated";
        $qry = "update `tps` set `ShortCode`='$Shortcode',  `ServiceID`='$ServiceID',`Tps`='$Tps',`SMSClientID`='$SMSClientID'";
        $qry .= " where `id`='$action_id'";
    } elseif ($action == "delete") {
        $action_id = $deleted_id;
        $msg = "Successfully Deleted";
        $qry = "delete from `tps` where `id`='" . $action_id . "'";
    } else {

        $msg = "Successfully Saved";
        $qry = "insert into `tps`( `Shortcode`,`ServiceID`, `Tps`,  `SMSClientID`) values ('$Shortcode','$ServiceID','$Tps','$SMSClientID')";
    }

    try {

        $res = Sql_exec($remoteCn, $qry);
        $is_error = 0;
		if($action!="delete"){
			if($action == "update"){
			
				$action_name = $action;
				$id_val = $action_id;
			}else{
				$action_name = 'add';
				$id_val = Sql_insert_id($remoteCn);
					
			}
		}
		
		ClosedDBConnection($remoteCn);
		rollback_main_connectDB();
		$options['page_name'] = "SMS Gateway TPS";
		$options['action_type'] = $action_name;
		$options['table'] = "tps";
		$options['id_value'] = $id_val;
		$options['remote'] = true;
		$options['pname'] = 'SMSGW';

		
		
		setHistory($options);
    } catch (Exception $e) {

    }

    if ($is_error) {
        $return_data = array('status' => false, 'message' => 'Submission Failed');
    } else {
        $return_data = array('status' => true, 'message' => $msg);
    }

echo json_encode($return_data);

ClosedDBConnection($remoteCn);
?>