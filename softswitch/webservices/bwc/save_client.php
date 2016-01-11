<?php
header('Access-Control-Allow-Origin: *');
//session_start();
require_once "../lib/common.php";
require_once "../lib/filewriter.php";
//$dir = "../../etc/sysconfig/network-scripts/";

//$info = $_POST["info"];
echo $_REQUEST['action'];
$cn = connectDB();

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["USER_ID"];

if (isset($_REQUEST['info'])) {
    $data = $_REQUEST['info'];
    $action = $data['action'];
    $action_id = $data['action_id'];
}else
   {
    $action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $group_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Group']));
    $clientName = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_ClientName']));
    $packageId = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_TimePackage']));
    $sourceIP = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_SourceIp']));
    $destIP = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_DestinationIp']));
    $destIpValue = mysql_real_escape_string(htmlspecialchars($_REQUEST['destination_ip_value']));
    $destPort = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_DestinationPort']));
    $download = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Download']));
    $upload = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Upload']));
    $minDownload= mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_MinDownload']));
    $minUpload = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_MinUpload']));
    $brust = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Brust']));
    $mark = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Mark']));
    $mac = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Mac']));
    $priority = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Priority']));
}

if ($action == "update") {
    $qry = "update  bwc_clientinfo set clientName='$clientName',groupName='$group_name',packageId='$packageId',upLoad='$upload',downLoad='$download',brust='$brust',max_upLoad='$minUpload',max_downLoad='$minDownload',priority='$priority' where clientId='$action_id'";
     try {
        $res = Sql_exec($cn, $qry);
    } catch (Exception $e) {
        $is_error = 1;
    }
    $qry_rules = "delete from bwc_ruleinfo where clientId='$action_id'";
    try {
        $res = Sql_exec($cn, $qry_rules);
    } catch (Exception $e) {
        $is_error = 1;
    }

    $destIpValue_array = explode("|",$destIpValue);
    $destIP_arry=explode("|",$destIP);
    $destPort_arry=explode("|",$destPort);
    $length = sizeof($destIpValue_array);
    $client_id=mysql_insert_id();

    $qry1="insert into bwc_ruleinfo (clientId,src,dst,port,mark,mac,percentage) VALUES ";
    $values = array();
    for($i=0; $i < count($destIP_arry); $i++)
    {
        $values[$i] ="('$action_id','$sourceIP','$destIP_arry[$i]','$destPort_arry[$i]','$mark','$mac','$destIpValue_array[$i]')";
    }

    $qry1 .=  implode(", ", $values);

    try {
        $res = Sql_exec($cn, $qry1);
    } catch (Exception $e) {
        $is_error = 1;
    }

} else if ($action == "delete") {
    $qry = "update bwc_clientinfo set  is_active='inactive' where clientId='$action_id'";
    try {
        $res = Sql_exec($cn, $qry);
    } catch (Exception $e) {
        $is_error = 1;
    }
    $qry1 = "update bwc_ruleinfo set  is_active='inactive' where clientId='$action_id'";
    try {
        $res = Sql_exec($cn, $qry1);
    } catch (Exception $e) {
        $is_error = 1;
    }
} else {
   $qry="insert into bwc_clientinfo (clientName,groupName,packageId,upLoad,downLoad,brust,max_upLoad,max_downLoad,priority) values('$clientName','$group_name','$packageId','$upload','$download','$brust','$minUpload','$minDownload','$priority')";
    try {
        $res = Sql_exec($cn, $qry);
    } catch (Exception $e) {
        $is_error = 1;
    }

    $destIpValue_array = explode("|",$destIpValue);
    $destIP_arry=explode("|",$destIP);
    $destPort_arry=explode("|",$destPort);
    $length = sizeof($destIpValue_array);
    $client_id=mysql_insert_id();


    $qry="insert into bwc_ruleinfo (clientId,src,dst,port,mark,mac,percentage) VALUES ";

    $values = array();

    for($i=0; $i < count($destIP_arry); $i++)
    {
        $values[$i] ="('$client_id','$sourceIP','$destIP_arry[$i]','$destPort_arry[$i]','$mark','$mac','$destIpValue_array[$i]')";
    }
    //echo
    $qry .=  implode(", ", $values);
    try {
        $res = Sql_exec($cn, $qry);
    } catch (Exception $e) {
        $is_error = 1;
    }

}



if ($is_error == 0) {
    //$is_error = file_writer_vrrp($cn);
}

ClosedDBConnection($cn);

echo $is_error;

?>