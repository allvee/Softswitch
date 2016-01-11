<?php
/**
 * Created by PhpStorm.
 * User: Shiam
 * Date: 5/19/2015
 * Time: 8:59 PM
 */
//error_reporting(0);
require_once "../lib/config.php";

global $dir_call_handler_test;

$file_name= $dir_call_handler_test."vsdp.ini";
$line = file($file_name);
$map='';
if($line) {
    $map = Array();
    foreach ($line as $row) {
        $arr = explode("->", $row);
        if (count($arr) >= 2)
            $map[$arr[0]] = $arr[1];
        else
            echo 'Array size: ' . count($arr) . ' -> ' . $row;
    }
    $status=true;
} else {
    $status=false;
}

$return_data = array('status' => $status, 'map' => $map);
echo json_encode($return_data);


 /*$file_handle = fopen("vsdp.ini", "r");
while (!feof($file_handle)) {
    $line = fgets($file_handle);
    $arr = explode("->",$line);
    if( count($arr) >=2 )
        $map[$arr[0]] = $arr[1];
    else
        echo 'Array size: '.count($arr).' -> '.$line;
}
fclose($file_handle);
echo json_encode($map);*/

