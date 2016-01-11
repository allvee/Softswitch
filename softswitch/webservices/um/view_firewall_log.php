<?php

require_once "../lib/common.php";
$cn = connectDB();


$content = file_get_contents("http://localhost/cmd-log/fw/fw-log.php?cmd=summary");

$file_data = array_filter(explode("\n", $content));



$file_length = sizeof($file_data);

$data = array();
$i = 0;
foreach ($file_data as $key => $value) {
    $ip_rule = explode('|', $value);
    $j = 0;
    $ip = trim($ip_rule[0]);
    $rule = trim($ip_rule[1]);
    $data[$i][$j++] = $ip;
    $data[$i][$j++] = 'Rule# '.$rule;
    $data[$i][$j++] = '<span onclick="show_firewall_log_rule(this,' . "'" . $ip . "'" .",'".$rule."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/status-icon.png" ></span>';
    $i++;
}
ClosedDBConnection($cn);
echo json_encode($data);
?>