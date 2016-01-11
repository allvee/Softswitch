<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/6/2015
 * Time: 5:51 PM
 */


require_once "../lib/common.php";
require_once "../lib/filewriter.php";

$cn = connectDB();

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_s']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['deleted_id'];
}
$local_ip = "";
$remote_ip = "";
$tbl = "tbl_pptp_server";

if (isset($_REQUEST['local_ip']) && $_REQUEST['local_ip']) {
    $local_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['local_ip']));
    $remote_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['remote_ip']));
}

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if ($action == "update") {
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id_s']));
    $qry = "update $tbl set local_ip='$local_ip',remote_ip='$remote_ip', last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} elseif ($action == "delete") {
    $action_id = mysql_real_escape_string(htmlspecialchars($deleted_id));
    $qry = "update $tbl set is_active='inactive',last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} else {
    $qry = "insert into $tbl (local_ip,remote_ip,last_updated,last_updated_by)";
    $qry .= " values ('$local_ip','$remote_ip','$last_updated','$last_updated_by')";
}


try {
    $res = Sql_exec($cn, $qry);
		if($action!="delete"){
	if($action == "update" || $action == "delete"){
			$options['page_name'] = "VPN PPTP Server";
			$options['action_type'] = $action;
			$options['table'] = "tbl_pptp_server";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         	$action = 'add';
			$options['page_name'] = "VPN PPTP Server";
			$options['action_type'] = $action;
			$options['table'] = "tbl_pptp_server";
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