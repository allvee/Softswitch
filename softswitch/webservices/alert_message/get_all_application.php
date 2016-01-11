<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/24/2015
 * Time: 1:30 PM
 */

include_once "../lib/common.php";
$qry="select DISTINCT (`app_name`) from `tbl_alert_application_name`";
$cn = connectDB();
$rs = Sql_exec($cn, $qry);
$data='';
while($dt = Sql_fetch_array($rs)){
    $data .= "<option value = '".$dt['app_name']."' >".$dt['app_name']."</option>";
}
ClosedDBConnection($cn);
echo $data;
?>