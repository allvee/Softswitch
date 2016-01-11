<?php
require_once "../lib/common.php";
require_once "../lib/filewriter.php";
$remoteCn = remote_connectDB('ISMP');
$info = $_POST['info'];
$action_id = $info['action_id'];
// unset unnessary filed from array
unset($info['action_id']);

$qry = "SELECT 	`app_id`,`app_name`,`config` FROM `tbl_smsgw_config` WHERE `app_id` = '$action_id' AND `app_name` = 'smsgw'";
$res = Sql_exec($remoteCn,$qry);
$dt = Sql_fetch_array($res);
$config_str_json = trim($dt['config']);
$assoc_array = json_decode($config_str_json,true);


foreach($info as $key=>$value){
    	
		if(array_key_exists($key,$assoc_array)){
		      $assoc_array[$key] = $value;
		}
}

$json_str = json_encode($assoc_array);

$is_error = 0;
$update_config_str = "UPDATE `tbl_smsgw_config` SET `config` = '$json_str' WHERE `app_id` = '$action_id'";
try{
	Sql_exec($remoteCn,$update_config_str);
	$is_error = file_writer_smsgw_configuration($assoc_array);
}catch(Exception $e){
   $is_error = 1;	
}

echo $is_error;
ClosedDBConnection($remoteCn);


?>