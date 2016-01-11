<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/5/2015
 * Time: 7:39 PM
 */

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "SELECT * FROM tbl_vpn_l2tp";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "listen_address");
    $data[$i][$j++] = Sql_Result($row, "ip_range");
    $data[$i][$j++] = Sql_Result($row, "local_ip");
    $data[$i][$j++] = Sql_Result($row, "ms_dns");

    $info= ''.Sql_Result($row, "id").'|'.Sql_Result($row, "listen_address").'|'.Sql_Result($row, "ip_range").'|'.Sql_Result($row, "local_ip").'|'.Sql_Result($row, "ms_dns");

    $data[$i][$j++] = '<span onclick="edit_input_form_vpn_l2tp_server(this,\''.$info.'\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
        . '&nbsp&nbsp' . '<span onclick="delete_vpn_l2tp_server(this,'.Sql_Result($row, "id").'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

/*
    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_vpn_l2tp_server(this,\''.$info.'\'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_vpn_l2tp_server(this,'.Sql_Result($row, "id").'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>';
   */
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>