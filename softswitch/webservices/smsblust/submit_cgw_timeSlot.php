<?php

require_once "../lib/common.php";

$info = $_POST['info'];

$remoteCn = remote_connectDB('CGW');

	
	$action = mysql_real_escape_string(htmlspecialchars($info['action']));
	$action_id = mysql_real_escape_string(htmlspecialchars($info['action_id']));
	$time_slot_id = mysql_real_escape_string(htmlspecialchars($info['time_slot_id']));
	$start_day = mysql_real_escape_string(htmlspecialchars($info['start_day']));
	$end_day = mysql_real_escape_string(htmlspecialchars($info['end_day']));
	$start_time = mysql_real_escape_string(htmlspecialchars($info['start_time']));
	$end_time = mysql_real_escape_string(htmlspecialchars($info['end_time']));
	$is_error = 0;
	
	
	if($action == "insert" ){
		$qry = "INSERT INTO `timeslot` (`TimeSlotID`,`StartDay`,`EndDay`,`StartTime`,`EndTime`,`LastUpdate`,`is_active`)
				VALUES('$time_slot_id','$start_day','$end_day','$start_time','$end_time',NOW(),'active')";	
			
	} elseif($action == "update") {
		$qry = "UPDATE timeslot 
				SET
					`StartDay` = $start_day , 
					`EndDay` = $end_day , 
					`StartTime` = $start_time , 
					`EndTime` = $end_time,
					`LastUpdate`= NOW()
				WHERE TimeSlotID = '$time_slot_id'";		
	} elseif($action == "delete"){
		$qry = "update `timeslot` set `is_active`='inactive' where `is_active`='active' and `TimeSlotID`='$action_id'";
		//$qry = "delete from `timeslot` where `TimeSlotID`='".$action_id."'";
	}
	try {
		$res = Sql_exec($remoteCn,$qry);
	} catch (Exception $e){
		$is_error = 1;
	}
	

	echo $is_error;
	

	if($remoteCn)ClosedDBConnection($remoteCn);


?>