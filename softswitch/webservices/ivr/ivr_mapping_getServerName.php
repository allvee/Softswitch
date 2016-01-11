<?php
include_once "../lib/common.php";

	$cn = connectDB();
	
	$qry = "SELECT `id`,`server_name` FROM `tbl_ch_server_info` ORDER BY `server_name` ASC"; 

	
    $res = Sql_exec($cn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$server_name = $dt['server_name'];
		$id = $dt['id'];
		$v_arr[$id] = $server_name;
	}
	
	ClosedDBConnection($cn);
	echo json_encode($v_arr);
?>