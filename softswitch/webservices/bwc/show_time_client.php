<?php
require_once  "../lib/common.php";

$cn = connectDB();


$qry = "SELECT `packageId`,`packageName`
		FROM `bwc_timepackageinfo`
		WHERE `is_active`='active'
		ORDER BY `packageName` ASC";
$res = Sql_exec($cn,$qry);

$interface_options = "";
while($dt = Sql_fetch_array($res)){

    $package_id = $dt['packageId'];
    $package_name = $dt['packageName'];
    $name  .= '<option value="'.$package_id.'">'.$package_name.'</option>';
}

ClosedDBConnection($cn);
echo $name;

?>