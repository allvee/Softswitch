<?php
require_once "../lib/common.php";

$is_available = 0;
$cn = connectDB();
$qry = "Select version_name,curr_version,available_version,available_version_name,auto_upgrade from ugw_version.version where is_active='active' limit 0,1";
$rs = Sql_fetch_array(Sql_exec($cn, $qry));
$curr_version = intval($rs['curr_version']);
$available_version = intval($rs['available_version']);
$available_version_name = $rs['available_version_name'];
$version_name = $rs['version_name'];

if (($available_version > $curr_version) && ($rs['auto_upgrade'] == "yes")) {
    $is_available = 1;
} elseif ($rs['auto_upgrade'] == "no") {
    $is_available = 2;
}

echo $is_available . "|" . $available_version_name . "|" . $curr_version . "|" . $available_version . "|" . $version_name;
ClosedDBConnection($cn);
?>