<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/11/2015
 * Time: 2:39 PM
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
$net_mask = mysql_real_escape_string(htmlspecialchars($_REQUEST['net_mask']));
$gateway = mysql_real_escape_string(htmlspecialchars($_REQUEST['gateway']));
$domain_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['domain_name']));
$domain_name_server1 = mysql_real_escape_string(htmlspecialchars($_REQUEST['domain_name_server_1']));
$domain_name_server2 = mysql_real_escape_string(htmlspecialchars($_REQUEST['domain_name_server_2']));
$netbios_name_server = mysql_real_escape_string(htmlspecialchars($_REQUEST['netbios_name_server']));
$default_lease_time = 3600;
$max_lease_time = mysql_real_escape_string(htmlspecialchars($_REQUEST['max_lease_time']));
$unit = mysql_real_escape_string(htmlspecialchars($_REQUEST['unit']));
$subnet_is_active = mysql_real_escape_string(htmlspecialchars($_REQUEST['subnet_is_active']));
$interface = mysql_real_escape_string(htmlspecialchars($_REQUEST['interface_name']));

if(strtolower($unit)=='sec'){
    $max_lease_time=(int)$max_lease_time;
}else if(strtolower($unit)=='min'){
    $max_lease_time=(int)$max_lease_time*60;
}else if(strtolower($unit)=='hour'){
    $max_lease_time=(int)$max_lease_time*60*60;
}else if(strtolower($unit)=='day'){
    $max_lease_time=(int)$max_lease_time*60*60*24;
}
$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if($action == "update"){
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update tbl_dhcp set subnet='$subnet',net_mask='$net_mask',gateway='$gateway',domain_name='$domain_name',domain_name_server1='$domain_name_server1',";
    $qry .= "last_updated='$last_updated',last_updated_by='$last_updated_by', interface='$interface',  domain_name_server2='$domain_name_server2',netbios_name_server='$netbios_name_server',default_lease_time='$default_lease_time',max_lease_time='$max_lease_time'";
    $qry .= " where id='$action_id'";
}  elseif ($action == "delete") {
    $action_id = mysql_real_escape_string(htmlspecialchars($deleted_id));
    $qry = "update tbl_dhcp set is_active='inactive',last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} else {
    $qry = "insert into tbl_dhcp (subnet,net_mask,gateway,domain_name,domain_name_server1,domain_name_server2,netbios_name_server,default_lease_time,max_lease_time, last_updated,last_updated_by,is_active,interface)";
    $qry .= " values ('$subnet','$net_mask','$gateway','$domain_name','$domain_name_server1','$domain_name_server2','$netbios_name_server','$default_lease_time','$max_lease_time','$last_updated','$last_updated_by','$subnet_is_active','$interface')";
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