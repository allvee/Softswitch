<?php
header('Access-Control-Allow-Origin: *');
require_once "../lib/common.php";
$info = $_POST["info"];
$url = "http://localhost/cmd-log/bwp/bwp.php?cmd=";
//cmd=status%20192.168.5.8"

if(isset($info['cmd']) && $info['cmd']=="status"){
	$url.=urlencode($info['cmd']." ".$info['ip']);
	//$url = urlencode($url);
	$res = file_get_contents($url);
	echo $res;
	
}elseif(isset($info['cmd']) && $info['cmd']=="mac"){
    $url.=urlencode($info['cmd']." ".$info['ip']);
	//$url = urlencode($url);
	$res = file_get_contents($url);
	echo $res;
}else if(isset($info['cmd']) && $info['cmd']=="host"){
    $url.=urlencode($info['cmd']." ".$info['ip']);
       // echo $url;
	//$url = urlencode($url);
     
	$res =(string) file_get_contents($url);
	$rows   = preg_split('/\s+/', $res);
	$data = array();
	$i=0;
	foreach($rows as $key=>$val){
		$j=0;
	
		$data[$i][$j++] =($i+1);
		$data[$i][$j++] =$val;
		
	
		$i++;
	
	}

	echo json_encode($data);

}else if(isset($info['cmd']) && $info['cmd']=="active-user"){
    $url.=$info['cmd'];
	//$url = urlencode($url);
	$res = file_get_contents($url);
	echo $res;
}else if(isset($info['cmd']) && $info['cmd']=="active-session"){
    $url.=urlencode($info['cmd']." ".$info['ip']);
	//$url = urlencode($url);
	$res = file_get_contents($url);
	echo $res;
}else if(isset($info['cmd']) && $info['cmd']=="all"){
    $url.=$info['cmd'];
	//$url = urlencode($url);
	$res = file_get_contents($url);
       
       $rows = explode("\n\r  ",$res);
	$data = array();
	$i=0;
	foreach($rows as $key=>$val){
		$j=0;
	
		$datas = explode("|",$val);
		$data[$i][$j++] = $datas[0];
		$data[$i][$j++] = $datas[1];
		$data[$i][$j++] = $datas[2];
	
		$i++;
	
	}

	echo json_encode($data);
	//echo $res;
}else{
      echo "Invalid Command| Usage:cmd->status|mac|host|active_user|active_session|all\n";
	  exit(0);
}

?>