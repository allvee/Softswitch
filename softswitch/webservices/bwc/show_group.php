<?php
//session_start();
header('Access-Control-Allow-Origin: *');
require_once "../lib/common.php";
//require_once "../Lib/filewriter.php";



//print_r($info);
//print_r($_SESSION);
//exit;
//
$cn = connectDB();
//$qry = "select `id`,`group_name`,`bandwidth`,`bw_limit`,`mode`,`laninterface`,`waninterface`,`g_priority` from `tbl_bwm_group` where `is_active`='active'";
$qry = "select * from bwc_groupinfo where is_active='active'";
$rs = Sql_exec($cn,$qry);
$data = array();
$i=0;
while($row = Sql_fetch_array($rs)){

    $j=0;
    $data[$i][$j++] = Sql_Result($row, "groupName");
    $data[$i][$j++] = Sql_Result($row, "lan");
    $data[$i][$j++] = Sql_Result($row, "wan");
    $data[$i][$j++] = Sql_Result($row, "upload");
    $data[$i][$j++] = Sql_Result($row, "download");
    $data[$i][$j++] = Sql_Result($row, "brust");
    $data[$i][$j++] = Sql_Result($row, "priority");
    $data[$i][$j++] = Sql_Result($row, "max_upload");
    $data[$i][$j++] = Sql_Result($row, "max_download");
    $data[$i][$j++] = Sql_Result($row, "queue");
    $data[$i][$j++] = Sql_Result($row, "mode");
    $data[$i][$j++] = '<span onclick="edit_input_form_bwc_group(this,'."'".Sql_Result($row, "groupId")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'.'&nbsp&nbsp&nbsp'.'<span onclick="delete_bwc_group(this,'."'".Sql_Result($row, "groupId")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';
  /*$data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_bwc_group(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>' . '<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_bwc_group(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>';*/
    $i++;
}



echo json_encode($data);
ClosedDBConnection($cn);


?>
