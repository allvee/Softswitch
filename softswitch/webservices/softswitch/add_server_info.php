<?php

/*include_once "../lib/common.php";
$cn = connectDB();

	$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
	$server_ip = "";
	$server_port = "";
	$protocol = "";
	$client_bind_ip = "";
	$client_bind_port = "";
	$sip_user_id = "";
	$sip_password = "";
	$is_error=1;
	
	
	if(isset($_REQUEST['info']) || isset($_REQUEST['action'])){
	
	       if(isset($_REQUEST['info'])){
					   
						$data= $_REQUEST['info'];
						$action = mysql_real_escape_string(htmlspecialchars($data['action']));
						$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			   
				 if(isset($data['gw_name'])){
						$server_ip = mysql_real_escape_string(htmlspecialchars($data['server_ip']));
						$server_port = mysql_real_escape_string(htmlspecialchars($data['server_port']));
						$protocol = mysql_real_escape_string(htmlspecialchars($data['protocol']));
						$client_bind_ip = mysql_real_escape_string(htmlspecialchars($data['client_bind_ip']));
						$client_bind_port = mysql_real_escape_string(htmlspecialchars($data['client_bind_port']));
						$sip_user_id = mysql_real_escape_string(htmlspecialchars($data['sip_user_id']));
						$sip_password = mysql_real_escape_string(htmlspecialchars($data['sip_password']));
			   }
		   }
              else{	
			  			$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
						$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
						$server_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['server_ip']));
						$server_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['server_port']));
						$protocol = mysql_real_escape_string(htmlspecialchars($_REQUEST['protocol']));
						$client_bind_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['client_bind_ip']));
						$client_bind_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['client_bind_port']));
						$sip_user_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['sip_user_id']));
						$sip_password = mysql_real_escape_string(htmlspecialchars($_REQUEST['sip_password']));
		}      
	   
	
	if($action == "update"){
		
		$msg = "Successfully Updated";
		$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
		$qry = "update tbl_ippbx_server set server_ip='$server_ip',server_port='$server_port', protocol='$protocol',client_bind_ip='$client_bind_ip',client_bind_port='$client_bind_port', sip_user_id='$sip_user_id',sip_password='$sip_password'";
		$qry .= " where id='$action_id'";
	} elseif($action == "delete"){
		$msg = "Successfully Deleted";
			$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			$qry = "update tbl_ippbx_server set is_active='inactive'";
			$qry .= " where id='$action_id'";
	} else if($action=="insert"){
		$msg = "Successfully Saved";
		$qry = "insert into tbl_ippbx_server (server_ip,server_port,protocol,client_bind_ip,client_bind_port,sip_user_id,sip_password) values ('$server_ip','$server_port','$protocol','$client_bind_ip','$client_bind_port','$sip_user_id','$sip_password')";
	}
              
		try {					 
			$res = Sql_exec($cn,$qry);
                        
              if($action!="delete"){          
				 if($action == "update"){
                                     $options['cn'] = $cn;
					$options['page_name'] = "Softswitch IPPBX Server";
					$options['action_type'] = $action;
					$options['table'] = "tbl_ippbx_server";
					$options['id_value'] = $action_id;
					setHistory($options);
				}else{
					
					$action_id = Sql_insert_id($cn);
					$action = 'add';
                                        $options['cn'] = $cn;
					$options['page_name'] = "Softswitch IPPBX Server";
					$options['action_type'] = $action;
					$options['table'] = "tbl_ippbx_server";
					$options['id_value'] = $action_id;
					setHistory($options);
					}
			  }
			$is_error = 0;
		}catch (Exception $e){
			
		}           
	}
	
	
	
  	if ($is_error) {
   		$return_data = array('status' => false, 'message' => 'Submission Failed');
	} else {
    	$return_data = array('status' => true, 'message' => $msg);
	}

echo json_encode($return_data);
ClosedDBConnection($cn);
*/


require_once "../lib/config.php";
require_once "../lib/common.php";

$cn = connectDB();

$arrayInput = $_REQUEST;
$is_error = 0;

$file_name = $dir_softswitch_ippbx_config . "servers.ini";
$lines = count(file($file_name));

if ($lines <= 1000) {

    $file = fopen($file_name, "a");


    fwrite($file, trim($arrayInput['server_ip']) . " ");
    fwrite($file, trim($arrayInput['server_port']) . " ");
    fwrite($file, trim($arrayInput['protocol']) . " ");
    fwrite($file, trim($arrayInput['client_bind_ip']) . " ");
    fwrite($file, trim($arrayInput['client_bind_port']) . " ");
    fwrite($file, trim($arrayInput['is_need_flag']) . " ");
    fwrite($file, trim($arrayInput['from_number_start_range']) . " ");
    fwrite($file, trim($arrayInput['from_number_end_range']) . " ");
    fwrite($file, trim($arrayInput['to_number_start_range']) . " ");
    fwrite($file, trim($arrayInput['to_number_end_range']) . " ");
    fwrite($file, trim($arrayInput['sip_user_id']) . " ");
    fwrite($file, trim($arrayInput['sip_password']) . " ");
    fwrite($file, trim($arrayInput['is_proxy_status']) . " ");
    fwrite($file, trim($arrayInput['forward_per_index']) . " ");
    fwrite($file, trim($arrayInput['is_active_status']) . " ");
    fwrite($file, trim($arrayInput['is_internal_status']) . "\n");
    fclose($file);
    $is_error = 1;

}

$config_text = json_encode($arrayInput);
$time_now = date("Y-m-d H:i:s");

$sql = "insert into `tbl_app_configuration` (applicaiton,component,config_text,updated) VALUES ('softswitch_servers','servers','" . $config_text . "','" . $time_now . "')";
Sql_exec($cn, $sql);

ClosedDBConnection($cn);

if ($is_error == 1) {
    $return_data = array('status' => true, 'message' => 'Successfully Saved.');
    // $is_error = file_writer_vpn_ipsec($cn);
} else {
    $return_data = array('status' => false, 'message' => 'Data Not Saved.');
}

echo json_encode($return_data);




?>