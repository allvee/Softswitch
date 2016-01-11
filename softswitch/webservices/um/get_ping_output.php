<?php
require_once "../lib/common.php";
$cn = connectDB();
$max_count = 10; //maximum count for ping command
$count  = 4;
$info = $_POST['info'];

if(isset($info['count']) && $info['count']){
	$count = mysql_real_escape_string(htmlspecialchars($info['count']));
}
	
$interface = mysql_real_escape_string(htmlspecialchars($info['interface']));	
$host = mysql_real_escape_string(htmlspecialchars($info['host']));

      $host= preg_replace ("/[^A-Za-z0-9.-]/","",$host);
      $count= preg_replace ("/[^0-9.]/","",$count);
   
      echo '<pre>';           
	  $cmd = "ping -c".$count." -w".$count." $host";
	  if(trim($interface)!='default'){
		  $cmd .= " -I ".$interface;
	  }
      system ($cmd);
      system("killall ping");// kill all ping processes in case there are some stalled ones or use echo 'ping' to execute ping without shell
      echo '</pre>';

ClosedDBConnection($cn);
?>