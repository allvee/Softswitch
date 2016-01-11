<?php

include_once "../lib/common.php";

$cn = connectDB();

	$is_error=0;
	$time_offset_raw = mysql_real_escape_string(htmlspecialchars($_REQUEST['timezoon']));
	$resetdate = mysql_real_escape_string(htmlspecialchars($_REQUEST['resetdate']));
	//$hh = mysql_real_escape_string(htmlspecialchars($_REQUEST['hh']));
	//$mm = mysql_real_escape_string(htmlspecialchars($_REQUEST['mm']));
	//$ss = mysql_real_escape_string(htmlspecialchars($_REQUEST['ss']));
	$gmt=explode("(",$time_offset_raw);
	$time_offset_hSplit=explode(":",$gmt[1]);
	$time_offset=$time_offset_hSplit[0];
	
	$re_arr= explode("-",$resetdate);
	$yr = $re_arr[0];
	$mn = intval($re_arr[1]);
	$day_raw = $re_arr[2];
	$day_split=explode(" ",$day_raw);
	$day=$day_split[0];
	$time_split=explode(":",$day_split[1]);
	$hh=$time_split[0];
	$mm=$time_split[1];
	$ss="00";
	if($mn == 1){
		$mn = "JAN";
	} else if($mn == 2){
		$mn = "FEB";
	} else if($mn == 3){
		$mn = "MAR";
	} else if($mn == 4){
		$mn = "APR";
	} else if($mn == 5){
		$mn = "MAY";
	} else if($mn == 6){
		$mn = "JUN";
	} else if($mn == 7){
		$mn = "JUL";
	} else if($mn == 8){
		$mn = "AUG";
	} else if($mn == 9){
		$mn = "SEP";
	} else if($mn == 10){
		$mn = "OCT";
	} else if($mn == 11){
		$mn = "NOV";
	} else if($mn == 12){
		$mn = "DEC";
	}
	
	$command1 = "sudo rm -rf /etc/localtime";
	$command2 = "sudo ln -s /usr/share/zoneinfo/Etc/".$time_offset." /etc/localtime";
	$cmmnt = 'sudo date -s "'.$day.' '.$mn.' '.$yr.' '.$hh.':'.$mm.':'.$ss.'"';
	
	try {
		system($command1);
	} catch ( Exception $e){
		$is_error=1;
	}
	
	try {
		system($command2);
	} catch ( Exception $oe){
		$is_error=2;
	}
	
	try {
		system($cmmnt);
	} catch ( Exception $e1){
		$is_error=3;
	}
	
	ClosedDBConnection($cn);

//echo "Anik";
?>