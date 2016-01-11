<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/6/2015
 * Time: 6:19 PM
 */

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select id,local_ip,remote_ip from tbl_pptp_server where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data['table1'][$i][$j++] = Sql_Result($row, "id");
    $data['table1'][$i][$j++] = Sql_Result($row, "local_ip");
    $data['table1'][$i][$j++] = Sql_Result($row, "remote_ip");

    $data['table1'][$i][$j++] =  '<span  onclick="edit_input_form_vpn_pptp_server(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_vpn_pptp_server(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';
    $i++;
}
Sql_Free_Result($result);

$query = "select id,user_name,password,ip from tbl_vpn_pptp_client where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}

$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data['table2'][$i][$j++] = Sql_Result($row, "id");
    $data['table2'][$i][$j++] = Sql_Result($row, "user_name");
    $data['table2'][$i][$j++] = Sql_Result($row, "password");
    $data['table2'][$i][$j++] = Sql_Result($row, "ip");

    $data['table2'][$i][$j++] =  '<span  onclick="edit_input_form_vpn_pptp_client(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_vpn_pptp_client(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>
