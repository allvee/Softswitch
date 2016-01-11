<?php
session_start();
include_once "../lib/common.php";

 $data = $_POST['info'];
                
 $cn = connectDB();               
				
				
 $total_no_of_call = mysql_real_escape_string(htmlspecialchars($data['total_no_of_call']));
 $minimum_call_duration = mysql_real_escape_string(htmlspecialchars($data['minimum_call_duration']));
 $maximum_call_duration = mysql_real_escape_string(htmlspecialchars($data['maximum_call_duration']));
 $average_call_duration = mysql_real_escape_string(htmlspecialchars($data['average_call_duration']));
 $total_established_call= mysql_real_escape_string(htmlspecialchars($data['total_established_call']));
 

	$remoteCnQry="select * from tbl_process_db_access where pname='SOFTSWITCH'";
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

    $qry ="CALL getCallReport('".$start_time."','".$end_time."','".$total_failed_call."');";

    $res = Sql_exec($remoteCn,$qry);

	$data_ = array();
	$i=0;

	while ($row = Sql_fetch_array($res)) {
    	$j=0;
        $data_[$i][$j++] = Sql_Result($row, "total_no_of_call");
		$data_[$i][$j++] = Sql_Result($row, "minimum_call_duration");
		$data_[$i][$j++] = Sql_Result($row, "maximum_call_duration");
		$data_[$i][$j++] = Sql_Result($row, "average_call_duration");
		$data_[$i][$j++] = Sql_Result($row, "total_established_call");
	
		$i++;
	}
	
	Sql_Free_Result($res);
	echo json_encode($data_);
                
	ClosedDBConnection($remoteCn);             


?>
