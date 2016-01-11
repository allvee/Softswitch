<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/19/2015
 * Time: 6:20 PM
 */

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select * from tbl_ippbx_configuration where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {

    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "udp_bind_ip");
    $data[$i][$j++] = Sql_Result($row, "udp_signaling_port");
    $data[$i][$j++] = Sql_Result($row, "udp_signaling_protocol");
    $data[$i][$j++] = Sql_Result($row, "udp_media_port");
    $data[$i][$j++] = Sql_Result($row, "udp_media_protocol");
    $data[$i][$j++] = Sql_Result($row, "tcp_bind_ip");
    $data[$i][$j++] = Sql_Result($row, "tcp_signaling_port");
    $data[$i][$j++] = Sql_Result($row, "tcp_signaling_protocol");
    $data[$i][$j++] = Sql_Result($row, "tcp_media_port");
    $data[$i][$j++] = Sql_Result($row, "tcp_media_protocol");
    $data[$i][$j++] = Sql_Result($row, "log_level");
    $data[$i][$j++] = Sql_Result($row, "log_destination");
    $data[$i][$j++] = Sql_Result($row, "rcportal_control_udp_port");
    $data[$i][$j++] = Sql_Result($row, "log_tcp_port");


    $data[$i][$j++] = '<span onclick="edit_soft_config(this,\'' . Sql_Result($row, "id") . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
        . '&nbsp&nbsp' . '<span onclick="delete_soft_config(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

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