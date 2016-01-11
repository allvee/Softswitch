<?php
require_once "../lib/common.php";
$cn = connectDB();
$data= array();
$data=$_REQUEST['info'];
$command = mysql_real_escape_string(htmlspecialchars($data['command']));
$restart_command = "sudo " . $command;
echo '<div>';
echo "<pre>";
try {
    system($restart_command);
} catch (Exception $e) {
}
ClosedDBConnection($cn);
echo "</pre>";
echo '</div>';
?>