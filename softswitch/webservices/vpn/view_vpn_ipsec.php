<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/6/2015
 * Time: 3:04 PM
 */

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select id,ipsec_name,left_v,leftsubnet,right_v,rightsubnet,ike,esp,pfs,ikelifetime,keylife,psk from tbl_vpn_ipsec where is_active='active'";
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
    $data[$i][$j++] = Sql_Result($row, "ipsec_name");
    $data[$i][$j++] = Sql_Result($row, "left_v");
    $data[$i][$j++] = Sql_Result($row, "leftsubnet");
    $data[$i][$j++] = Sql_Result($row, "right_v");
    $data[$i][$j++] = Sql_Result($row, "rightsubnet");
    $data[$i][$j++] = Sql_Result($row, "ike");
    $data[$i][$j++] = Sql_Result($row, "esp");
    $data[$i][$j++] = Sql_Result($row, "pfs");
    $data[$i][$j++] = Sql_Result($row, "ikelifetime");
    $data[$i][$j++] = Sql_Result($row, "keylife");
    $data[$i][$j++] = Sql_Result($row, "psk");
    $data[$i][$j++] ='<span  onclick="edit_input_form_vpn_ipsec(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_vpn_ipsec(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>'.'<span    ""  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/status-icon.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>
