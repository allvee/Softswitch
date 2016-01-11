<?php

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select id,gw_name,gw_context,gw_ip,gw_port,gw_direction,gw_nat from tbl_ippbx_gw where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "gw_name");
    $data[$i][$j++] = Sql_Result($row, "gw_ip");
    $data[$i][$j++] = Sql_Result($row, "gw_port");
    $data[$i][$j++] = Sql_Result($row, "gw_direction");
    $data[$i][$j++] = Sql_Result($row, "gw_nat");
    $data[$i][$j++] = Sql_Result($row, "gw_context");


    $data[$i][$j++] = '<span onclick="edit_input_form_context_info(this,\'' . Sql_Result($row, "id") . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/pen.png" ></span>'
        . '&nbsp&nbsp' . '<span onclick="delete_context_info(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/cancel.png" ></span>';

    /*
    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_context_info(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_context_info(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>';
    */
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>
