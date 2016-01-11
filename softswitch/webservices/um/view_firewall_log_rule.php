<?php

require_once "../lib/common.php";
$cn = connectDB();
global $dir_firewall_group;
$dir_firewall_group;

$data = $_REQUEST['info'];
$rule = $data['rule'];

$file_name = $dir_firewall_group . "firewallRule.txt";
$file_data = file($file_name);
$file_length = sizeof($file_data);

$output_data = '';

foreach ($file_data as $key => $value) {
    if($key==$rule-1){
       $output_data =  $value;
       break;
    }
    
}
ClosedDBConnection($cn);
echo $output_data;
?>