<?php

$data = $_REQUEST;
include_once "../lib/common.php";
$is_error = 0;
$cn = connectDB();
$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));

$server_ip_cs = "";
$udp_server_port = "";
$udp_rtp_port = "";
$tcp_server_port = "";
$tcp_rtp_port = "";
$log_server_ip = "";
$log_server_port = "";
$im_server_ip = "";
$im_server_port = "";
$contact_server_ip = "";
$contact_server_port = "";
$connection_type = "";
$audio_codec = "";
$rtp_connection_type = "";


$server_ip_cs = mysql_real_escape_string(htmlspecialchars($data['server_ip_cs']));
$udp_server_port = mysql_real_escape_string(htmlspecialchars($data['udp_server_port']));
$udp_rtp_port = mysql_real_escape_string(htmlspecialchars($data['udp_rtp_port']));
$tcp_server_port = mysql_real_escape_string(htmlspecialchars($data['tcp_server_port']));
$tcp_rtp_port = mysql_real_escape_string(htmlspecialchars($data['tcp_rtp_port']));
$log_server_ip = mysql_real_escape_string(htmlspecialchars($data['log_server_ip']));
$log_server_port = mysql_real_escape_string(htmlspecialchars($data['log_server_port']));

$im_server_ip = mysql_real_escape_string(htmlspecialchars($data['im_server_ip']));
$im_server_port = mysql_real_escape_string(htmlspecialchars($data['im_server_port']));
$contact_server_ip = mysql_real_escape_string(htmlspecialchars($data['contact_server_ip']));
$contact_server_port = mysql_real_escape_string(htmlspecialchars($data['contact_server_port']));
$connection_type = mysql_real_escape_string(htmlspecialchars($data['connection_type']));
$audio_codec = mysql_real_escape_string(htmlspecialchars($data['audio_codec']));
$rtp_connection_type = mysql_real_escape_string(htmlspecialchars($data['rtp_connection_type']));

if ($action == "update") {
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update `tbl_ippbx_client_settings` set `server_ip`='$server_ip_cs',`udp_server_port`='$udp_server_port'," .
            "`udp_rtp_port`='$udp_rtp_port',`tcp_server_port`='$tcp_server_port', `tcp_rtp_port`='$tcp_rtp_port',`log_server_ip`='$log_server_ip', " .
            "`log_server_port`='$log_server_port',`im_server_ip`='$im_server_ip', `im_server_port`='$im_server_port',`contact_server_ip`='$contact_server_ip', " .
            "`contact_server_port`='$contact_server_port',`connection_type`='$connection_type', `audio_codec`='$audio_codec',`rtp_connection_type`='$rtp_connection_type'";
} elseif ($action == "delete") {
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update `tbl_ippbx_client_settings` set `is_active`='inactive'";
    $qry .= " where `id`='$action_id'";
} else {
    $qry = "insert into `tbl_ippbx_client_settings` (server_ip, udp_server_port,udp_rtp_port,tcp_server_port,tcp_rtp_port," .
            "log_server_ip,log_server_port,im_server_ip,im_server_port, contact_server_ip,contact_server_port,connection_type," .
            "audio_codec, rtp_connection_type)";
    $qry .= " values ('$server_ip_cs','$udp_server_port','$udp_rtp_port','$tcp_server_port','$tcp_rtp_port','$log_server_ip','$log_server_port'," .
            "'$im_server_ip','$im_server_port','$contact_server_ip','$contact_server_port','$connection_type','$audio_codec','$rtp_connection_type')";
}


try {
    $res = Sql_exec($cn, $qry);
  
    //  echo ('ooo');

    if($action == "update" || $action == "delete"){
        
          
        
			$options['cn'] = $cn;
			$options['page_name'] = "Softswitch Client Setting";
			$options['action_type'] = $action;
			$options['table'] = "tbl_ippbx_client_settings";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         	$action = 'add';
			$options['cn'] = $cn;
			$options['page_name'] = "Softswitch Client Setting";
			$options['action_type'] = $action;
			$options['table'] = "tbl_ippbx_client_settings";
			$options['id_value'] = $action_id;
			setHistory($options);
			}
    
    
} catch (Exception $e) {
    
    
       $is_error = 1;
      
}

ClosedDBConnection($cn);


//$res = Sql_exec($cn, $qry);
if ($is_error = 1) {
    $return_data = array('status' => true, 'message' => 'Suceessfully Updated.');
    // $is_error = file_writer_vpn_ipsec($cn);
} else {
    $return_data = array('status' => false, 'message' => 'Update Failed');
}

echo json_encode($return_data);



?>