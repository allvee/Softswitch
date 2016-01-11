<?php
header('Access-Control-Allow-Origin: *');
require_once "../lib/common.php";
$cn = connectDB();
$options = '';
$select_interface = "SELECT DISTINCT interface_name FROM tbl_interface WHERE bridge='no' AND is_active='active' AND (vlan='yes' OR vlan='none') ORDER BY interface_name asc";
$rs_interface = Sql_exec($cn, $select_interface);
while ($dt = Sql_fetch_array($rs_interface)) {
    $interface_name = $dt['interface_name'];
    $name_parts = split("-", $interface_name);
    $device = $name_parts[1];
    $options .= '<option value="' . $device . '">' . $device . '</option>';
}
$select_bridge = "SELECT DISTINCT bridge_name FROM tbl_bridge WHERE is_active='active' order by bridge_name";
$rs_bridge = Sql_exec($cn, $select_bridge);

while ($dt = Sql_fetch_array($rs_bridge)) {
    $device = $dt['bridge_name'];
    $options .= '<option value="' . $device . '">' . $device . '</option>';
}
ClosedDBConnection($cn);
echo $options;
