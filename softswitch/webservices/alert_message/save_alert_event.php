<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/14/2015
 * Time: 12:55 PM
 * Edited by Talemul Islam on 5/23/2015
 */

isset($_REQUEST) ? 1 : exit;

$name = $_REQUEST['event_name'];
$msg = $_REQUEST['event_msg'];

require_once "../lib/common.php";
//require_once "../../Lib/rcportalLib.php";
require_once "../lib/filewriter.php";

$cn = connectDB();

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['action_id'];
}
$tbl = "tbl_alert_event";

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if ($action == "update") {
    $name = mysql_real_escape_string(htmlspecialchars($_REQUEST['event_name']));
    $msg = mysql_real_escape_string(htmlspecialchars($_REQUEST['event_msg']));
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update $tbl set name='$name', message='$msg', last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} elseif ($action == "delete") {
     $action_id = $deleted_id;
    $qry = "update $tbl set is_active='inactive',last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} else {
    $name = mysql_real_escape_string(htmlspecialchars($_REQUEST['event_name']));
    $msg = mysql_real_escape_string(htmlspecialchars($_REQUEST['event_msg']));
    $qry = "insert into $tbl (name,message,last_updated,last_updated_by,is_active)";
    $qry .= " values ('$name','$msg','$last_updated','$last_updated_by','active')";
}

try {
    $res = Sql_exec($cn, $qry);
	if($action!="delete"){
	if($action == "update"){
			$options['page_name'] = "Alert Managrment Event";
			$options['action_type'] = $action;
			$options['table'] = "tbl_alert_event";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         		$action = 'add';
			$options['page_name'] = "Alert Managrment Event";
			$options['action_type'] = $action;
			$options['table'] = "tbl_alert_event";
			$options['id_value'] = $action_id;
			setHistory($options);
			}
	}
} catch (Exception $e) {
    $is_error = 1;
}

if ($res) {
    $return_data = array('status' => true, 'message' => 'Suceessfully Saved.');
    // $is_error = file_writer_vpn_ipsec($cn);
} else {
    $return_data = array('status' => false, 'message' => 'Data Not Saved.');
}

ClosedDBConnection($cn);

echo json_encode($return_data);

?>

