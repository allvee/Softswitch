<?php
require_once "../lib/common.php";
$cn = connectDB();
$qry = "SELECT `id`,`acc_name`,`acc_type`,`balance`,`masks`,`is_active` FROM tbl_smsgw_account";
$rs = Sql_exec($cn,$qry);
$data = array();
$i=0;
while($row = Sql_fetch_array($rs)){
	
	$j=0;
	$data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "acc_name");
    $data[$i][$j++] = Sql_Result($row, "balance");
    $data[$i][$j++] = Sql_Result($row, "masks");
    $data[$i][$j++] = Sql_Result($row, "is_active");
    


    $data[$i][$j++] ='<span onclick="edit_input_form_smsblast_account(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" /></span>'
	.'<span onclick="delete_smsblast_account(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" /></span>';
	
	/* '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_smsblast_account(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_smsblast_account(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>'; */
    $i++;
}
		

		
echo json_encode($data);	
ClosedDBConnection($cn);

	
?>