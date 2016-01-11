<?php
require_once "../lib/common.php";
$remoteCn = remote_connectDB('ISMP');
$qry = "SELECT 	smp.`id`,
				smp.`msg`,
				smp.`mask`,
				scg.`group_name` 
		FROM `tbl_smsgw_msg_permission` smp inner join `tbl_smsgw_contact_group` scg 
			  ON smp.`group_id`=scg.`id` 
		WHERE smp.`status`='pending'";
$rs = Sql_exec($remoteCn,$qry);
$data = array();
$i=0;
while($row = Sql_fetch_array($rs)){
	
	$j=0;
	$data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "msg");
    $data[$i][$j++] = Sql_Result($row, "mask");
    $data[$i][$j++] = Sql_Result($row, "group_name");
   
    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="send_bulk_sms(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button">Send
</button>';
    $i++;
}
		
echo json_encode($data);	
ClosedDBConnection($remoteCn);

	
?>