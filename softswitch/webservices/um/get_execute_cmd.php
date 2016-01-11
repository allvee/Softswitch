<?php
require_once "../lib/common.php";

$info = $_POST['info'];
$cn = connectDB();

$host   = mysql_real_escape_string(htmlspecialchars($info['host']));
echo '<pre>';    
echo $host."<br/>";       
system ("sudo ".$host);
echo '</pre>';
ClosedDBConnection($cn);
?>