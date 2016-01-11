<?php
require_once "../lib/common.php";

$cn = connectDB();

$qry="SELECT * FROM `tbl_process_db_access` WHERE `pname`='ISMP'";
$res = Sql_exec($cn,$qry);
$dt = Sql_fetch_array($res);

$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];
ClosedDBConnection($cn);

$remoteCn = connectDB();
$qry = "select `id`,`recipient_name`,`recipient_no` from `tbl_smsgw_group_recipient` where `is_active`= 'active'";
		
$rs = Sql_exec($remoteCn,$qry);
$data = array();
$i=0;
while($row = Sql_fetch_array($rs)){
	
	$j=0;
	$data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "recipient_name");
    $data[$i][$j++] = Sql_Result($row, "recipient_no");
	$data[$i][$j++] = '<span onclick="delete_smsblust_group_recipient(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" /></span>';
	
	/*'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_smsblust_group_recipient(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>'; */
    $i++;
}
		

		
echo json_encode($data);	
ClosedDBConnection($remoteCn);

	
?>