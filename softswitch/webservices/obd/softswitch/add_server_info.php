<?php

include_once "../lib/common.php";
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
					$options['page_name'] = "Softswitch IPPBX Server";
					$options['action_type'] = $action;
					$options['table'] = "tbl_ippbx_server";
					$options['id_value'] = $action_id;
					setHistory($options);
				}else{
					
					$action_id = Sql_insert_id($cn);
					$action = 'add';
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



?>