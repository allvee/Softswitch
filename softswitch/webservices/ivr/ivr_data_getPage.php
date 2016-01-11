<?php
include_once "../lib/common.php";

if (!empty($_POST))
{
	$cn = connectDB();
	if(isset($_POST['dataserverid'])){
		$data = $_POST;
	} else if($_POST['info']){
		$data = $_POST['info'];
	}
	$serverid = mysql_real_escape_string(htmlspecialchars($data['dataserverid']));
	$remoteCnQry="select db_type,db_server,db_uid,db_password,db_name from `tbl_ch_server_info` where id='$serverid'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	$dbtype=$dt['db_type'];
	$Server=$dt['db_server'];
	$UserID=$dt['db_uid'];
	$Password=$dt['db_password'];
	$Database=$dt['db_name'];

	ClosedDBConnection($cn);
    

	$cnn = connectDB();
	
    $service = mysql_real_escape_string(htmlspecialchars($_POST['service_id']));
	//echo $service;
	
  	$qry = "SELECT distinct`PageName` FROM `ivrmenu` where `Service`='$service'";
	//$qry = "SELECT distinct`PageName` FROM `ivrmenu`";
    $res = Sql_exec($cnn,$qry);
	
	$v_arr = array();
	
                          
    while($dt = Sql_fetch_array($res)){
		$page_name = $dt['PageName'];
		$set_page=$page_name;
         $id=$page_name;
		$v_arr[$id] = $set_page;
        
	}
	
	ClosedDBConnection($cnn);
	echo json_encode($v_arr);

}
?>
