<?php
require_once "../lib/common.php";
$cn = connectDB();

$info = $_POST['info'];

$type = mysql_real_escape_string(htmlspecialchars($info['type']));

$src_ip   = mysql_real_escape_string(htmlspecialchars($info['src']));
$dest_ip   = mysql_real_escape_string(htmlspecialchars($info['dest']));
$port   = mysql_real_escape_string(htmlspecialchars($info['port']));
$cap   = mysql_real_escape_string(htmlspecialchars($info['cap']));
$interface   = mysql_real_escape_string(htmlspecialchars($info['interface']));
$file_name   = mysql_real_escape_string(htmlspecialchars($info['file_name']));

$command = "";
if(isset($cap) && $cap != ""){
    $command = "sudo tcpdump -XX -c ".intval($cap); 	
}else{
	$command = "sudo tcpdump -XX -c  128";
}

if(isset($interface) && $interface != ""){
    $command .= " -i ".$interface; 	
}else{
}


if(isset($src_ip) && $src_ip != ""){
    $command .= " src ".$src_ip; 	
}else{
}
if(isset($dest_ip) && $dest_ip != ""){
	if(isset($src_ip) && $src_ip != "")
    $command .= " and dst ".$dest_ip;
	else  $command .= " dst ".$dest_ip;
}else{
}

if(isset($port) && $port != ""){
	if((isset($src_ip) && $src_ip != "") |(isset($dest_ip) && $dest_ip != ""))
    $command .= " and port ".$port; 
	else  $command .= " port ".$port; 	
}else{
	//$command = "sudo tcpdump  -c  128";
}


if($type == 'screen'){
	
	 $output = shell_exec($command); 
	 echo '<pre>';
	  echo htmlspecialchars($output);
	 echo '</pre>';
}else if($type == 'filewrite'){
        
        $str = time();
        if(isset($file_name) && $file_name != null){ 
	       $command .= " -w ".$tcp_dump_path.$file_name ."_".$str.".pcap";
	 }else{
		
		$command .= " -w ".$tcp_dump_path."dump" ."_".$str.".pcap";
	 }
	 
	 $safe_cmd = escapeshellcmd($command);
	

          if(system($safe_cmd)===FALSE){
		echo 1;
	   }else{
		echo 0;
	   }
      
}else if($type == 'fileread'){
   	 $command = "sudo tcpdump -XX -r ".$tcp_dump_path.$file_name.".pcap";
	 $output = shell_exec($command); 
	 echo '<pre>';
	  echo htmlspecialchars($output);
	 echo '</pre>';
    
}else if($type == 'file_del'){
	 //$command .= " -w ".$tcp_dump_path.$file_name .".pcap";
	 if(unlink($tcp_dump_path.$file_name.".pcap")){
		 echo 0;
	 }else{
	     echo 1;	 
	 }
	 
}

ClosedDBConnection($cn);
  
      
?>