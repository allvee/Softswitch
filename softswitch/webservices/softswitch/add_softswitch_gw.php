<?php
/**
 * Created by PhpStorm.
 * User: Plabon Dutta
 * Date: 26-Jul-15
 * Time: 12:34 PM
 */


    include_once "../lib/common.php";


    $cn = connectDB();

    $action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));

    $data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
    if ($data_info != 'action') {
        $action = $data_info['action'];
        $deleted_id = $data_info['action_id'];
    }
    $gw_auth='0';
    $tbl = "tbl_softswitch_gateway";
    $is_error = 0;
    //$last_updated = date('Y-m-d H:i:s');
    //$last_updated_by = $_SESSION["UserID"];

    if ($action != "delete") {
        $soft_gw_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_gw_name']));
        $soft_gw_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_gw_ip']));
        $soft_gw_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_gw_port']));
	 $gw_ep_type = mysql_real_escape_string(htmlspecialchars($_REQUEST['gw_ep_type']));
        $authentication = mysql_real_escape_string(htmlspecialchars($_REQUEST['authentication']));
        $gw_user_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['gw_user_name']));
        $gw_password = mysql_real_escape_string(htmlspecialchars($_REQUEST['gw_password']));
        $gw_type = mysql_real_escape_string(htmlspecialchars($_REQUEST['gw_type']));
	$gw_auth = mysql_real_escape_string(htmlspecialchars($_REQUEST['authentication']));
    }
if($_REQUEST['authentication']!=1)
     $gw_auth=0;
if ($action == "update") {
        $msg = "Successfully Updated";
        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
        $qry = "update $tbl set `name`='$soft_gw_name',`ip_address`='$soft_gw_ip', `port`='$soft_gw_port', `user_name`='$gw_user_name', `password`='$gw_password', `type`='$gw_type',`ep_type`='$gw_ep_type'";
        $qry .= " where id='$action_id'";

    } elseif ($action == "delete") {

        $action_id = $deleted_id;
        $qry = "update $tbl set is_active='inactive'";
        $qry .= " where id='$action_id'";

        $msg = "Successfully Deleted";

    } else {
        $msg = "Successfully Saved";
        $qry = "insert into $tbl (`name`,`ip_address`,`port`,`user_name`,`password`,`type`,`is_active`,`ep_type`,`auth`) values
    ('$soft_gw_name','$soft_gw_ip','$soft_gw_port','$gw_user_name','$gw_password','$gw_type','active','$gw_ep_type','$gw_auth')";
    }

    try {
        $res = Sql_exec($cn, $qry);
        $is_error = 0;
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

?>


