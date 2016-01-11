<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/12/2015
 * Time: 6:54 PM
 */
include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query ="select * from tbl_dhcp_range where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "range_start");
    $data[$i][$j++] = Sql_Result($row, "range_end");


    $data[$i][$j++] =  '<span  onclick="edit_input_form_dhcp_range(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_dhcp_range(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);