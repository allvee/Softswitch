<?php
require_once "../lib/common.php";
$info = $_POST['info'];

$cn = connectDB();
$qry="SELECT * FROM `tbl_process_db_access` WHERE `pname`='SMSGW'";
$res = Sql_exec($cn,$qry);
$dt = Sql_fetch_array($res);
$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];
ClosedDBConnection($cn);

$remoteCn = connectDB();

$msgid = mysql_real_escape_string(htmlspecialchars($info['msg_id']));

$qry = "UPDATE `smsoutbox` SET `msgStatus`='QUE' WHERE `msgID`='$msgid'";
$is_error = 2;
try{
	$rs = Sql_exec($remoteCn,$qry);
	$is_error = 0;
}catch(Exception $e){
	$is_error = 1;
}
echo $is_error;	

ClosedDBConnection($remoteCn);

	
?>