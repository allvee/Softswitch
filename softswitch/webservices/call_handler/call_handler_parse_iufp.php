<?php
/**
 * Created by PhpStorm.
 * User: Shiam
 * Date: 5/20/2015
 * Time: 8:15 PM
 */
require_once "../lib/common.php";
global $dir_call_handler_test;

$file_name = $dir_call_handler_test."iufp.ini";
$line = file($file_name);
$map = '';
if($line) {
    $map = Array();
    $i=0;
//    print_r($line);
    foreach ($line as $row) {
        $arr = explode(" ", $row);
//        print_r($arr);
        if ($i==0) $map['iufp_InitMasterInfo_BYTE'] = $arr[0];
        else if($i==1) $map['iufp_RFCI_BYTE'] = $arr[0];
        else if($i==2) $map['iufp_IPTI_BYTE'] = $arr[0];
        else if($i==3) $map['iufp_IUModeSupport_short'] = $arr[0];
        else if($i==4) $map['iufp_DataPDUType'] = $arr[0];
        $i++;
    }
    $status = true;
} else {
    $status = false;
}
$return_data = array('status'=>$status,'map'=>$map);
echo json_encode($return_data);

