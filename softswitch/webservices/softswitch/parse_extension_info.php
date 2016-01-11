<?php

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select `id`,`e_userId`,e_password,e_userType,e_hwNo,e_allowedIp,e_allowedPort,`e_fwdib`,e_fwdiu,e_fwdina,e_rbtno,e_mcaNo,e_status,e_aaaIp,
e_aaaPort,e_noOAS from tbl_ippbx_extensions where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
$id=Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "e_userId");
    $data[$i][$j++] = Sql_Result($row, "e_password");
    $data[$i][$j++] = Sql_Result($row, "e_userType");
    $data[$i][$j++] = Sql_Result($row, "e_hwNo");
    $data[$i][$j++] = Sql_Result($row, "e_allowedIp");
    $data[$i][$j++] = Sql_Result($row, "e_allowedPort");
    $data[$i][$j++] = Sql_Result($row, "e_fwdib");
    $data[$i][$j++] = Sql_Result($row, "e_fwdiu");
    $data[$i][$j++] = Sql_Result($row, "e_fwdina");
    $data[$i][$j++] = Sql_Result($row, "e_rbtno");
    $data[$i][$j++] = Sql_Result($row, "e_mcaNo");
    $data[$i][$j++] = Sql_Result($row, "e_status");
    $data[$i][$j++] = Sql_Result($row, "e_aaaIp");
    $data[$i][$j++] = Sql_Result($row, "e_aaaPort");
    $data[$i][$j++] = Sql_Result($row, "e_noOAS");


    $info = '' . Sql_Result($row, "id") . '|' . Sql_Result($row, "name") . '|' . Sql_Result($row, "ip_address") . '|' . Sql_Result($row, "port") . '|' . Sql_Result($row, "ep_type") . '|' . Sql_Result($row, "user_name")  . '|' . Sql_Result($row, "password") . '|' . Sql_Result($row, "type") ;


     $data[$i][$j++] = '<span onclick="edit_input_form_extensions_info(this,\'' . $i . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/pen.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="delete_extensions_info(this,\'' . $id . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/cancel.png" ></span>';


    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>