<?php

session_start();
include_once "../lib/common.php";

$data = $_POST['info'];

$cn = connectDB();



$log_server_time_from = mysql_real_escape_string(htmlspecialchars($data['log_server_time_from']));
$log_server_time_to = mysql_real_escape_string(htmlspecialchars($data['log_server_time_to']));
$source = mysql_real_escape_string(htmlspecialchars($data['source']));
$type = mysql_real_escape_string(htmlspecialchars($data['type']));
$source_timestamp_from = mysql_real_escape_string(htmlspecialchars($data['source_timestamp_from']));
$source_timestamp_to = mysql_real_escape_string(htmlspecialchars($data['source_timestamp_to']));
$from_user = mysql_real_escape_string(htmlspecialchars($data['from_user']));
$to_user = mysql_real_escape_string(htmlspecialchars($data['to_user']));
$call_id = mysql_real_escape_string(htmlspecialchars($data['call_id']));
$caller_callee = mysql_real_escape_string(htmlspecialchars($data['caller_callee']));
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


$remoteCnQry = "select * from tbl_process_db_access where pname='SOFTSWITCH'";
$res = Sql_exec($cn, $remoteCnQry);
$dt = Sql_fetch_array($res);
//remote connection parameter set up
$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];
ClosedDBConnection($cn);// close current connection

$remoteCn = connectDB();


//$content_arr	= array("ID","Source","Type","Source Timestamp","Log Server Time","From User","To User","Call Id","User Type","Source IP","Source Port","Function Name","Audio IP", "Audio Port", "Video IP","Video Port", "Function Point", "Comment", "SIP" );
//$count_qry 		= "select count(id) from `tbl_log_mgt` where is_active='active' ";

/*$load_qry = "SELECT source,`type`,FROM_UNIXTIME(`source_timestamp`) AS 'source_timestamp',`log_server_time`,`from_user`,";
$load_qry .= "to_user,`call_id`,`caller_callee`,`source_ip`,`source_port`,`function_name`,";

$load_qry .= "`audio_ip`, `audio_port`,video_ip,video_port,function_point,";

$load_qry .= "`comment`, `sip` FROM `tbl_log_mgt` where `is_active`='active'";*/

$load_qry 		= "SELECT `id`,`source`,`type`,FROM_UNIXTIME(`source_timestamp`),`log_server_time`,`from_user`, " .
    "`to_user`,`call_id`,`caller_callee`,`source_ip`,`source_port`,`function_name`, " .
    "`audio_ip`, `audio_port`, `video_ip`, `video_port`, `function_point`, `comment`, `sip` " .
    "FROM `tbl_log_mgt` where is_active='active' ";


/*$load_qry = "SELECT `log_server_time`,`source`,`type`,`source_timestamp`,`from_user`,`to_user`,`call_id`,`caller_callee`,`source_ip`,`source_port`,`function_name`,`audio_ip`,`audio_port`,`video_ip`,`video_port`,`function_point`,`comment`,`sip` FROM `tbl_log_mgt` WHERE `is_active` = 'active';";
*/
if(($log_server_time_from != null && $log_server_time_from != '' && $log_server_time_from != 'null') && ($log_server_time_to != null && $log_server_time_to != '' && $log_server_time_to != 'null') )
{
    $count_qry	.= " AND `log_server_time` BETWEEN STR_TO_DATE('".$log_server_time_from.":00', '%Y/%m/%d %H:%i:%s') AND STR_TO_DATE('".$log_server_time_to.":59.999', '%Y/%m/%d %H:%i:%s')";
    $load_qry 	.= " AND `log_server_time` BETWEEN STR_TO_DATE('".$log_server_time_from.":00', '%Y/%m/%d %H:%i:%s') AND STR_TO_DATE('".$log_server_time_to.":59.999', '%Y/%m/%d %H:%i:%s')";
}
if ($source != null && $source != '' && $source != 'null') {

    $load_qry .= " AND `source` LIKE '%" . $source . "%' ";
}

if ($type != null && $type != '' && $type != 'null') {
    //$count_qry	.= " AND `type` LIKE '%".$source."%' ";
    $load_qry .= " AND `type` LIKE '%" . $type . "%' ";
}

if(($source_timestamp_from != null && $source_timestamp_from != '' && $source_timestamp_from != 'null') && ($source_timestamp_to != null && $source_timestamp_to != '' && $source_timestamp_to != 'null') )
{
    //$count_qry	.= " AND `source_timestamp` LIKE '%".$submit_time."%' ";
    //$load_qry 	.= " AND `source_timestamp` LIKE '%".$submit_time."%' ";
    $count_qry	.= " AND `source_timestamp` BETWEEN UNIX_TIMESTAMP(STR_TO_DATE('".$source_timestamp_from.":00', '%Y/%m/%d %H:%i:%s')) AND UNIX_TIMESTAMP(STR_TO_DATE('".$source_timestamp_to.":59.999', '%Y/%m/%d %H:%i:%s'))";
    $load_qry 	.= " AND `source_timestamp` BETWEEN UNIX_TIMESTAMP(STR_TO_DATE('".$source_timestamp_from.":00', '%Y/%m/%d %H:%i:%s')) AND UNIX_TIMESTAMP(STR_TO_DATE('".$source_timestamp_to.":59.999', '%Y/%m/%d %H:%i:%s'))";

}
if (($from_user != null && $from_user != '' && $from_user != 'null') && ($to_user != null && $to_user != '' && $to_user != 'null')) {
    //$count_qry	.= " AND `log_server_time` BETWEEN STR_TO_DATE('".$from_user.":00', '%Y/%m/%d %H:%i:%s') AND STR_TO_DATE('".$to_user.":59.999', '%Y/%m/%d %H:%i:%s')";
    $load_qry .= " AND `log_server_time` BETWEEN STR_TO_DATE('" . $from_user . ":00', '%Y/%m/%d %H:%i:%s') AND STR_TO_DATE('" . $to_user . ":59.999', '%Y/%m/%d %H:%i:%s')";
}
if ($call_id != null && $call_id != '' && $call_id != 'null') {
    //$count_qry	.= " AND `from_user` LIKE '%".$call_id."%' ";
    $load_qry .= " AND `from_user` LIKE '%" . $call_id . "%' ";
}
if ($caller_callee != null && $caller_callee != '' && $caller_callee != 'null') {
    //$count_qry	.= " AND `to_user` LIKE '%".$caller_callee."%' ";
    $load_qry .= " AND `to_user` LIKE '%" . $caller_callee . "%' ";
}
if ($source_ip != null && $source_ip != '' && $source_ip != 'null') {
    //$count_qry	.= " AND `call_id` LIKE '%".$source_ip."%' ";
    $load_qry .= " AND `call_id` LIKE '%" . $source_ip . "%' ";
}
if ($source_port != null && $source_port != '' && $source_port != 'null') {
    //$count_qry	.= " AND `source_port` LIKE '%".$source_port."%' ";
    $load_qry .= " AND `source_port` LIKE '%" . $source_port . "%' ";
}
if ($functionName != null && $functionName != '' && $functionName != 'null') {
    //$count_qry	.= " AND `function_name` LIKE '%".$functionName."%' ";
    $load_qry .= " AND `function_name` LIKE '%" . $functionName . "%' ";
}

if ($audio_ip != null && $audio_ip != '' && $audio_ip != 'null') {
    //$count_qry	.= " AND `audio_ip` LIKE '%".$audio_ip."%' ";
    $load_qry .= " AND `audio_ip` LIKE '%" . $audio_ip . "%' ";
}
if ($audio_port != null && $audio_port != '' && $audio_port != 'null') {
    //$count_qry	.= " AND `audio_port` LIKE '%".$audio_port."%' ";
    $load_qry .= " AND `audio_port` LIKE '%" . $audio_port . "%' ";
}
if ($video_ip != null && $video_ip != '' && $video_ip != 'null') {
    //$count_qry	.= " AND `video_ip` LIKE '%".$video_ip."%' ";
    $load_qry .= " AND `video_ip` LIKE '%" . $video_ip . "%' ";
}
if ($video_port != null && $video_port != '' && $video_port != 'null') {
    //$count_qry	.= " AND `video_port` LIKE '%".$video_port."%' ";
    $load_qry .= " AND `video_port` LIKE '%" . $video_port . "%' ";
}
if ($function_point != null && $function_point != '' && $function_point != 'null') {
    //$count_qry	.= " AND `function_point` LIKE '%".$function_point."%' ";
    $load_qry .= " AND `function_point` LIKE '%" . $function_point . "%' ";
}
if ($comment != null && $comment != '' && $comment != 'null') {
    //$count_qry	.= " AND `comment` LIKE '%".$comment."%' ";
    $load_qry .= " AND `comment` LIKE '%" . $comment . "%' ";
}
if ($sip != null && $sip != '' && $sip != 'null') {
    //$count_qry	.= " AND `sip` LIKE '%".$sip."%' ";
    $load_qry .= " AND `sip` LIKE '%" . $sip . "%' ";
}
$key = 'id';
$extraBtn = false;

//echo $count_qry;$load_qry;

$res = Sql_exec($remoteCn, $load_qry);
$i = 0;
$data=array();
while ($row = Sql_fetch_array($res)) {
    $j = 0;
    $data[$i]=array();
    $data[$i][$j++] = Sql_Result($row, "log_server_time");
    $data[$i][$j++] = Sql_Result($row, "source");
    $data[$i][$j++] = Sql_Result($row, "type");
    $data[$i][$j++] = Sql_Result($row, "source_timestamp");
    $data[$i][$j++] = Sql_Result($row, "from_user");
    $data[$i][$j++] = Sql_Result($row, "to_user");
    $data[$i][$j++] = Sql_Result($row, "call_id");
    $data[$i][$j++] = Sql_Result($row, "caller_callee");
    $data[$i][$j++] = Sql_Result($row, "source_ip");
    $data[$i][$j++] = Sql_Result($row, "source_port");
    $data[$i][$j++] = Sql_Result($row, "function_name");
    $data[$i][$j++] = Sql_Result($row, "audio_ip");
    $data[$i][$j++] = Sql_Result($row, "audio_port");
    $data[$i][$j++] = Sql_Result($row, "video_ip");
    $data[$i][$j++] = Sql_Result($row, "video_port");
    $data[$i][$j++] = Sql_Result($row, "function_point");
    $data[$i][$j++] = Sql_Result($row, "comment");
    $data[$i][$j++] = Sql_Result($row, "sip");


    $i++;
}


Sql_Free_Result($res);
echo json_encode($data);

ClosedDBConnection($remoteCn);

?>