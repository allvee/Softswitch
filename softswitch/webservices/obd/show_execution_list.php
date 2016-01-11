<?php
session_start();
include_once "../lib/common.php";

$user_id=$_SESSION["USER_ID"];
$cn = connectDB();
$qry = "SELECT 
				a.id,
				b.name, 
				a.service_id, 
				a.display_no, 
				a.original_no, 
				a.schedule_date, 
				a.prompt_location,
				(SELECT NAME FROM tbl_obd_server_config WHERE id=a.id_operator_distribution) as distribution_list,
				a.status
 		FROM tbl_obd_instance_list a 
		INNER JOIN 
		tbl_obd_server_config b 
		ON a.server_id=b.id 
		WHERE a.user_id='$user_id'";
	
	$result = Sql_exec($cn,$qry);
	
	if (!$result) {
    echo "err+" . $qry . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
if(Sql_Num_Rows($result)>0){
	
	$data = array();
	$i=0;
	
	while ($row = Sql_fetch_array($result)) {
		$j=0;
		
		$data[$i][$j++] = Sql_Result($row, "id");
		$data[$i][$j++] = Sql_Result($row, "name");
		$data[$i][$j++] = Sql_Result($row, "service_id");
		$data[$i][$j++] = Sql_Result($row, "display_no");
		$data[$i][$j++] = Sql_Result($row, "original_no");
		$data[$i][$j++] = Sql_Result($row, "schedule_date");
		$data[$i][$j++] = Sql_Result($row, "prompt_location");
		$data[$i][$j++] = Sql_Result($row, "distribution_list");
		
		
		if(Sql_Result($row, "status")==0){
			
			$data[$i][$j++] = "Open";
		}
		
		elseif(Sql_Result($row, "status")==1){
			
			$data[$i][$j++] = "Cancelled";
		}
		
		else{
			$data[$i][$j++] = "Closed";
			
		}
		
		if(Sql_Result($row, "status")==0){
			
			 $data[$i][$j++] = '<span onclick="obd_execution_execute(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/execute.png" ></span>'.'&nbsp&nbsp'.'<span  onclick="obd_execution_remove(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';
		}
		
		else{
			
			$data[$i][$j++] = '';
			
		}
		
		$i++;	
	}		
		
Sql_Free_Result($result);
echo json_encode($data);
}

else{
	echo 1;
	}
ClosedDBConnection($remoteConnection);

?>
