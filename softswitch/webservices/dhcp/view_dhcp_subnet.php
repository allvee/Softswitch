<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/11/2015
 * Time: 2:39 PM
 */


include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query ="select id,subnet,net_mask,gateway,domain_name,domain_name_server1,domain_name_server2, netbios_name_server,default_lease_time,max_lease_time,interface  from tbl_dhcp where is_active='active'";
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
    $data[$i][$j++] = Sql_Result($row, "net_mask");
    $data[$i][$j++] = Sql_Result($row, "gateway");

    $data[$i][$j++] = Sql_Result($row, "domain_name");
    $data[$i][$j++] = Sql_Result($row, "domain_name_server1");
    $data[$i][$j++] = Sql_Result($row, "netbios_name_server");

    $data[$i][$j++] = Sql_Result($row, "interface");
    $data[$i][$j++] = Sql_Result($row, "max_lease_time");

    $data[$i][$j++] =  '<span  onclick="edit_input_form_dhcp_subnet(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_dhcp_subnet(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);
