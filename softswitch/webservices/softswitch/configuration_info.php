<?php
$data = $_REQUEST;

require_once "../lib/config.php";
require_once "../lib/common.php";

$cn = connectDB();


$arrayInput = $_REQUEST;
$is_error = 0;

$file_name = $dir_softswitch_ippbx_config."conf.ini";

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['action_id'];
}

$tbl = "tbl_ippbx_configuration";
$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

 
if ($action != "delete") {

    $udp_bind_ip = $data['udp_bind_ip'];
    $udp_signaling_port = $data['udp_signaling_port'];
    $udp_signaling_protocol = $data['udp_signaling_protocol'];
    $udp_media_port = $data['udp_media_port'];
    $udp_media_protocol = $data['udp_media_protocol'];

    $tcp_bind_ip = $data['tcp_bind_ip'];
    $tcp_signaling_port = $data['tcp_signaling_port'];
    $tcp_signaling_protocol = $data['tcp_signaling_protocol'];
    $tcp_media_port = $data['tcp_media_port'];
    $tcp_media_protocol = $data['tcp_media_protocol'];

    $log_level = $data['log_level'];
    $log_destination = $data['log_destination'];
    $rcportal_control_udp_port = $data['rcportal_control_udp_port'];
    $log_tcp_port = $data['log_tcp_port'];
}

if ($action == "update") {

    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));

    $qry = "update $tbl set udp_bind_ip='$udp_bind_ip'," .
        "udp_signaling_port='$udp_signaling_port', udp_signaling_protocol='$udp_signaling_protocol'," .
        "udp_media_port='$udp_media_port',udp_media_protocol='$udp_media_protocol'," .
        "tcp_bind_ip='$tcp_bind_ip',tcp_signaling_port='$tcp_signaling_port', " .
        "tcp_signaling_protocol='$tcp_signaling_protocol',tcp_media_port='$tcp_media_port'," .
        "tcp_media_protocol='$tcp_media_protocol',log_level='$log_level',log_destination='$log_destination'," .
        "rcportal_control_udp_port='$rcportal_control_udp_port',log_tcp_port='$log_tcp_port'," .
        "last_updated='$last_updated',last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";

} elseif ($action == "delete") {

    $action_id = $deleted_id;

    $qry = "update $tbl set is_active='inactive'";
    $qry .= " where id='$action_id'";

} else {

    $qry = "insert into $tbl (udp_bind_ip, udp_signaling_port,udp_signaling_protocol,
				udp_media_port,udp_media_protocol,tcp_bind_ip, tcp_signaling_port, tcp_signaling_protocol,
				tcp_media_port, tcp_media_protocol,log_level, log_destination, rcportal_control_udp_port, 
				log_tcp_port,last_updated,last_updated_by,is_active) values ('$udp_bind_ip','$udp_signaling_port','$udp_signaling_protocol',
				'$udp_media_port','$udp_media_protocol','$tcp_bind_ip','$tcp_signaling_port',
				'$tcp_signaling_protocol','$tcp_media_port','$tcp_media_protocol','$log_level',
				'$log_destination','$rcportal_control_udp_port','$log_tcp_port','$last_updated','$last_updated_by','active')";



$file = fopen($file_name,"a");


fwrite($file,trim($arrayInput['udp_bind_ip'])." ");
fwrite($file,trim($arrayInput['udp_signaling_port'])." ");
fwrite($file,trim($arrayInput['udp_signaling_protocol'])." ");
fwrite($file,trim($arrayInput['udp_media_port'])." ");
fwrite($file,trim($arrayInput['udp_media_protocol'])." ");
fwrite($file,'//udp_bind_ip    udp_signaling_port    udp_signaling_protocol  udp_media_port  udp_media_protocol'."\n");

fwrite($file,trim($arrayInput['tcp_bind_ip'])." ");
fwrite($file,trim($arrayInput['tcp_signaling_port'])." ");
fwrite($file,trim($arrayInput['tcp_signaling_protocol'])." ");
fwrite($file,trim($arrayInput['tcp_media_port'])." ");
fwrite($file,trim($arrayInput['tcp_media_protocol'])." ");
fwrite($file,'//tcp_bind_ip    tcp_signaling_port    tcp_signaling_protocol tcp_media_port  tcp_media_protocol'."\n");

fwrite($file,trim($arrayInput['log_level'])." ");
fwrite($file,trim($arrayInput['log_destination'])." ");
fwrite($file,'//log_level    log_destination'."\n");


fwrite($file,trim($arrayInput['log_tcp_port'])." ");
fwrite($file,trim($arrayInput['rcportal_control_udp_port'])." ");

fwrite($file,'//tcp_port_for_log_server    tcp_port_for_user_reload'."\n");
$is_error = 1;
fclose($file);


}

try {
    $res = Sql_exec($cn, $qry);
    $is_error = 1;
				/*
				
			if($action!="delete"){
				if($action == "update"){
                                    $options['cn'] = $cn;
						$options['page_name'] = "Softswitch IPPBX Configuration";
						$options['action_type'] = $action;
						$options['table'] = "tbl_ippbx_configuration";
						$options['id_value'] = $action_id;
						setHistory($options);
					}else{
						
						$action_id = Sql_insert_id($cn);
						$action = 'add';
                        $options['cn'] = $cn;
						$options['page_name'] = "Softswitch IPPBX Configuration";
						$options['action_type'] = $action;
						$options['table'] = "tbl_ippbx_configuration";
						$options['id_value'] = $action_id;
						setHistory($options);
						}
			}
  */  
} catch (Exception $e) {
    
   
}





ClosedDBConnection($cn);

 


if ($is_error == 1) {
    $return_data = array('status' => true, 'message' => 'Successfully Saved ( Alert Body from configuration_info.php).');

} else {
    $return_data = array('status' => false, 'message' => 'Data Not Saved.');
}

echo json_encode($return_data);



?>