<?php
header('Access-Control-Allow-Origin: *');
//session_start();
require_once "../lib/common.php";
require_once "../lib/filewriter.php";
//$dir = "../../etc/sysconfig/network-scripts/";

//$info = $_POST["info"];

$cn = connectDB();

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["USER_ID"];

if (isset($_REQUEST['info'])) {
    $data = $_REQUEST['info'];
    $action = $data['action'];
    $action_id = $data['action_id'];
}else if (isset($_POST) && isset($_POST['action']) && isset($_POST['action_id'])){
    $action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
    $action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
    $device_id= mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_DeviceId']));
    $device_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_DeviceIp']));
    $idle_user_time = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_IdleuserTime']));
    $data_log_directory = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_DataLogDirectory']));
    $user_log_directory = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_UserLogDirectory']));
    $bwp_enable = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_BwpEnable']));

    $subnet_mask = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_SubnetMask']));
    $cdr_interval = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_CdrInterval']));
    $cdr_log_directory= mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info__CdrLogDirectory']));
    $cgw_enable = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_CgwEnable']));
    $cgw_data_limit = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info__CgwDataLimit']));
    $cgw_log_directory = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_CgwLogDirectory']));
    $cgw_req_directory = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_CgwReqDirectory']));
    $app_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info__AppId']));

    $app_password = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info__AppPassword']));
    $cgw_server_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_CgwServerIp']));
    $cgw_server_port= mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_CgwServerPort']));
    $uri = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info__Uri']));
    $cgw_hostname = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info__CgwHostname']));
    $self_care_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info__SelfCareIp']));
    $accept_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_AcceptPort']));

    $nfqueue_number = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info__NfqueueNumber']));
    $log_level = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwp_info_LogLevel']));
}

$select_qry = "SELECT * FROM tbl_bwp_config";
$res_select = Sql_exec($cn,$select_qry);

if(Sql_Num_Rows($res_select)>0){
    $qry = "update tbl_bwp_config
		set device_id='$device_id', device_ip = '$device_ip', idle_user_time = '$idle_user_time', data_log_directory = '$data_log_directory', user_log_directory= '$user_log_directory', nfqueue_num = '$nfqueue_number', bwp_enable = '$bwp_enable', subnet_mask='$subnet_mask', cdr_interval='$cdr_interval',cdr_log_directory='$cdr_log_directory',log_level='$log_level',cgw_enable='$cgw_enable',cgw_data_limit='$cgw_data_limit',cgw_log_directory='$cgw_log_directory',cgw_req_directory='$cgw_req_directory',app_id='$app_id',cgw_ip='$cgw_server_ip',cgw_port='$cgw_server_port',cgw_uri='$uri',cgw_host_name='$cgw_hostname',self_care_ip='$self_care_ip',accept_port='$accept_port'";
}else {
    $qry = "insert into tbl_bwp_config(`device_id`,`device_ip`,`idle_user_time`,`data_log_directory`,`user_log_directory`,`nfqueue_num`,`bwp_enable`,subnet_mask,cdr_interval,cdr_log_directory,log_level,cgw_enable,cgw_data_limit,cgw_log_directory,cgw_req_directory,app_id,cgw_ip,cgw_port,cgw_uri,cgw_host_name,self_care_ip,accept_port) ";
    $qry .= " values ('$device_id','$device_ip','$idle_user_time','$data_log_directory','$user_log_directory','$nfqueue_number','$bwp_enable','$subnet_mask','$cdr_interval', '$cdr_log_directory','$log_level','$cgw_enable','$cgw_data_limit','$cgw_log_directory','$cgw_req_directory','$app_id','$cgw_server_ip','$cgw_server_port','$uri','$cgw_hostname','$self_care_ip','$accept_port')";
}
//echo $qry;

try {
    $res = Sql_exec($cn, $qry);
	if($action!="delete"){
	if($action == "update"){
			$options['page_name'] = "Bandwidth Profiler Configuration";
			$options['action_type'] = $action;
			$options['table'] = "tbl_bwp_config";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         	$action = 'add';
			$options['page_name'] = "Bandwidth Profiler Configuration";
			$options['action_type'] = $action;
			$options['table'] = "tbl_bwp_config";
			$options['id_value'] = $action_id;
			setHistory($options);
			}
	}
} catch (Exception $e) {
    $is_error = 1;
}
if ($is_error == 0) {
    $is_error = file_writer_bwp($cn);
}

ClosedDBConnection($cn);

echo $is_error;

?>