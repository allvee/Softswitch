<?php


include_once "../lib/common.php";

//
//$cn = connectDB();
//$is_error = 1;
//
//
//$remoteCnQry = "select * from tbl_process_db_access where pname='SMSGW'";
//$res = Sql_exec($cn, $remoteCnQry);
//$dt = Sql_fetch_array($res);
//
//$dbtype = $dt['db_type'];
//$Server = $dt['db_server'];
//$UserID = $dt['db_uid'];
//$Password = $dt['db_password'];
//$Database = $dt['db_name'];
//ClosedDBConnection($cn);
//
//$remoteCn = connectDB();
//

$remoteCn=remote_connectDB('SMSGW');
//$cn = connectDB();
$action = "";
$shortcode = "";
$keyword = "";
$SMSText = "";
$SrcType = "";
$URL = "";
$Status = "";
//$destination_context = "";
//$is_error = 1;
$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info=isset($_REQUEST['info'])?$_REQUEST['info']:'action';
if($data_info!='action'){
    $action=$data_info['action']  ;
    $deleted_id=$data_info['deleted_id'];
}
if (isset($_REQUEST['info']) || isset($_REQUEST['action'])) {

    if (isset($_REQUEST['info'])) {
        $data = $_REQUEST['info'];
        $action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
        if (isset($data['keyword'])) {
            $shortcode = mysql_real_escape_string(htmlspecialchars($data['shortcode']));
            $keyword = mysql_real_escape_string(htmlspecialchars($data['keyword']));
            $SMSText = mysql_real_escape_string(htmlspecialchars($data['SMSText']));
            $SrcType = mysql_real_escape_string(htmlspecialchars($data['SrcType']));
            $URL = mysql_real_escape_string(htmlspecialchars($data['URL']));
            $Status = mysql_real_escape_string(htmlspecialchars($data['Status']));
        }
    } else {

        $shortcode = mysql_real_escape_string(htmlspecialchars($_REQUEST['shortcode']));
        $keyword = mysql_real_escape_string(htmlspecialchars($_REQUEST['keyword']));
        $SMSText = mysql_real_escape_string(htmlspecialchars($_REQUEST['SMSText']));
        $SrcType = mysql_real_escape_string(htmlspecialchars($_REQUEST['SrcType']));
        $URL = mysql_real_escape_string(htmlspecialchars($_REQUEST['URL']));
        $Status = mysql_real_escape_string(htmlspecialchars($_REQUEST['Status']));
        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    }

    if ($action == "update") {
        $msg = "Successfully Updated";

        $qry = "update keyword set ShortCode='$shortcode',keyword='$keyword', SMSText='$SMSText',SrcType='$SrcType', URL='$URL', Status='$Status'";
        $qry .= " where id='$action_id'";
    } elseif ($action == "delete") {
        $action_id=$deleted_id;
        $msg = "Successfully Deleted";
        $qry = "update keyword set  Status='inactive'";
        $qry .= " where id='$action_id'";
    } else  {
        $msg = "Successfully Saved";
        $qry = "insert into keyword (ShortCode,keyword,SMSText,SrcType,URL,Status)
			 values ('$shortcode','$keyword','$SMSText','$SrcType','$URL','$Status')";
    }


    try {

        $res = Sql_exec($remoteCn, $qry);
		if($action!="delete"){
			if($action == "update"){
			
				$action_name = $action;
				$idName = 'id';
				$id_val = $action_id;
			}else{
				$action_name = 'add';
				$idName = 'Keyword';
				$id_val = $keyword;
					
			}
		}
		
		ClosedDBConnection($remoteCn);
		rollback_main_connectDB();
        $is_error = 0;
		$options['page_name'] = "SMS Gateway Keyword";
		$options['action_type'] = $action_name;
		$options['table'] = "keyword";
		$options['id_name'] = $idName;
		$options['id_value'] = $id_val;
		$options['remote'] = true;
		$options['pname'] = 'SMSGW';
		
		
		setHistory($options);
		
    } catch (Exception $e) {
        
    }
}

if ($is_error) {
    $return_data = array('status' => false, 'message' => 'Submission Failed');
} else {
    $return_data = array('status' => true, 'message' => $msg);
}

echo json_encode($return_data);

ClosedDBConnection($remoteCn);
?>