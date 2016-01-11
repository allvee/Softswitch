<?php
require_once "../lib/common.php";
$cn=connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='ISMP'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);

$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];
ClosedDBConnection($cn);

$remoteCn=connectDB();
$qry = "SELECT `msg` FROM `tbl_smsgw_template` WHERE `is_active` ='active' ";
$res = Sql_exec($remoteCn,$qry);
$str = "";
while($dt = Sql_fetch_array($res)){
		$msg = $dt['msg'];
		$str.='<option value="'.$msg.'">'.$msg.'</option>';
}

ClosedDBConnection($remoteCn);
echo $str;

?>