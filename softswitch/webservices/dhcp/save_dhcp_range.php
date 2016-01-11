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
$range_start = mysql_real_escape_string(htmlspecialchars($_REQUEST['range_start']));
$range_end = mysql_real_escape_string(htmlspecialchars($_REQUEST['range_end']));
$subnet_range_is_active = mysql_real_escape_string(htmlspecialchars($_REQUEST['subnet_range_is_active']));
$ip_c_s = explode('.', $range_start);
$ip_c_e = explode('.', $range_end);
$ip_count = $ip_c_start[3] - $ip_c_end[3];
$ip_count = (int)$ip_count;

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];
if ($action == "update") {
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update tbl_dhcp_range set dhcp_id='$subnet',range_start='$range_start',range_end='$range_end', last_updated='$last_updated', last_updated_by='$last_updated_by',ip_count='$ip_count'";
    $qry .= " where id='$action_id'";
} elseif ($action == "delete") {
    $action_id = mysql_real_escape_string(htmlspecialchars($deleted_id));
    $qry = "update tbl_dhcp_range set is_active='inactive',last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} else {
    $qry = "insert into tbl_dhcp_range (dhcp_id,range_start,range_end,last_updated,last_updated_by,is_active,ip_count)";
    $qry .= " values ('$subnet','$range_start','$range_end','$last_updated','$last_updated_by','$subnet_range_is_active','$ip_count')";
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