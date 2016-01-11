<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/22/2015
 * Time: 6:19 PM
 */


include_once "../lib/common.php";

//$remoteCn = remote_connectDB('SMSGW');

$action = "";
$src_ip = "";
$dest_ip = "";
$port = "";
$capture_size = "";
$tcpdump_interface = "";
$Status = "";
$is_error = 1;
$src_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['src_ip']));
$dest_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['dest_ip']));
$port = mysql_real_escape_string(htmlspecialchars($_REQUEST['port']));
$capture_size = mysql_real_escape_string(htmlspecialchars($_REQUEST['capture_size']));
$tcpdump_interface = mysql_real_escape_string(htmlspecialchars($_REQUEST['tcpdump_interface']));


if ($is_error) {
    $return_data = array('status' => false, 'message' => 'Submission Failed');
} else {
    $return_data = array('status' => true, 'message' => $msg);
}

echo json_encode($return_data);

ClosedDBConnection($remoteCn);
?>

