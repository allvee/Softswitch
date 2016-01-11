<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/5/2015
 * Time: 7:49 PM
 */

include_once "../lib/common.php";
$remoteCn = remote_connectDB('SMSGW');
$is_error = 1;
$action = "";
$shortcode = "";
$keyword = "";
$ServiceID = "";
$SrcType = "";
$URL = "";
$Status = "";

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['deleted_id'];
}

$shortcode = mysql_real_escape_string(htmlspecialchars($_REQUEST['shortcode']));
$keyword = mysql_real_escape_string(htmlspecialchars($_REQUEST['Keyword']));
$ServiceID = mysql_real_escape_string(htmlspecialchars($_REQUEST['ServiceID']));
$SubServiceID = mysql_real_escape_string(htmlspecialchars($_REQUEST['SubServiceID']));
$SourceType = mysql_real_escape_string(htmlspecialchars($_REQUEST['SourceType']));
$URL = mysql_real_escape_string(htmlspecialchars($_REQUEST['URL']));
$Status = mysql_real_escape_string(htmlspecialchars($_REQUEST['Status']));
$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));

$remoteCnQry = "select * from `shortcode` where `shortcode`='$shortcode'";
$res = Sql_exec($remoteCn, $remoteCnQry);
$data = Sql_fetch_array($res);
$qry='';
if ($data['shortcode'] == $shortcode) {
    if ($action == "update") {
        $msg = "Successfully Updated";
        $qry = "update `service` set `ShortCode`='$shortcode',`keyword`='$keyword', `ServiceID`='$ServiceID',`SubServiceID`='$SubServiceID',`SourceType`='$SourceType', `URL`='$URL', `Status`='$Status'";
        $qry .= " where `id`='$action_id'";
    } elseif ($action == "delete") {
        $action_id = $deleted_id;
        $msg = "Successfully Deleted";
        $qry = "delete from `service` where `id`='" . $action_id . "'";
    } else {
        $remoteCnQry = "select * from `service` where `Keyword`='$keyword' and `ServiceID`='$ServiceID' and `SubServiceID`='$SubServiceID'";
        $res = Sql_exec($remoteCn, $remoteCnQry);
        $data = Sql_fetch_array($res);
        if($data['Keyword']==$keyword){
            $msg = "Failed to Saved. Please put correct information.";
        }else{
        $msg = "Successfully Saved";
        $qry = "insert into `service`( `ShortCode`,`Keyword`, `ServiceID`,  `SubServiceID`,  `SourceType`,`URL`,  `Status` ) values ('$shortcode','$keyword','$ServiceID','$SubServiceID','$SourceType','$URL','$Status')";
    }
    }

    try {
        if($qry!=''){
        $res = Sql_exec($remoteCn, $qry);
        $is_error = 0;
		if($action!="delete"){
			if($action == "update"){
			
				$action_name = $action;
				$id_val = $action_id;
			}else{
				$action_name = 'add';
				$id_val = Sql_insert_id($remoteCn);
					
			}
		}
		
		ClosedDBConnection($remoteCn);
		rollback_main_connectDB();
		$options['page_name'] = "SMS Gateway Services";
		$options['action_type'] = $action_name;
		$options['table'] = "service";
		$options['id_value'] = $id_val;
		$options['remote'] = true;
		$options['pname'] = 'SMSGW';
		
		setHistory($options);
		
        }
        
    } catch (Exception $e) {

    }

    if ($is_error) {
        $return_data = array('status' => false, 'message' => 'Submission Failed');
    } else {
        $return_data = array('status' => true, 'message' => $msg);
    }
} else {
    $return_data = array('status' => false, 'message' => 'Insert Unsuccessful. Shortcode does not exists');
}
echo json_encode($return_data);

ClosedDBConnection($remoteCn);
?>