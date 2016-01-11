<?php
//session_start();
require_once  "../lib/common.php";
//require_once "../../Lib/rcportalLib.php";
require_once  "../lib/filewriter.php";

$cn = connectDB();

	$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
	
	$listen_address = 		mysql_real_escape_string(htmlspecialchars($_REQUEST['listen_address']));
	$from_ip 		= 		mysql_real_escape_string(htmlspecialchars($_REQUEST['from_ip']));
	$to_ip 			= 		mysql_real_escape_string(htmlspecialchars($_REQUEST['to_ip']));
	$local_ip 		= 		mysql_real_escape_string(htmlspecialchars($_REQUEST['local_ip']));
	$ms_dns 		= 		mysql_real_escape_string(htmlspecialchars($_REQUEST['ms-dns']));
	$ip_range 		= 		$from_ip."-".$to_ip;
	
	
	
	$is_error = 0;
//	$last_updated = date('Y-m-d H:i:s');
//	$last_updated_by = $_SESSION["USER_ID"];
	
	if($action == "update"){
		
		$qry = "update tbl_vpn_l2tp set listen_address='$listen_address',ip_range='$ip_range',local_ip='$local_ip', ms_dns='$ms_dns'";
		$qry .= " where id='$action_id'";
	} elseif($action == "delete"){
		
		$qry = "delete from tbl_vpn_l2tp where id = '$action_id'";
	} else {
		$qry = "INSERT INTO tbl_vpn_l2tp(listen_address,ip_range,local_ip,ms_dns)VALUES('$listen_address','$ip_range','$local_ip','$ms_dns')";

	}
                         
    
    
	try {
		$res = Sql_exec($cn,$qry);
	} catch (Exception $e){
		$is_error = 1;
	}

	ClosedDBConnection($cn);
	
	if($is_error == 0){
		$is_error = file_writer_xl2tp($cn);
	}
	
	echo  $is_error; 
	

?>