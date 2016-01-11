<?php

require_once "../lib/common.php";

$action_id = "";
$cn = connectDB();
$info = $_POST['info'];

if( isset($info['action_id']) ){
	$action_id = mysql_real_escape_string(htmlspecialchars($info['action_id']));
}


$is_error = 0;	
	
	$remoteCnQry="select * from `tbl_process_db_access` where `pname`='ISMP'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);

	$dbtype = $dt['db_type'];
	$Server = $dt['db_server'];
	$UserID = $dt['db_uid'];
	$Password = $dt['db_password'];
	$Database = $dt['db_name'];
	
ClosedDBConnection($cn);

$qry = "UPDATE `tbl_smsgw_group_recipient` SET `is_active` = 'inactive' WHERE `id` = '$action_id' AND `is_active`='active'";
$remoteCn = connectDB();
    
	try{
		$rs = Sql_exec($remoteCn, $qry);
		//$is_error = 0;
	}catch(Exception $e){
		$is_error = 1;
	}
	
ClosedDBConnection($remoteCn);

echo $is_error;


?>