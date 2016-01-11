<?php

session_start();
include_once "../lib/common.php";

                $data = $_POST['info'];
                
 $cn = connectDB();               
				



				$sender_type = mysql_real_escape_string(htmlspecialchars($data['sender_type']));
				$log_type = mysql_real_escape_string(htmlspecialchars($data['log_type']));
				$submit_time = mysql_real_escape_string(htmlspecialchars($data['submit_time']));
				$submit_time_to = mysql_real_escape_string(htmlspecialchars($data['submit_time_to']));
				$log_time = mysql_real_escape_string(htmlspecialchars($data['log_time']));
				$log_to_time = mysql_real_escape_string(htmlspecialchars($data['log_to_time']));
				$fromId = mysql_real_escape_string(htmlspecialchars($data['fromId']));
				$toId = mysql_real_escape_string(htmlspecialchars($data['toId']));
				$callId = mysql_real_escape_string(htmlspecialchars($data['callId']));
				$user_type = mysql_real_escape_string(htmlspecialchars($data['user_type']));
				$source_ip = mysql_real_escape_string(htmlspecialchars($data['source_ip']));
				$source_port = mysql_real_escape_string(htmlspecialchars($data['source_port']));
				$functionName = mysql_real_escape_string(htmlspecialchars($data['functionName']));
				
				$audio_ip = mysql_real_escape_string(htmlspecialchars($data['audio_ip']));
				$audio_port = mysql_real_escape_string(htmlspecialchars($data['audio_port']));
				$video_ip = mysql_real_escape_string(htmlspecialchars($data['video_ip']));
				$video_port = mysql_real_escape_string(htmlspecialchars($data['video_port']));
				$function_point = mysql_real_escape_string(htmlspecialchars($data['function_point']));
				$comment = mysql_real_escape_string(htmlspecialchars($data['comment']));
				$sip = mysql_real_escape_string(htmlspecialchars($data['sip']));



$user_id = $_SESSION['USER_ID'];

if($edit_tbl == "log_mgt"){
	$content_arr	= array("ID","Source","Type","Source Timestamp","Log Server Time","From User",
						"To User","Call Id","User Type","Source IP","Source Port","Function Name",
						"Audio IP", "Audio Port", "Video IP", "Video Port", "Function Point", "Comment", "SIP" );
	$count_qry 		= "select count(id) from `tbl_log_mgt` where is_active='active' ";
	//$load_qry 		= "SELECT `id`,`source`,`type`,FROM_UNIXTIME(`source_timestamp`),`log_server_time`,`from_user`, " .
					//	"`to_user`,`call_id`,`caller_callee`,`source_ip`,`source_port`,`function_name`, " .
						//"`audio_ip`, `audio_port`, `video_ip`, `video_port`, `function_point`, `comment`, `sip` " .
						//"FROM `tbl_log_mgt` where is_active='active' ";
	if($sender_type != null && $sender_type != '' && $sender_type != 'null')
	{
		$count_qry	.= " AND `source` LIKE '%".$sender_type."%' ";
		//$load_qry 	.= " AND `source` LIKE '%".$sender_type."%' ";	
	}
	if($log_type != null && $log_type != '' && $log_type != 'null')
	{
		$count_qry	.= " AND `type` LIKE '%".$log_type."%' ";
		//$load_qry 	.= " AND `type` LIKE '%".$log_type."%' ";	
	}
	if(($submit_time != null && $submit_time != '' && $submit_time != 'null') && ($submit_time_to != null && $submit_time_to != '' && $submit_time_to != 'null') )
	{
		//$count_qry	.= " AND `source_timestamp` LIKE '%".$submit_time."%' ";
		//$load_qry 	.= " AND `source_timestamp` LIKE '%".$submit_time."%' ";
		$count_qry	.= " AND `source_timestamp` BETWEEN UNIX_TIMESTAMP(STR_TO_DATE('".$submit_time.":00', '%Y/%m/%d %H:%i:%s')) AND UNIX_TIMESTAMP(STR_TO_DATE('".$submit_time_to.":59.999', '%Y/%m/%d %H:%i:%s'))";
		//$load_qry 	.= " AND `source_timestamp` BETWEEN UNIX_TIMESTAMP(STR_TO_DATE('".$submit_time.":00', '%Y/%m/%d %H:%i:%s')) AND UNIX_TIMESTAMP(STR_TO_DATE('".$submit_time_to.":59.999', '%Y/%m/%d %H:%i:%s'))";	
		
	}
	if(($log_time != null && $log_time != '' && $log_time != 'null') && ($log_to_time != null && $log_to_time != '' && $log_to_time != 'null') )
	{
		$count_qry	.= " AND `log_server_time` BETWEEN STR_TO_DATE('".$log_time.":00', '%Y/%m/%d %H:%i:%s') AND STR_TO_DATE('".$log_to_time.":59.999', '%Y/%m/%d %H:%i:%s')";
		//$load_qry 	.= " AND `log_server_time` BETWEEN STR_TO_DATE('".$log_time.":00', '%Y/%m/%d %H:%i:%s') AND STR_TO_DATE('".$log_to_time.":59.999', '%Y/%m/%d %H:%i:%s')";	
	}
	if($fromId != null && $fromId != '' && $fromId != 'null')
	{
		$count_qry	.= " AND `from_user` LIKE '%".$fromId."%' ";
		//$load_qry 	.= " AND `from_user` LIKE '%".$fromId."%' ";	
	}
	if($toId != null && $toId != '' && $toId != 'null')
	{
		$count_qry	.= " AND `to_user` LIKE '%".$toId."%' ";
		//$load_qry 	.= " AND `to_user` LIKE '%".$toId."%' ";	
	}
	if($callId != null && $callId != '' && $callId != 'null')
	{
		$count_qry	.= " AND `call_id` LIKE '%".$callId."%' ";
		$load_qry 	.= " AND `call_id` LIKE '%".$callId."%' ";	
	}
	if($user_type != null && $user_type != '' && $user_type != 'null')
	{
		$count_qry	.= " AND `caller_callee` LIKE '%".$user_type."%' ";
		//$load_qry 	.= " AND `caller_callee` LIKE '%".$user_type."%' ";	
	}
	if($source_ip != null && $source_ip != '' && $source_ip != 'null')
	{
		$count_qry	.= " AND `source_ip` LIKE '%".$source_ip."%' ";
		//$load_qry 	.= " AND `source_ip` LIKE '%".$source_ip."%' ";	
	}
	if($source_port != null && $source_port != '' && $source_port != 'null')
	{
		$count_qry	.= " AND `source_port` LIKE '%".$source_port."%' ";
		//$load_qry 	.= " AND `source_port` LIKE '%".$source_port."%' ";	
	}
	if($functionName != null && $functionName != '' && $functionName != 'null')
	{
		$count_qry	.= " AND `function_name` LIKE '%".$functionName."%' ";
		//$load_qry 	.= " AND `function_name` LIKE '%".$functionName."%' ";	
	}
	
	
	if($audio_ip != null && $audio_ip != '' && $audio_ip != 'null')
	{
		$count_qry	.= " AND `audio_ip` LIKE '%".$audio_ip."%' ";
		//$load_qry 	.= " AND `audio_ip` LIKE '%".$audio_ip."%' ";	
	}
	if($audio_port != null && $audio_port != '' && $audio_port != 'null')
	{
		$count_qry	.= " AND `audio_port` LIKE '%".$audio_port."%' ";
		//$load_qry 	.= " AND `audio_port` LIKE '%".$audio_port."%' ";	
	}
	if($video_ip != null && $video_ip != '' && $video_ip != 'null')
	{
		$count_qry	.= " AND `video_ip` LIKE '%".$video_ip."%' ";
		//$load_qry 	.= " AND `video_ip` LIKE '%".$video_ip."%' ";	
	}
	if($video_port != null && $video_port != '' && $video_port != 'null')
	{
		$count_qry	.= " AND `video_port` LIKE '%".$video_port."%' ";
		//$load_qry 	.= " AND `video_port` LIKE '%".$video_port."%' ";	
	}
	if($function_point != null && $function_point != '' && $function_point != 'null')
	{
		$count_qry	.= " AND `function_point` LIKE '%".$function_point."%' ";
		//$load_qry 	.= " AND `function_point` LIKE '%".$function_point."%' ";	
	}
	if($comment != null && $comment != '' && $comment != 'null')
	{
		$count_qry	.= " AND `comment` LIKE '%".$comment."%' ";
		//$load_qry 	.= " AND `comment` LIKE '%".$comment."%' ";	
	}
	if($sip != null && $sip != '' && $sip != 'null')
	{
		$count_qry	.= " AND `sip` LIKE '%".$sip."%' ";
		//$load_qry 	.= " AND `sip` LIKE '%".$sip."%' ";	
	}
	$key = 'id';
	$extraBtn = false;
} 

 $res = Sql_exec($cn,$count_qry);

	while ($row = Sql_fetch_array($res)) {
    $j=0;

	
					 $data_[$i][$j++] = Sql_Result($row, "sender_type");
					 $data_[$i][$j++] = Sql_Result($row, "log_type");
					 $data_[$i][$j++] = Sql_Result($row, "submit_time");
					 $data_[$i][$j++] = Sql_Result($row, "submit_time_to");
					 $data_[$i][$j++] = Sql_Result($row, "log_time");
					 $data_[$i][$j++] = Sql_Result($row, "log_to_time");
					 $data_[$i][$j++] = Sql_Result($row, "fromId");
					 $data_[$i][$j++] = Sql_Result($row, "toId");
					 $data_[$i][$j++] = Sql_Result($row, "user_type");
					 $data_[$i][$j++] = Sql_Result($row, "source_ip");
					 $data_[$i][$j++] = Sql_Result($row, "source_port");
					 $data_[$i][$j++] = Sql_Result($row, "functionName");
					 $data_[$i][$j++] = Sql_Result($row, "audio_ip");
					 $data_[$i][$j++] = Sql_Result($row, "audio_port");
					 $data_[$i][$j++] = Sql_Result($row, "video_ip");
					 $data_[$i][$j++] = Sql_Result($row, "function_point");
					 $data_[$i][$j++] = Sql_Result($row, "comment");
					 $data_[$i][$j++] = Sql_Result($row, "sip");
					 
	
	$i++;
}
		

Sql_Free_Result($res);
echo json_encode($data_);
                
ClosedDBConnection($cn);             
		
?>