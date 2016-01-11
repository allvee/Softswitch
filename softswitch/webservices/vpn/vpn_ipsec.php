<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/5/2015
 * Time: 7:49 PM
 */

require_once "../lib/common.php";

require_once "../lib/filewriter.php";

$cn = connectDB();

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$ipsec_name = "";
$type = "";
$left = "";
$leftnexthop = "";
$leftsubnet = "";
$right = "";
$rightsubnet = "";
$ike = "";
$group = "";
$esp = "";
$pfs = "";
$ikelifetime = "";
$keylife = "";
$psk = "";

if (isset($_REQUEST['ipsec_name']) && $_REQUEST['ipsec_name']) {
    $ipsec_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['ipsec_name']));
    $type = mysql_real_escape_string(htmlspecialchars($_REQUEST['type']));
    $left_v = mysql_real_escape_string(htmlspecialchars($_REQUEST['left_v']));
    $leftnexthop = mysql_real_escape_string(htmlspecialchars($_REQUEST['leftnexthop']));
    $leftsubnet = mysql_real_escape_string(htmlspecialchars($_REQUEST['leftsubnet']));
    $right_v = mysql_real_escape_string(htmlspecialchars($_REQUEST['right_v']));
    $rightsubnet = mysql_real_escape_string(htmlspecialchars($_REQUEST['rightsubnet']));
    $ike = mysql_real_escape_string(htmlspecialchars($_REQUEST['ike']));
    $group = mysql_real_escape_string(htmlspecialchars($_REQUEST['group']));
    $esp = mysql_real_escape_string(htmlspecialchars($_REQUEST['esp']));
    $pfs = mysql_real_escape_string(htmlspecialchars($_REQUEST['pfs']));
    $ikelifetime = mysql_real_escape_string(htmlspecialchars($_REQUEST['ikelifetime']));
    $keylife = mysql_real_escape_string(htmlspecialchars($_REQUEST['keylife']));
    $psk = mysql_real_escape_string(htmlspecialchars($_REQUEST['psk']));
}

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if ($action == "update") {
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update tbl_vpn_ipsec set ipsec_name='$ipsec_name',type='$type',left_v='$left_v', leftnexthop='$leftnexthop',leftsubnet='$leftsubnet',right_v='$right_v', rightsubnet='$rightsubnet', ike='$ike', group_v='$group', esp='$esp', pfs='$pfs', ikelifetime='$ikelifetime', keylife='$keylife', psk='$psk', last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} elseif ($action == "delete") {
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update tbl_vpn_ipsec set is_active='inactive', last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} else {
    $qry = "insert into tbl_vpn_ipsec (ipsec_name,type,left_v,leftnexthop,leftsubnet,right_v,rightsubnet,ike,group_v,esp,pfs,ikelifetime,keylife,psk,last_updated,last_updated_by)";
    $qry .= " values ('$ipsec_name','$type','$left','$leftnexthop','$leftsubnet','$right','$rightsubnet','$ike','$group','$esp','$pfs','$ikelifetime','$keylife','$psk', '$last_updated','$last_updated_by')";
}


try {
    $res = Sql_exec($cn, $qry);	
	if($action!="delete"){
	if($action == "update" || $action == "delete"){
			$options['page_name'] = "VPN IPSec";
			$options['action_type'] = $action;
			$options['table'] = "tbl_vpn_ipsec";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         	$action = 'add';
			$options['page_name'] = "VPN IPSec";
			$options['action_type'] = $action;
			$options['table'] = "tbl_vpn_ipsec";
			$options['id_value'] = $action_id;
			setHistory($options);
			}
	}
} catch (Exception $e) {
    $is_error = 1;
}

ClosedDBConnection($cn);

if ($is_error == 0) {
    $return_data = array('status' => true, 'message' => 'Suceessfully Saved.');
   // $is_error = file_writer_vpn_ipsec($cn);
} else {
    $return_data = array('status' => false, 'message' => 'Data Not Saved.');
}
//echo  $is_error;

echo json_encode($return_data);

?>