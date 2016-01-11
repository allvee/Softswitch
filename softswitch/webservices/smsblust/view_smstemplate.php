<?php

require_once "../lib/common.php";

$cn = connectDB();
$qry = "select `id`,`msg`,`created_by`,`last_updated` from `tbl_smsgw_template` where is_active='active'";
$rs = Sql_exec($cn,$qry);
$data = array();
$i=0;
while($row = Sql_fetch_array($rs)){
	
	$j=0;
    $data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "msg");
    $data[$i][$j++] = Sql_Result($row, "created_by");
    $data[$i][$j++] = Sql_Result($row, "last_updated");

    


    $data[$i][$j++] = '<span onclick="edit_input_form_smsblust_smstemplate(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" /></span>'
	.'<span onclick="delete_smsblust_smstemplate(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" /></span>';
	
/*	'<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_smsblust_smstemplate(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_smsblust_smstemplate(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>'; */
    $i++;
}
		

		
echo json_encode($data);	
ClosedDBConnection($cn);

	
?>