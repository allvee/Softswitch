<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/6/2015
 * Time: 5:52 PM
 */

require_once "../lib/common.php";
require_once "../lib/filewriter.php";

$cn = connectDB();
$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_c']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['deleted_id'];
}
$user_name = "";
$password = "";
$tbl = "tbl_vpn_pptp_client";

if (isset($_REQUEST['user_name']) && $_REQUEST['user_name']) {
    $user_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['user_name']));
    $password = mysql_real_escape_string(htmlspecialchars($_REQUEST['password']));
    $pptp_client_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['pptp_client_ip']));
    if ($pptp_client_ip == "") $pptp_client_ip = "*";
}

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if ($action == "update") {
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id_c']));
    $qry = "update $tbl set user_name='$user_name',password='$password',ip='$pptp_client_ip',last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} elseif ($action == "delete") {
    $action_id = mysql_real_escape_string(htmlspecialchars($deleted_id));
    $qry = "update $tbl set is_active='inactive',last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} else {
    $qry = "insert into $tbl (user_name,password,ip,last_updated,last_updated_by)";
    $qry .= " values ('$user_name','$password','$pptp_client_ip','$last_updated','$last_updated_by')";
}

try {
    $res = Sql_exec($cn, $qry);
		if($action!="delete"){
	if($action == "update" || $action == "delete"){
			$options['page_name'] = "VPN PPTP Clint";
			$options['action_type'] = $action;
			$options['table'] = "tbl_vpn_pptp_client";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         	$action = 'add';
			$options['page_name'] = "VPN PPTP Clint";
			$options['action_type'] = $action;
			$options['table'] = "tbl_vpn_pptp_client";
			$options['id_value'] = $action_id;
			setHistory($options);
			}
	}
} catch (Exception $e) {
    $is_error = 1;
}

ClosedDBConnection($cn);

if ($is_error == 0) {
    $return_data = array('status' => true, 'message' => 'Suceessfull.');
    $is_error = file_writer_vpn_ipsec($cn);
} else {
    $return_data = array('status' => false, 'message' => ' Unsuceessfull');
}
//echo  $is_error;

echo json_encode($return_data);
?>