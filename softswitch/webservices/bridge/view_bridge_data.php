<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/7/2015
 * Time: 6:02 PM
 */

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "SELECT `id`,`bridge_name`,`interface1`,`interface2`,`interface3`,`interface4`,`ip`,`net_mask`,`gateway`,`last_updated`,`last_updated_by`,`is_active`
		  FROM `tbl_bridge` WHERE `is_active` = 'active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
	$eth1 =  Sql_Result($row, "interface1");
	$eth2 =  Sql_Result($row, "interface2");
	$eth3 =  Sql_Result($row, "interface3");
	$eth4 =  Sql_Result($row, "interface4");
	
	$eth1_parts = split("-",$eth1);
	$eth1 = $eth1_parts[1];
	
	$eth2_parts = split("-",$eth2);
	$eth2 = $eth2_parts[1];
	
	$eth3_parts = split("-",$eth3);
	$eth3 = $eth3_parts[1];
	$eth4_parts = split("-",$eth4);
	$eth4 = $eth4_parts[1];
    $data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "bridge_name");
	$data[$i][$j++] = Sql_Result($row, "ip");
    $data[$i][$j++] = Sql_Result($row, "net_mask");
	
	if(isset($eth1) && $eth1 != ""){
		 $data[$i][$j++] = $eth1;
	}else{
		  $data[$i][$j++] = "";
	}
	if(isset($eth2) && $eth2 != ""){
		 $data[$i][$j++] = $eth2;
	}else{
		$data[$i][$j++] = "";
	}
	if(isset($eth3) && $eth3 != ""){
		 $data[$i][$j++] = $eth3;
	}else{
		 $data[$i][$j++] = "";
	}
	if(isset($eth4) && $eth4 != ""){
		 $data[$i][$j++] = $eth4;
	}else{
		$data[$i][$j++] = "";
	}
    
	$data[$i][$j++] = '<span onclick="edit_input_form_ipassignment_bridge(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'.'&nbsp&nbsp'.'<span onclick="delete_ipassignment_bridge(this,'.Sql_Result($row, "id").'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';
	
/*
    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_ipassignment_bridge(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_ipassignment_bridge(this,'.Sql_Result($row, "id").'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>';
*/
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>