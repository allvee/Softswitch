<?php
require_once "../lib/common.php";

$remoteCn = remote_connectDB('ISMP');

$qry = "SELECT 	`app_id`,`app_name`,`config` FROM `tbl_smsgw_config` WHERE `app_id` = 1 AND `app_name` = 'smsgw'";
$res = Sql_exec($remoteCn,$qry);
$dt = Sql_fetch_array($res);
 
$decode=$dt['config'];
$decode = json_decode($decode,true);


$data = array();
foreach($decode as $key=>$val){
   $data[$key]	= $val;
}

$data['action_id'] = $dt['app_id'];

echo json_encode($data);
ClosedDBConnection($remoteCn);


?>