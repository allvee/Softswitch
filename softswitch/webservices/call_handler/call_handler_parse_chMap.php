<?php
/**
 * Created by PhpStorm.
 * User: Shiam
 * Date: 5/20/2015
 * Time: 2:55 PM
 */
//error_reporting(0);

require_once "../lib/config.php";
global $dir_call_handler_test;

$file_name= $dir_call_handler_test."chMap.ini";
$line = file($file_name);
$map = '';
//print_r($line);
if($line) {
    $map = array();
    foreach ($line as $row) {
        $arr = explode(" ", $row);

        if(count($map)<1) {
            //print_r($arr);
            $map['chMap_start_Channel'] = $arr[0];
            $map['chMap_End_Channel'] = $arr[1];
            $map['chMap_Corrosponding_Sip_Server_IP'] = $arr[2];
            $map['chMap_Corrosponding_Sip_Server_Port'] = $arr[3];
            $map['chMap_IUFP'] = $arr[4];
            $map['chMap_IBCP'] = $arr[5];
        } else {
            //print_r($arr);
            $map['chMap_start_Channel2'] = $arr[0];
            $map['chMap_End_Channel2'] = $arr[1];
            $map['chMap_Corrosponding_Sip_Server_IP2'] = $arr[2];
            $map['chMap_Corrosponding_Sip_Server_Port2'] = $arr[3];
            $map['chMap_IUFP2'] = $arr[4];
            $map['chMap_IBCP2'] = $arr[5];
        }
    }
    $status = true;
} else {
    $status = false;
}
$return_data = array('status'=>$status,'map'=>$map);
echo json_encode( $return_data );



