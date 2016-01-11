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
$query ="select d.subnet,h.* from tbl_dhcp_host h inner join tbl_dhcp d on h.dhcp_id=d.id where h.is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "subnet");
    $data[$i][$j++] = Sql_Result($row, "host_user");
    $data[$i][$j++] = Sql_Result($row, "host_name");

    $data[$i][$j++] = Sql_Result($row, "hd_ethernet");
    $data[$i][$j++] = Sql_Result($row, "fixed_address");


    $data[$i][$j++] =  '<span  onclick="edit_input_form_dhcp_host(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_dhcp_host(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);