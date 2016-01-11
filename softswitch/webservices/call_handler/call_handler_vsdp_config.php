<?php
/**
 * Created by PhpStorm.
 * User: Shiam
 * Date: 5/18/2015
 * Time: 4:18 PM
 */

require_once "../lib/config.php";
require_once "../lib/common.php";

global $dir_call_handler_test;
global $dir_call_handler_production;

$cn = connectDB();

$arrayInput = $_REQUEST;

$filename_1 = $dir_call_handler_test."vsdp.ini";
$filename_2 = $dir_call_handler_production."vsdp.ini";

$file = fopen($filename_1,"w");
fwrite($file,"");
fclose($file);

$file = fopen($filename_2,"w");
fwrite($file,"");
fclose($file);

$file1 = fopen($filename_1,"a");
$file2 = fopen($filename_2,"a");

foreach($arrayInput as $k => $v) {
    /*echo "$k -> $v";*/
    fwrite($file1,$k.'->'.trim($v)."\n");
    fwrite($file2,$k.'->'.trim($v)."\n");
}

$config_text =  json_encode($arrayInput);
$time_now = date("Y-m-d H:i:s");

$sql = "insert into `tbl_app_configuration` (applicaiton,component,config_text,updated) VALUES ('call_handler','vsdp','".$config_text."','".$time_now."')";
Sql_exec($cn,$sql);

fclose($file1);
fclose($file2);



