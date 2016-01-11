<?php
require_once "../lib/common.php";
$cn = connectDB();

$data= array();
$data=$_REQUEST['info'];

$command = mysql_real_escape_string(htmlspecialchars($data['command']));

$command_arr = explode("_", $command);

$restart_command = "sudo /etc/init.d/" . $command_arr[0] . " " . $command_arr[1];
// echo '<div style="display:none;">';
echo '<pre>';
try {
    system($restart_command);
} catch (Exception $e) {
}
ClosedDBConnection($cn);
echo '</pre>';
// echo '</div>';
?>