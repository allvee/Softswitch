<?php

include_once "../lib/common.php";
$cn = connectDB();
	$data = $_POST['info'];
	$serverid = mysql_real_escape_string(htmlspecialchars($data['serverid']));
	$remoteCnQry="select db_type,db_server,db_uid,db_password,db_name from `tbl_ch_server_info` where id='$serverid'";
	//$remoteCnQry="select * from tbl_process_db_access where pname='CH'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);
	
	$dbtype=$dt['db_type'];
	$Server=$dt['db_server'];
	$UserID=$dt['db_uid'];
	$Password=$dt['db_password'];
	$Database=$dt['db_name'];
	
	ClosedDBConnection($cn);
	
	$remoteCn=connectDB();
 	
 	$query = "SELECT `id`,`ano`,`bno`,`url`,`Status`,`ProvisionEndDate` FROM `geturl`";
 	$result = Sql_exec($remoteCn, $query);
	if (!$result) {
    	echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
   		exit;
	}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
	
    $data[$i][$j++] = Sql_Result($row, "ano");
	$data[$i][$j++] = Sql_Result($row, "bno");
    $data[$i][$j++] = Sql_Result($row, "url");
    $data[$i][$j++] = Sql_Result($row, "Status");
    $data[$i][$j++] = Sql_Result($row, "ProvisionEndDate");
/*
    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_ivr_mapping(this,'."'".$serverid."|".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px; " onclick="delete_ivr_mapping(this,'."'".$serverid."|".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>';
  */
  $data[$i][$j++] = '<span onclick="edit_input_form_ivr_mapping(this,'."'".$serverid."|".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'.'&nbsp&nbsp'.'<span onclick="delete_ivr_mapping(this,'."'".$serverid."|".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';
  
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>
