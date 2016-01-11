<?php

$data = $_REQUEST;
include_once "../lib/common.php";

$cn = connectDB();

$select_qry = "SELECT * FROM tbl_ippbx_client_settings limit 1";
$result = Sql_exec($cn, $select_qry);
$data = "";

if (Sql_Num_Rows($result) > 0) {
    if ($dt = Sql_fetch_array($result)) {
        $data .= $dt['server_ip'];
        $data .="|" . $dt['udp_server_port'];
        $data .="|" . $dt['udp_rtp_port'];
        $data .="|" . $dt['tcp_server_port'];
        $data .="|" . $dt['tcp_rtp_port'];
        $data .="|" . $dt['log_server_ip'];
        $data .="|" . $dt['log_server_port'];
        $data .="|" . $dt['im_server_ip'];
        $data .="|" . $dt['im_server_port'];
        $data .="|" . $dt['contact_server_ip'];
        $data .="|" . $dt['contact_server_port'];
        $data .="|" . $dt['connection_type'];
        $data .="|" . $dt['audio_codec'];
        $data .="|" . $dt['rtp_connection_type'];
    }
} else {
    $data = "";
}

ClosedDBConnection($cn);
echo $data;
?>