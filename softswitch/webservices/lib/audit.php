<?php
/**
 * Save data into
 * Audit table
 */
require_once "common.php";

function setHistory($options = array()){
	
	$defaultOptions = array();
	$defaultOptions['page_name'] = '';
	$defaultOptions['action_type']='';
	$defaultOptions['table'] = '';
	$defaultOptions['id_name'] = 'id';
	$defaultOptions['id_value'] = '';
	$defaultOptions['remote'] = false;
	$defaultOptions['pname'] = '';
	
	
	$options = array_merge($defaultOptions, $options);
	extract($options);
	
	
    
	$localcn = connectDB();
	$user_id = $_SESSION['UserID'];
	$user_name = $_SESSION['UserName'];
	
    
	if( $localcn == '' || trim($action_type) == '' || trim($table) == '' || trim($id_value) == '' 
		|| (trim($remote) == true && trim($pname) == '')
		|| (trim($action_type)!="add" && trim($action_type) != "delete" && trim($action_type) == 'edit' )
	)
	{
		return false;	
	}
	
	$connection_string = $localcn;
	$remote_name = NULL;

	if($remote === true){
		
		$remoteCn = remote_connectDB($pname);
		$connection_string = $remoteCn;
		$remote_name = $pname;
		
	}
	
	$qry = "Select * from `$table` where $id_name = '$id_value'";
	$res = Sql_exec($connection_string,$qry);
	$result = Sql_fetch_assoc($res);
	
	$value_json = json_encode($result);
	
    
	
      
	if($remoteCn) {
		ClosedDBConnection($remoteCn);	
		rollback_main_connectDB();
	}
	
	
	if($action_type == 'update'){
		$comments = 'Updated !';
	} elseif($action_type == 'add'){ 
		$comments = 'Inserted !';
	}
	
 
	$row_value = $value_json;
	$action_command = $action_type;
	
        
	if($page_name == "") $page_name = $table;
	
	$table_name =  $table;
	$action_date = date("Y-m-d",strtotime("now"));
	$action_time = date("H:i:s",strtotime("now"));
	
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$referrer = $_SERVER['HTTP_REFERER'];
	
	$qry = "INSERT INTO tbl_audit_trail (user_id,user_name,action_command,pname,page_name,table_name,primary_key_column,action_date,action_time,rowvalue,comments,ip_address,browser,referer) VALUES";
	$qry .= "('$user_id','$user_name','$action_command','$remote_name','$page_name','$table_name','$id_name','$action_date','$action_time','$row_value','$comments','$ip_address','$browser', '$referrer');";
  	
    $result = Sql_exec($localcn,$qry);
	$insert_id = Sql_insert_id($localcn);
	
	return $insert_id;
}


?>


