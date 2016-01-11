<?php
/**
 * Created by PhpStorm.
 * User: Plabon Dutta
 * Date: 26-Jul-15
 * Time: 12:35 PM
 */


include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select id, `name`,ip_address,port,user_name, password,ep_type,`type` from tbl_softswitch_gateway where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "name");
    $data[$i][$j++] = Sql_Result($row, "ip_address");
    $data[$i][$j++] = Sql_Result($row, "port");
    $data[$i][$j++] = Sql_Result($row, "ep_type");
    $data[$i][$j++] = Sql_Result($row, "user_name");
    $data[$i][$j++] = Sql_Result($row, "password");
    $data[$i][$j++] = Sql_Result($row, "type");


    $info = '' . Sql_Result($row, "id") . '|' . Sql_Result($row, "name") . '|' . Sql_Result($row, "ip_address") . '|' . Sql_Result($row, "port") . '|' . Sql_Result($row, "ep_type") . '|' . Sql_Result($row, "user_name")  . '|' . Sql_Result($row, "password") . '|' . Sql_Result($row, "type") ;


    $data[$i][$j++] = '<span onclick="edit_soft_gw(this,\'' . $info . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/pen.png" ></span>'
        . '&nbsp&nbsp' . '<span onclick="delete_soft_gw(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/cancel.png" ></span>';

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
