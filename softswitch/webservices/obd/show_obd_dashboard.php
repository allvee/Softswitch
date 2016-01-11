<?php
session_start();
include_once "../lib/common.php";

	$data = $_POST['info'];
	
	
	
if(isset($data['server_id']) && $data['server_id'] && isset($data['service_id']) && $data['service_id']){
	
	
	$cn = connectDB();
	
	$server_id = mysql_real_escape_string(htmlspecialchars($data['server_id']));
	$service_id = mysql_real_escape_string(htmlspecialchars($data['service_id']));

	$qry = "SELECT * FROM tbl_obd_server_config WHERE id='$server_id'";
	$res = Sql_exec($cn,$qry);
	$dt=Sql_fetch_array($res);
	$dbtype=$dt['db_type'];
	$Server=$dt['db_server'];
	$UserID=$dt['db_user'];
	$Password=$dt['db_password'];
	$Database=$dt['db_name'];
	ClosedDBConnection($cn);
	
	$remoteConnection = connectDB();
	$qry="SELECT OutDialStatus, COUNT(*) as num FROM outdialque WHERE UserId='$service_id' GROUP BY OutDialStatus ORDER BY OutDialStatus ASC";
	$result = Sql_exec($remoteConnection, $qry);
	if (!$result) {
    echo "err+" . $qry . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;

while ($row = Sql_fetch_array($result)) {
    $j=0;
	
    $data[$i][$j++] = Sql_Result($row, "OutDialStatus");
    $data[$i][$j++] = Sql_Result($row, "num");
	
	if(Sql_Result($row, "OutDialStatus")=="QUE")
	{
		$data[$i][$j++] = '<span  onclick="stop_obd_operation(this,'."'".Sql_Result($row, "OutDialStatus")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/stop.png" ></span>';
		
	} else
	{
		$data[$i][$j++] = '<span onclick="download_obd_dashboard(this,'."'".Sql_Result($row, "OutDialStatus")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/download.png" ></span>'; 
	}
    $i++;
	
}
Sql_Free_Result($result);
ClosedDBConnection($remoteConnection);
echo json_encode($data);
	
	

}
?>
