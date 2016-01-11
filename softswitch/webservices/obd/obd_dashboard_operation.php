<?php
session_start();

include_once "../lib/common.php";
require_once "../lib/csv_export.php";

$cn = connectDB();


$action=mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$server_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['server_id']));
$service_id=mysql_real_escape_string(htmlspecialchars($_REQUEST['service_id']));
$status=mysql_real_escape_string(htmlspecialchars($_REQUEST['status']));
	
if(isset($action) && $action !="" && $action=="download"){
	
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
	
	$query="SELECT MSISDN FROM outdialque WHERE UserId='$service_id' AND OutDialStatus='$status'";
	$res = Sql_exec($remoteConnection,$query);
	if(Sql_Num_Rows($res)>0)
	{
		$data=array();
		$title=array();
		while($dt=Sql_fetch_array($res))
		{
			$one_row=array("msisdn"=>$dt["MSISDN"]);
	  		array_push($data,$one_row);
		}
		$filename=$service_id."_".$status."_".date("Y/m/d-H:i:s");
		export_csv_file($title,$data,$filename,",");
			
		
	}else{
			echo 1;	
	}
	
	
	ClosedDBConnection($remoteConnection);

	
		
	
}else if(isset($action) && $action !="" && $action=="stop")
{
	$cn = connectDB();
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
	
	$query="UPDATE outdialque SET OutDialStatus='STOPPED' WHERE UserId='$service_id' AND OutDialStatus='$status'";
	$res = Sql_exec($remoteConnection,$query);
	if($res) echo 0;
	else echo 1;
	
}
if($remoteConnection)ClosedDBConnection($remoteConnection);

?>