<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/23/2015
 * Time: 7:43 PM
 */
include_once "../lib/common.php";
$qry="select DISTINCT (`group_name`) from `tbl_alert_group_name`";
$cn = connectDB();
$rs = Sql_exec($cn, $qry);
$data='';
while($dt = Sql_fetch_array($rs)){
    $data .= "<option value = '".$dt['group_name']."' >".$dt['group_name']."</option>";
}
ClosedDBConnection($cn);
echo $data;
?>