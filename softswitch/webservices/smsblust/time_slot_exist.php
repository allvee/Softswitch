<?php
require_once "../lib/common.php";



$remoteCn = remote_connectDB('CGW');

$info = $_POST['info'];


$timeSlotIdVal = mysql_real_escape_string(htmlspecialchars($info['timeSlotId']));

$qry = "SELECT `TimeSlotID` FROM `timeslot` WHERE `TimeSlotID`='$timeSlotIdVal'"; 
$res = Sql_exec($remoteCn,$qry);

$dt = Sql_fetch_array($res);
if(isset($dt['TimeSlotID']) && $dt['TimeSlotID'] != "" && $dt['TimeSlotID'] != null ){
	
	echo json_encode(array('value'=>true));
}else{
	echo json_encode(array('value'=>false));
}
	
ClosedDBConnection($remoteCn);

?>