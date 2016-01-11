<?php

require_once "../lib/common.php";
$info = $_POST['info'];

$cn = connectDB();

$is_error = 0;
	$action = mysql_real_escape_string(htmlspecialchars($info['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($info['action_id']));
	$acc_name = mysql_real_escape_string(htmlspecialchars($info['acc_name']));
	$credit_balance = mysql_real_escape_string(htmlspecialchars($info['credit_balance']));
	$mask = mysql_real_escape_string(htmlspecialchars($info['mask']));
	$status = mysql_real_escape_string(htmlspecialchars($info['status']));
	
	if($action == "insert" ){
		$qry = "insert into tbl_smsgw_account(`acc_name`,`balance`,`masks`,`is_active`) values( '$acc_name','$credit_balance','$mask','$status')";	
		
	} elseif($action == "update") {
		$qry = "UPDATE tbl_smsgw_account SET `acc_name`='$acc_name',`balance`='$credit_balance',`masks`='$mask',`is_active`='$status' WHERE `id`='$action_id'";		
	
	} elseif($action == "delete"){
		
		$qry = "delete from tbl_smsgw_account where id='$action_id'";
	}
	
	
	try {
		$res = Sql_exec($cn,$qry);
		
		if($action!="delete"){
				if($action == "update"){
					$options['page_name'] = "Bulk SMS Account Manager";
					$options['action_type'] = $action;
					$options['table'] = "tbl_smsgw_account";
					$options['id_value'] = $action_id;
					setHistory($options);
				}else{
					
					$action_id = Sql_insert_id($cn);
					$action = 'add';
					$options['page_name'] = "Bulk SMS Account Manager";
					$options['action_type'] = $action;
					$options['table'] = "tbl_smsgw_account";
					$options['id_value'] = $action_id;
					setHistory($options);
					}
			}
		
	} catch (Exception $e){
		$is_error = 1;
		
	}
	
	echo $is_error;
ClosedDBConnection($cn);


?>