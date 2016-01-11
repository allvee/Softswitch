<?php
require_once "../lib/common.php";
session_start();
$v_arr = array();
$count = 0;

$info = $_POST['info'];

$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);
//remote connection parameter set up
$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];
ClosedDBConnection($cn);// close current connection

$remoteCn=connectDB();
$action_id = mysql_real_escape_string(htmlspecialchars($info['action_id']));
$qry = "select `TimeSlotID`,`StartDay`,`EndDay`,`StartTime`,`EndTime` from `timeslot` where `TimeSlotID` ='$action_id'"; // where `UserID`='".$user_id."'  ";
if(isset($_POST['action_id'])){
	$action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
	$qry .= " where `TimeSlotID`='$action_id'"; 
}
	
    $res = Sql_exec($remoteCn,$qry);
	while($dt = Sql_fetch_array($res)){
		$v_arr[$count]['timeSlotIdHidden'] = $dt['TimeSlotID'];
		$v_arr[$count]['TimeSlotID'] = $dt['TimeSlotID'];
		$v_arr[$count]['StartDay'] = $dt['StartDay'];
		$v_arr[$count]['EndDay'] = $dt['EndDay'];
		
		$h1 = 0;
		$m1 = 0;
		$h2 = 0;
		$m2 = 0;
				
		$m1 = $dt['StartTime'] % 60;
		$m2 = $dt['EndTime'] % 60;
		
		$h1 = ($dt['StartTime'] - $m1) / 60;
		$h2 = ($dt['EndTime'] - $m2) / 60;
		
		
				
		
				

		$v_arr[$count]['StartTime'] = $h1.':'.$m1;
		$v_arr[$count]['EndTime'] = $h2.':'.$m2;
		
		$count++;
	}
	

if($remoteCn)ClosedDBConnection($remoteCn);	
	echo json_encode($v_arr);
?>