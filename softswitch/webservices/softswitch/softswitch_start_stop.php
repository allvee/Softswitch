<?php
require_once "../lib/global_config.php";
$data= array();

if(!isset($_POST['info'])) exit;
$data=$_POST['info']['command'];
//$data=$_POST['info'];
$cmd = "";
echo "data:".$data;
if($data == "start"){ 

   $output = exec('sudo -u root /Softswitch1/Softswitch/start.sh');
   echo "<pre>". $output ."</pre>";

    
  // $secure_cmd = escapeshellcmd("/Softswitch1/Softswitch/start.sh");
  // $output = shell_exec($secure_cmd);
   //echo "<pre>". $output ."</pre>";

	//$cmd = "sudo sh ".$dir_softswitch_start;
} elseif($data == "stop"){
//	$cmd = "sudo sh ".$dir_softswitch_stop;system("sudo /bwp/stop.sh");
 system("sudo /Softswitch1/Softswitch/stop.sh");

}
//echo "cmd:".$cmd;
	try {
		//system($cmd);
   //echo shell_exec('sudo sh /Softswitch1/Softswitch/runSoftswitch.sh');
   echo shell_exec('sudo -u root /Softswitch1/Softswitch/start.sh');
   echo $contents;
	} catch (Exception $e) {
	}

/*
$old_path = getcwd();
chdir('/Softswitch1/Softswitch/');
$output = shell_exec('./keep_running_script_cron.sh');
chdir($old_path);*/


?>
