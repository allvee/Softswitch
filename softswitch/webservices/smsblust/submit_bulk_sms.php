<?php

require_once "../lib/common.php";

$group = "";
$mask  = "";
$msg  = "";
$cn = connectDB();

$info = $_POST['info'];

if( isset($info['group']) ){
	$group = mysql_real_escape_string(htmlspecialchars($info['group']));
}
if( isset($info['mask'])){
	$mask = mysql_real_escape_string(htmlspecialchars($info['mask']));
}
if(isset($info['msg'])){
    $msg =  mysql_real_escape_string(htmlspecialchars($info['msg']));
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
	
$qry = "INSERT INTO `tbl_smsgw_msg_permission` ( `msg`,`mask`,`group_id`,`last_updated`)VALUES( '$msg','$mask','$group',NOW())";
	
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