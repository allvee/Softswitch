<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/24/2015
 * Time: 4:41 PM
 */

include_once "../lib/common.php";
$qry="select DISTINCT (`name`) from `tbl_alert_event`";
$cn = connectDB();
$rs = Sql_exec($cn, $qry);
$data='';
while($dt = Sql_fetch_array($rs)){
    $data .= "<option value = '".$dt['name']."' >".$dt['name']."</option>";
}
ClosedDBConnection($cn);
echo $data;
?>