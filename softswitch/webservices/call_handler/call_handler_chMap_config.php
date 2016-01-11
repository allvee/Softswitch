<?php
/**
 * Created by PhpStorm.
 * User: Shiam
 * Date: 5/20/2015
 * Time: 4:55 PM
 */

require_once "../lib/config.php";
require_once "../lib/common.php";

global $dir_call_handler_test;
global $dir_call_handler_production;

$cn = connectDB();

$arrayInput = $_REQUEST;
$file_name = $dir_call_handler_test."chMap.ini";
$file = fopen($file_name,"w");
fwrite($file,"");
fclose($file);

$file = fopen($file_name,"a");

fwrite($file,trim($arrayInput['chMap_start_Channel'])." ");
fwrite($file,trim($arrayInput['chMap_End_Channel'])." ");
fwrite($file,trim($arrayInput['chMap_Corrosponding_Sip_Server_IP'])." ");
fwrite($file,trim($arrayInput['chMap_Corrosponding_Sip_Server_Port'])." ");
fwrite($file,trim($arrayInput['chMap_IUFP'])." ");
fwrite($file,trim($arrayInput['chMap_IBCP'])." ");
fwrite($file,'//start_Channel    End_Channel    Corrosponding_Sip_Server_IP Corrosponding_Sip_Server_Port  IUFP IBCP'."\n");


fwrite($file,trim($arrayInput['chMap_start_Channel2'])." ");
fwrite($file,trim($arrayInput['chMap_End_Channel2'])." ");
fwrite($file,trim($arrayInput['chMap_Corrosponding_Sip_Server_IP2'])." ");
fwrite($file,trim($arrayInput['chMap_Corrosponding_Sip_Server_Port2'])." ");
fwrite($file,trim($arrayInput['chMap_IUFP2'])." ");
fwrite($file,trim($arrayInput['chMap_IBCP2'])." ");
fwrite($file,'//start_Channel    End_Channel    Corrosponding_Sip_Server_IP Corrosponding_Sip_Server_Port  IUFP IBCP'."\n");

fclose($file);


$file_name = $dir_call_handler_production."chMap.ini";
$file = fopen($file_name,"w");
fwrite($file,"");
fclose($file);

$file = fopen($file_name,"a");

fwrite($file,trim($arrayInput['chMap_start_Channel'])." ");
fwrite($file,trim($arrayInput['chMap_End_Channel'])." ");
fwrite($file,trim($arrayInput['chMap_Corrosponding_Sip_Server_IP'])." ");
fwrite($file,trim($arrayInput['chMap_Corrosponding_Sip_Server_Port'])." ");
fwrite($file,trim($arrayInput['chMap_IUFP'])." ");
fwrite($file,trim($arrayInput['chMap_IBCP'])." ");
fwrite($file,'//start_Channel    End_Channel    Corrosponding_Sip_Server_IP Corrosponding_Sip_Server_Port  IUFP IBCP'."\n");


fwrite($file,trim($arrayInput['chMap_start_Channel2'])." ");
fwrite($file,trim($arrayInput['chMap_End_Channel2'])." ");
fwrite($file,trim($arrayInput['chMap_Corrosponding_Sip_Server_IP2'])." ");
fwrite($file,trim($arrayInput['chMap_Corrosponding_Sip_Server_Port2'])." ");
fwrite($file,trim($arrayInput['chMap_IUFP2'])." ");
fwrite($file,trim($arrayInput['chMap_IBCP2'])." ");
fwrite($file,'//start_Channel    End_Channel    Corrosponding_Sip_Server_IP Corrosponding_Sip_Server_Port  IUFP IBCP'."\n");

fclose($file);

$config_text =  json_encode($arrayInput);
$time_now = date("Y-m-d H:i:s");

$sql = "insert into `tbl_app_configuration` (applicaiton,component,config_text,updated) VALUES ('call_handler','chMap','".$config_text."','".$time_now."')";
Sql_exec($cn,$sql);

