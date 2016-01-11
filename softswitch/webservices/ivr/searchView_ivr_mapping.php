<?php

include_once "../lib/common.php";
$cn = connectDB();
if (!empty($_POST))
{
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
	//echo "asdasd";

	
	$remoteCn=connectDB();
	$service_id = mysql_real_escape_string(htmlspecialchars($data['service_id']));
	$page_id = mysql_real_escape_string(htmlspecialchars($data['page_id']));
 	
 	$query = "SELECT `current_state`,`key_press`,`short_code`,`next_state`,`NextKey`,`Action_command`,`URL`,`play_file` FROM `ivrmenu` where     Service='$service_id' and PageName='$page_id'";
 	$result = Sql_exec($remoteCn, $query);
	if (!$result) {
    	echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
   		exit;
	}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
	
    $data[$i][$j++] = Sql_Result($row, "current_state");
	$data[$i][$j++] = Sql_Result($row, "key_press");
    $data[$i][$j++] = Sql_Result($row, "short_code");
    $data[$i][$j++] = Sql_Result($row, "next_state");
	$data[$i][$j++] = Sql_Result($row, "NextKey");
	$data[$i][$j++] = Sql_Result($row, "Action_command");
	$data[$i][$j++] = Sql_Result($row, "URL");
	$data[$i][$j++] = Sql_Result($row, "play_file");
/*
    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_ivr_mapping(this,'."'".$serverid."|".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px; " onclick="delete_ivr_mapping(this,'."'".$serverid."|".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>';
  */
 
  
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);
}

?>
