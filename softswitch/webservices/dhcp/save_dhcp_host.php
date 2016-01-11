<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/12/2015
 * Time: 6:53 PM
 */
require_once "../lib/common.php";
require_once "../lib/filewriter.php";

$cn = connectDB();

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['deleted_id'];
}



$subnet = mysql_real_escape_string(htmlspecialchars($_REQUEST['subnet']));
$host_user = mysql_real_escape_string(htmlspecialchars($_REQUEST['host_user']));
$host_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['host_name']));
$hd_ethernet = mysql_real_escape_string(htmlspecialchars($_REQUEST['hd_ethernet']));
$fixed_address = mysql_real_escape_string(htmlspecialchars($_REQUEST['fixed_address']));
$subnet_host_is_active = mysql_real_escape_string(htmlspecialchars($_REQUEST['subnet_host_is_active']));

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if($action == "update"){
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update tbl_dhcp_host set dhcp_id='$subnet',host_user='$host_user',host_name='$host_name',hd_ethernet='$hd_ethernet',fixed_address='$fixed_address', last_updated='$last_updated',last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} elseif ($action == "delete"){
    $action_id = mysql_real_escape_string(htmlspecialchars($deleted_id));
    $qry = "update tbl_dhcp_host set is_active='inactive',last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";

} else {
    $qry = "insert into tbl_dhcp_host (dhcp_id,host_user,host_name,hd_ethernet,fixed_address,last_updated,last_updated_by,is_active)";
    $qry .= " values ('$subnet','$host_user', '$host_name','$hd_ethernet', '$fixed_address', '$last_updated', '$last_updated_by', '$subnet_host_is_active')";

}


try {
    $res = Sql_exec($cn, $qry);
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