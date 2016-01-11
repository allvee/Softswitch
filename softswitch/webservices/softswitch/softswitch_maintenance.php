
<?php
require_once "../lib/global_config.php";
//system("sudo sh /ismp/test/vsdp/callhandler/runCallhandler.sh");
header('Access-Control-Allow-Origin: *');

$info = $_REQUEST["info"];
$cmd = $info['cmd']; 



if( $cmd == "stop" ){
//   system("sudo /Softswitch1/Softswitch/stop.sh");
echo "<pre>";
 system($dir_softswitch_stop);
}
else if($cmd == "start"){
 // $output = exec('sudo -u root /Softswitch1/Softswitch/start.sh 2>&1');
// echo $dir_softswitch_start;
  //$output=
  
  //$output = shell_exec('ps -A|softswtich'); 
  //if($output != null)
  //{
   system($dir_softswitch_start);
  //}
  
 // echo "<pre>". $output ."</pre>";

}else if($cmd == "restart"){
   #$secure_cmd = escapeshellcmd($dir_name."restart.sh");
  //$output = exec('sudo -u root /Softswitch1/Softswitch/restart.sh');
 $output = exec($dir_softswitch_restart);
 
  echo "<pre>".$output."</pre>";

}else{
   echo "<pre>". "Usage:: stop|start|restart" ."</pre>";

}

?>
