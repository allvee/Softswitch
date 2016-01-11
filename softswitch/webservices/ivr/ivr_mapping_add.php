<?php

session_start();
include_once "../lib/common.php";

if (!empty($_POST))
{
	$cn = connectDB();
	if(isset($_POST['serverid'])){
		$data = $_POST;
	} else if($_POST['info']){
		$data = $_POST['info'];
	}
	$serverid = mysql_real_escape_string(htmlspecialchars($data['serverid']));
	$remoteCnQry="select db_type,db_server,db_uid,db_password,db_name from `tbl_ch_server_info` where id='$serverid'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	//echo ($serverid);
	$dbtype=$dt['db_type'];
	$Server=$dt['db_server'];
	$UserID=$dt['db_uid'];
	$Password=$dt['db_password'];
	$Database=$dt['db_name'];

	ClosedDBConnection($cn);
    
	$remoteCn=connectDB();

	$action = mysql_real_escape_string(htmlspecialchars($data['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
	$is_error = 1;
	
	$ano=mysql_real_escape_string(htmlspecialchars($data['ano']));
	$bno=mysql_real_escape_string(htmlspecialchars($data['bno']));
	$status=mysql_real_escape_string(htmlspecialchars($data['status']));
	$provision_end_date=mysql_real_escape_string(htmlspecialchars($data['provision_end_date']));
    $url=mysql_real_escape_string(htmlspecialchars($data['url']));
	
	if($action == "insert" ){
		
		$qry = "INSERT INTO `geturl` (`ano`,`bno`,`url`,`STATUS`,`ProvisionEndDate`)";
		$qry .= " VALUES ('$ano', '$bno', '$url', '$status', '$provision_end_date');";
		
		 $msg="Successfully Saved";
		 
	} elseif($action == "update") {
		$qry = "UPDATE geturl SET ano='$ano',bno='$bno',url='$url',STATUS='$status',ProvisionEndDate='$provision_end_date' WHERE id='$action_id'";	
		$msg="Successfully Updated";	
	} elseif($action == "delete"){

		 $msg="Successfully Deleted";
		$qry = "delete from geturl where id='$action_id'";
	}
	
	try {
		$res = Sql_exec($remoteCn,$qry);
		$is_error = 0;
		/*if($action!="delete"){
			if($action == "update"){
			
				$action_name = $action;
				$id_val = $action_id;
			}else{
				$action_name = 'add';
				$id_val = Sql_insert_id($remoteCn);
					
			}
		}
		
		ClosedDBConnection($remoteCn);
		rollback_main_connectDB();
		$options['page_name'] = "IVR Mapping";
		$options['action_type'] = $action_name;
		$options['table'] = "geturl";
		$options['id_value'] = $id_val;
		$options['remote'] = true;
		$options['pname'] = 'CH';
		
		
		setHistory($options);*/
			
	} catch (Exception $e){
		echo $e;
	}
	
	
  	if ($is_error) {
   		$return_data = array('status' => false, 'message' => 'Submission Failed');
	} else {
    	$return_data = array('status' => true, 'message' => $msg);
	}

echo json_encode($return_data);
	

}

//echo "sdasdas";

?>