<?php
include_once "../lib/common.php";

	$cn = connectDB();
	
	$qry = "SELECT `id`,`name` from `tbl_softswitch_gateway` where `type`='Outbound'"; 

	
    $res = Sql_exec($cn,$qry);
	$v_arr = array();
                            
    while($dt = Sql_fetch_array($res)){
		$outbound = $dt['name'];
		$id = $dt['name'];
		$v_arr[$id] = $outbound;
	}
	
	ClosedDBConnection($cn);
	echo json_encode($v_arr);
?>