<?php

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select id,source_ip,source_port,source_protocol,destination_ip,destination_port,destination_protocol,route_type,context_name from tbl_ippbx_route where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "source_ip");
    $data[$i][$j++] = Sql_Result($row, "source_port");
    $data[$i][$j++] = Sql_Result($row, "source_protocol");
    $data[$i][$j++] = Sql_Result($row, "destination_ip");
    $data[$i][$j++] = Sql_Result($row, "destination_port");
    $data[$i][$j++] = Sql_Result($row, "destination_protocol");
    $data[$i][$j++] = Sql_Result($row, "route_type");
    $data[$i][$j++] = Sql_Result($row, "context_name");

    $data[$i][$j++] = '<span onclick="edit_input_form_route_info(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="delete_route_info(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';
    
//    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_route_info(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
//</button>' . '<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_route_info(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
//</button>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);
?>
