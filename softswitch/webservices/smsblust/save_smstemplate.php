<?php

require_once "../lib/common.php";

$action = "";

$msg  = "";
$cn = connectDB();

$info = $_POST['info'];

if( isset($info['action']) ){
	$action = mysql_real_escape_string(htmlspecialchars($info['action']));
}
if( isset($info['msg'])){
	$msg = mysql_real_escape_string(htmlspecialchars($info['msg']));
}
if( $action == "update" || $action == "delete" ){
    $action_id =  mysql_real_escape_string(htmlspecialchars($info['action_id']));
}
//tbl_smsgw_template

$is_error = 0;	
	
$qry = "";

if(	$action == "insert"	){
		$qry = "insert into `tbl_smsgw_template` ( `msg`,`last_updated`) values('$msg',NOW())";	
} elseif( $action == "update" ){
		$qry = "update `tbl_smsgw_template` set `msg`='$msg' where `id`='$action_id'";		
} elseif( $action == "delete" ){
		$qry = "update `tbl_smsgw_template` set `is_active` = 'inactive' where `is_active`='active' and `id`='$action_id'";
}

	
    
	try{
		$rs = Sql_exec($cn, $qry);
		if($action!="delete"){
				if($action == "update"){
					$options['page_name'] = "Bulk SMS Template";
					$options['action_type'] = $action;
					$options['table'] = "tbl_smsgw_template";
					$options['id_value'] = $action_id;
					setHistory($options);
				}else{
					
					$action_id = Sql_insert_id($cn);
					$action = 'add';
					$options['page_name'] = "Bulk SMS Template";
					$options['action_type'] = $action;
					$options['table'] = "tbl_smsgw_template";
					$options['id_value'] = $action_id;
					setHistory($options);
					}
			}
	}catch(Exception $e){
		$is_error = 1;
	}
	
ClosedDBConnection($cn);

echo $is_error;


?>