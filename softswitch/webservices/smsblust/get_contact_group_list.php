<?php
session_start();
require_once "../lib/common.php";
$cn = connectDB();

//$role_id = $_SESSION['ROLE_ID'];
//$user_id = $_SESSION['USER_ID'];

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

$qry = "SELECT `id`,`group_name` FROM `tbl_smsgw_contact_group` where is_active='active'";
$qry .= " ORDER BY `id` ASC"; 

	$cn = connectDB();
    $res = Sql_exec($cn,$qry);
	$str = "";
                            
    while($dt = Sql_fetch_array($res)){
		$group_name = $dt['group_name'];
		$id = $dt['id'];
		$str.= '<option value="'.$id.'" >'.$group_name.'</option>';
	}
	
	ClosedDBConnection($cn);
	echo $str;
?>