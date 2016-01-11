<?php
/**
 * Created by PhpStorm.
 * User: Shiam
 * Date: 5/20/2015
 * Time: 6:17 PM
 */

require_once "../lib/config.php";
require_once "../lib/common.php";

global $dir_call_handler_test;
global $dir_call_handler_production;

$cn = connectDB();

$file_name = $dir_call_handler_test."iufp.ini";

$arrayInput = $_REQUEST;

$file = fopen($file_name,"w");
fwrite($file,"");
fclose($file);

$file = fopen($file_name,"a");

fwrite($file,trim($arrayInput['iufp_InitMasterInfo_BYTE']). " "); fwrite($file,"//InitMasterInfo BYTE\n");
fwrite($file,trim($arrayInput['iufp_RFCI_BYTE'])." "); fwrite($file,"//RFCI BYTE\n");
fwrite($file,trim($arrayInput['iufp_IPTI_BYTE'])." "); fwrite($file,"//IPTI BYTE\n");
fwrite($file,trim($arrayInput['iufp_IUModeSupport_short'])." "); fwrite($file,"//IUModeSupport short\n");
fwrite($file,trim($arrayInput['iufp_DataPDUType'])." "); fwrite($file,"//DataPDUType\n");

fclose($file);

$file_name = $dir_call_handler_production."iufp.ini";

$arrayInput = $_REQUEST;

$file = fopen($file_name,"w");
fwrite($file,"");
fclose($file);

$file = fopen($file_name,"a");

fwrite($file,trim($arrayInput['iufp_InitMasterInfo_BYTE']). " "); fwrite($file,"//InitMasterInfo BYTE\n");
fwrite($file,trim($arrayInput['iufp_RFCI_BYTE'])." "); fwrite($file,"//RFCI BYTE\n");
fwrite($file,trim($arrayInput['iufp_IPTI_BYTE'])." "); fwrite($file,"//IPTI BYTE\n");
fwrite($file,trim($arrayInput['iufp_IUModeSupport_short'])." "); fwrite($file,"//IUModeSupport short\n");
fwrite($file,trim($arrayInput['iufp_DataPDUType'])." "); fwrite($file,"//DataPDUType\n");

fclose($file);

$config_text =  json_encode($arrayInput);
$time_now = date("Y-m-d H:i:s");

$sql = "insert into `tbl_app_configuration` (applicaiton,component,config_text,updated) VALUES ('call_handler','iufp','".$config_text."','".$time_now."')";
Sql_exec($cn,$sql);

