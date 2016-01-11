<?php
require_once "../lib/common.php";

global $tcp_dump_path;

$files = array();
if ($handle = opendir($tcp_dump_path)) {
            $total_count = 0;
            while (($entry = readdir($handle)) !== false) {
                $file_name_without_extension = ""; 
				$split_by_dot = explode(".",$entry);
				$last_index = count($split_by_dot)-1;
				if( $split_by_dot[$last_index] != "" && $split_by_dot[$last_index] == 'pcap'){
					for($i=0;$i<$last_index;$i++){
						if($file_name_without_extension !=""){
						     $file_name_without_extension.='.'.$split_by_dot[$i];
					    }
						else {  
							  $file_name_without_extension=$split_by_dot[$i];
						}
					}
				}
				if($file_name_without_extension != "" && !empty($file_name_without_extension)){
					
					array_push($files,$file_name_without_extension);
				}
				
            }
}

$html = '';
foreach($files as $val){
    
    $time_stamps = explode("_",$val);
	$without_timestamp = "";
	$len = count($time_stamps);
	if($len == 1){
	   $without_timestamp = $time_stamps[0];
	}else{
		for($i=0;$i<($len-1);$i++){
		    if( $without_timestamp == "") $without_timestamp = $time_stamps[$i];
			else $without_timestamp .= "_".$time_stamps[$i];
		}
	}	
	$html.='<option value="'.$val.'" >'.$without_timestamp.'</option>';
}
echo $html;



?>