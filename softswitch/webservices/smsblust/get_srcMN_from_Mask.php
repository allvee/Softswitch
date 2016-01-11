<?php
require_once "../lib/common.php";

$info = $_POST['info'];

$v_arr = array();

$user_id = $_SESSION['USER_ID'];
$cn = connectDB();

$remoteCnQry="select * from tbl_process_db_access where pname='SMSGW'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);

$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];

ClosedDBConnection($cn);
$remoteCn=connectDB();

$maskVal = mysql_real_escape_string(htmlspecialchars($info['mask']));

$qry = "SELECT `srcMN` FROM `mask` WHERE `maskName`='$maskVal'"; 

	
    $res = Sql_exec($remoteCn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$srcMN = $dt['srcMN'];
		$v_arr['srcMN'] = $srcMN;
	}
	
if($remoteCn)ClosedDBConnection($remoteCn);
echo json_encode($v_arr);
?>