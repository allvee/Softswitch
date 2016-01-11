<?php

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
		
$query = "SELECT * FROM tbl_nat_dynamic where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "name");
    $data[$i][$j++] = Sql_Result($row, "direction");
    $data[$i][$j++] = Sql_Result($row, "interface");
    $data[$i][$j++] = Sql_Result($row, "source_ip");
    $data[$i][$j++] = Sql_Result($row, "exclude_src_ip");
    $data[$i][$j++] = Sql_Result($row, "destination_ip");
    $data[$i][$j++] = Sql_Result($row, "exclude_dest_ip");

    $data[$i][$j++] = '<span onclick="edit_input_form_nat_dynamic(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="delete_nat_dynamic(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);
?>
