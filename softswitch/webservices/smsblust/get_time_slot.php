<?php
require_once "../lib/common.php";
$cn = connectDB();
// field name of tbl_process_db_access: id, pname, db_type, db_server, db_uid,db_password,db_name
$remoteCnQry="select * from `tbl_process_db_access` where `pname`='CGW'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);
//remote connection parameter set up

$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];

ClosedDBConnection($cn);// close current connection
// open remote connection

$remoteCn=connectDB();
$qry = "SELECT `TimeSlotID` FROM `timeslot` ORDER BY `TimeSlotID` ASC"; 

	
    $res = Sql_exec($remoteCn,$qry);
	$str = '<option value="">--Select--</option>';
                            
    while($dt = Sql_fetch_array($res)){
		$TimeSlotID = $dt['TimeSlotID'];
		$str.= '<option value="'.$TimeSlotID.'" >'.$TimeSlotID.'</option>';
	}
	

ClosedDBConnection($remoteCn);
echo $str;
?>