<?php
//session_start();
header('Access-Control-Allow-Origin: *');
require_once "../lib/common.php";
$cn = connectDB();
$qry = "select * from `tbl_bwp_config` limit 1";
$rs = Sql_exec($cn,$qry);
$data = "";
$i=0;
while($row = Sql_fetch_array($rs)){
    $data .= $row["device_id"];
   $data .="|".  $row["device_ip"];
   $data .="|".  $row["idle_user_time"];
   $data .="|".  $row["data_log_directory"];
   $data .="|".  $row["user_log_directory"];
   $data .="|".  $row["nfqueue_num"];
   $data .="|".  $row["bwp_enable"];
   $data .="|".  $row["subnet_mask"];
   $data .="|".  $row["cdr_interval"];
   $data .="|".  $row["cdr_log_directory"];
   $data .="|".  $row["log_level"];
   $data .="|".  $row["cgw_enable"];
   $data .="|".  $row["cgw_data_limit"];
   $data .="|".  $row["cgw_log_directory"];
   $data .="|".  $row["cgw_req_directory"];
   $data .="|".  $row["app_id"];
    $data .="|".  $row["app_password"];
   $data .="|".  $row["cgw_ip"];
   $data .="|".  $row["cgw_port"];
   $data .="|".  $row["cgw_uri"];
   $data .="|".  $row["cgw_host_name"];
   $data .="|".  $row["self_care_ip"];
   $data .="|".  $row["accept_port"];
   $data .="|".  $row["log_level"];
   $data .="|".  $row["cgw_enable"];
}

ClosedDBConnection($cn);

echo $data;

?>