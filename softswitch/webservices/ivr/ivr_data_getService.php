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
	//$remoteCnQry="select * from tbl_process_db_access where pname='CH'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	//echo ($serverid);
	$dbtype=$dt['db_type'];
	$Server=$dt['db_server'];
	$UserID=$dt['db_uid'];
	$Password=$dt['db_password'];
	$Database=$dt['db_name'];

	ClosedDBConnection($cn);
    


	$cnn = connectDB();

	$qry = "SELECT distinct`Service` FROM `ivrmenu`";

    $res = Sql_exec($cnn,$qry);
	
	$v_arr = array();
	//$setid=0;
                          
    while($dt = Sql_fetch_array($res)){
		$service_name = $dt['Service'];
		$set_service=$service_name;
         $id=$service_name;
		$v_arr[$id] = $set_service;
        
	}
	
	ClosedDBConnection($cn);
	echo json_encode($v_arr);
}
?>
