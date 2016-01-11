<?php

require_once "../lib/common.php";

$cn = connectDB();
$remoteCnQry="select * from tbl_process_db_access where pname='CGW'";
$res = Sql_exec($cn,$remoteCnQry);
$dt = Sql_fetch_array($res);

$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];
ClosedDBConnection($cn);

$remoteCn = connectDB();

$qry = "select `TimeSlotID`,`StartDay`,`EndDay`,`StartTime`,`EndTime`,`UserID` from `timeslot` where `is_active`='active'";
$rs = Sql_exec($remoteCn,$qry);
$data = array();
$i=0;
while($row = Sql_fetch_array($rs)){
	
	$j=0;
	$data[$i][$j++] = Sql_Result($row, "TimeSlotID");
    $data[$i][$j++] = Sql_Result($row, "StartDay");
    $data[$i][$j++] = Sql_Result($row, "EndDay");
    $data[$i][$j++] = Sql_Result($row, "StartTime");
	$data[$i][$j++] = Sql_Result($row, "EndTime");
    


    $data[$i][$j++] ='<span onclick="edit_input_form_smsblast_timeslot(this,'."'".Sql_Result($row, "TimeSlotID")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" /></span>'
	.'<span onclick="delete_smsblast_timeslot(this,'."'".Sql_Result($row, "TimeSlotID")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" /></span>';
	
	/* '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_smsblast_timeslot(this,'."'".Sql_Result($row, "TimeSlotID")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_smsblast_timeslot(this,'."'".Sql_Result($row, "TimeSlotID")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>'; */
    $i++;
}
		

		
echo json_encode($data);	
ClosedDBConnection($remoteCn);

	
?>