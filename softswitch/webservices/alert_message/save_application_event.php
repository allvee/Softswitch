<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/24/2015
 * Time: 1:26 PM
 */

include_once "../lib/common.php";

$cn = connectDB();

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['action_id'];
}

$tbl = "tbl_alert_application_detail";
$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if ($action != "delete"){

    if(isset($_REQUEST['app_select'])){
        $app=$_REQUEST['app_select'];
    }else{
        $app=$_REQUEST['app_name'];
        $qry="insert into `tbl_alert_application_name` (app_name) values ('$app')";
        try {
            $res = Sql_exec($cn, $qry);
        } catch (Exception $e) {
            $return_data = array('status' => false, 'message' => 'Submission Failed');
            echo json_encode($return_data);
            exit;
        }
    }
    $event = mysql_real_escape_string(htmlspecialchars($_REQUEST['event_select']));
    $app_msg = mysql_real_escape_string(htmlspecialchars($_REQUEST['app_msg']));
}

if ($action == "update") {
    $msg = "Successfully Updated";
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update $tbl set `app_name`='$app',`event_name`='$event', `message`='$app_msg', last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} elseif ($action == "delete") {

    $action_id = $deleted_id;
    $qry = "update $tbl set is_active='inactive'";
    $qry .= " where id='$action_id'";

    $msg = "Successfully Deleted";

} else {
    $msg = "Successfully Saved";
    $qry = "insert into $tbl (`app_name`,`event_name`,`message`,last_updated,last_updated_by,is_active) values
      ('$app','$event','$app_msg','$last_updated','$last_updated_by','active')";
}

try {
    $res = Sql_exec($cn, $qry);
	if($action!="delete"){
	if($action == "update"){
			$options['page_name'] = "New Application Event Message";
			$options['action_type'] = $action;
			$options['table'] = "tbl_alert_application_detail";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         	$action = 'add';
			$options['page_name'] = "New Application Event Message";
			$options['action_type'] = $action;
			$options['table'] = "tbl_alert_application_detail";
			$options['id_value'] = $action_id;
			setHistory($options);
			}
	}
} catch (Exception $e) {
    $is_error = 1;
}

ClosedDBConnection($cn);

if ($is_error==1) {
    $return_data = array('status' => false, 'message' => 'Submission Failed');
} else {
    $return_data = array('status' => true, 'message' => $msg);
}

echo json_encode($return_data);

?>