<?php
require_once  "../lib/common.php";

$cn = connectDB();


$qry = "SELECT `group_name`
		FROM `tbl_bwm_group`
		WHERE `is_active`='active'
		ORDER BY `group_name` ASC";
$res = Sql_exec($cn,$qry);

$interface_options = "";
while($dt = Sql_fetch_array($res)){
    $group_name = "";

    $group_name = $dt['group_name'];
    $name  .= '<option value="'.$group_name.'">'.$group_name.'</option>';
}

ClosedDBConnection($cn);
echo $name;

?>