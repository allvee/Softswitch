<?php
/**
 *
 * Edited by Talemul Islam on 5/23/2015
 */
$data = $_REQUEST;
include_once "../lib/common.php";
$cn = connectDB();
$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['action_id'];
}

$tbl = "tbl_ippbx_extensions";
$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if ($action != "delete") {
    $e_name = mysql_real_escape_string(htmlspecialchars($data['basic_name']));
    $e_number = mysql_real_escape_string(htmlspecialchars($data['basic_user_id']));
    $e_secret = mysql_real_escape_string(htmlspecialchars($data['basic_secret']));
	$e_password = mysql_real_escape_string(htmlspecialchars($data['basic_pass']));
	$e_userType = mysql_real_escape_string(htmlspecialchars($data['basic_user_type']));

	$e_hwNo = mysql_real_escape_string(htmlspecialchars($data['advance_hw']));
	$e_allowedIp = mysql_real_escape_string(htmlspecialchars($data['advance_ip']));
	$e_allowedPort = mysql_real_escape_string(htmlspecialchars($data['advance_port']));
	$e_fwdib = mysql_real_escape_string(htmlspecialchars($data['advance_busy']));
	$e_fwdiu = mysql_real_escape_string(htmlspecialchars($data['advance_unreachable']));
	$e_fwdina = mysql_real_escape_string(htmlspecialchars($data['advance_no_ans']));
	$e_rbtno = mysql_real_escape_string(htmlspecialchars($data['advance_rbt_no']));
	$e_mcaNo = mysql_real_escape_string(htmlspecialchars($data['advance_mca_no']));
	$e_status = mysql_real_escape_string(htmlspecialchars($data['advance_status']));
	$e_aaaIp = mysql_real_escape_string(htmlspecialchars($data['advance_aaa_ip']));
	$e_aaaPort = mysql_real_escape_string(htmlspecialchars($data['advance_aaa_port']));
    $e_noOAS = mysql_real_escape_string(htmlspecialchars($data['advance_session']));
}

if ($action == "update") {

    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update $tbl set e_name='$e_name',e_number='$e_number', e_secret='$e_secret', e_password = '$e_password', e_userType= '$e_userType',
 			e_hwNo = '$e_hwNo', e_allowedIp = '$e_allowedIp', e_allowedPort = '$e_allowedPort', e_fwdib = '$e_fwdib', e_fwdiu = '$e_fwdiu',
 			e_fwdina = '$e_fwdina', e_rbtno = '$e_rbtno', e_mcaNo = '$e_mcaNo', e_status = '$e_status', e_aaaIp = '$e_aaaIp',
 			e_aaaPort='$e_aaaPort', e_noOAS = '$e_noOAS', last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";

} elseif ($action == "delete") {

    $action_id = $deleted_id;
    $qry = "update $tbl set is_active='inactive'";
    $qry .= " where id='$action_id'";

    $msg = "Successfully Deleted";

} else {
	$msg = "Successfully Saved";
	$qry = "insert into $tbl (`e_name`,`e_number`, `e_secret`,`e_password`, `e_userType`, `e_hwNo`, e_allowedIp, e_allowedPort, e_fwdib, e_fwdiu,";
	$qry .= " e_fwdina, e_rbtno, e_mcaNo, e_status, e_aaaIp, e_aaaPort, e_noOAS,last_updated,last_updated_by,is_active )";
	$qry .= " VALUES ('$e_name','$e_number','$e_secret','$e_password', '$e_userType', '$e_hwNo', '$e_allowedIp','$e_allowedPort', '$e_fwdib', '$e_fwdiu',";
	$qry .= "'$e_fwdina', '$e_rbtno', '$e_mcaNo', '$e_status', '$e_aaaIp', '$e_aaaPort','$e_noOAS','$last_updated','$last_updated_by','active')";
}

try {
    $res = Sql_exec($cn, $qry);
    
			if($action!="delete"){
				if($action == "update"){
						$options['page_name'] = "Softswitch Extensions Basic Configuration";
						$options['action_type'] = $action;
						$options['table'] = "tbl_ippbx_extensions";
						$options['id_value'] = $action_id;
						setHistory($options);
					}else{
						
						$action_id = Sql_insert_id($cn);
						$action = 'add';
						$options['page_name'] = "Softswitch Extensions Basic Configuration";
						$options['action_type'] = $action;
						$options['table'] = "tbl_ippbx_extensions";
						$options['id_value'] = $action_id;
						setHistory($options);
						}
			}
    
} catch (Exception $e) {
    $is_error = 1;
}

ClosedDBConnection($cn);

if ($is_error == 1) {
    $return_data = array('status' => false, 'message' => 'Submission Failed');
} else {
    $return_data = array('status' => true, 'message' => $msg);
}

echo json_encode($return_data);


/*
	$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
	$e_name = "";
	$e_number = "";
	$e_secret = "";
	$e_nat = "";
	$e_context = "";
	$e_codec = "";
	
	//new fields in extension
	$e_userId = "";
	$e_password = "";
	$e_userType = "";
	$e_hwNo = "";
	$e_allowedIp = "";
	$e_allowedPort = "";
	
	$e_fwdib = "";
	$e_fwdiu = "";
	$e_fwdina = "";
	$e_rbtno = "";
	$e_mcaNo = "";
	$e_status = "";
	
	$e_aaaIp = "";
	$e_aaaPort = "";
	$e_noOAS = "";
	$res = 0;
	
	if(isset($_REQUEST['info']) || isset($_REQUEST['action'])){
	
	       if(isset($_REQUEST['info'])){
			   
			$data= $_REQUEST['info'];
			$action = mysql_real_escape_string(htmlspecialchars($data['action']));
			$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			   
			  if(isset($data['e_name'])){  
		$e_name =mysql_real_escape_string(htmlspecialchars($data['e_name']));
		$e_number = mysql_real_escape_string(htmlspecialchars($data['e_number']));
		$e_secret = mysql_real_escape_string(htmlspecialchars($data['e_secret']));
		$e_codec = mysql_real_escape_string(htmlspecialchars($data['e_codec']));
		$e_password = mysql_real_escape_string(htmlspecialchars($data['e_password']));
		$e_userType = mysql_real_escape_string(htmlspecialchars($data['e_userType']));
		$e_hwNo = mysql_real_escape_string(htmlspecialchars($data['e_hwNo']));
		$e_allowedIp = mysql_real_escape_string(htmlspecialchars($data['e_allowedIp']));
		$e_allowedPort = mysql_real_escape_string(htmlspecialchars($data['e_allowedPort']));
		
		$e_fwdib = mysql_real_escape_string(htmlspecialchars($data['e_fwdib']));
		$e_fwdiu = mysql_real_escape_string(htmlspecialchars($data['e_fwdiu']));
		$e_fwdina = mysql_real_escape_string(htmlspecialchars($data['e_fwdina']));
		$e_rbtno = mysql_real_escape_string(htmlspecialchars($data['e_rbtno']));
		$e_mcaNo = mysql_real_escape_string(htmlspecialchars($data['e_mcaNo']));
		$e_status = mysql_real_escape_string(htmlspecialchars($data['e_status']));
		
		$e_aaaIp = mysql_real_escape_string(htmlspecialchars($data['e_aaaIp']));
		$e_aaaPort = mysql_real_escape_string(htmlspecialchars($data['e_aaaPort']));
		$e_noOAS = mysql_real_escape_string(htmlspecialchars($data['e_noOAS']));
			  }
			  
		   }
		   
		   else{
			   
		$action = mysql_real_escape_string(htmlspecialchars($data['action']));
		$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));	   
		$e_name =mysql_real_escape_string(htmlspecialchars($data['e_name']));
		$e_number = mysql_real_escape_string(htmlspecialchars($data['e_number']));
		$e_secret = mysql_real_escape_string(htmlspecialchars($data['e_secret']));
		$e_codec = mysql_real_escape_string(htmlspecialchars($data['e_codec']));
		$e_password = mysql_real_escape_string(htmlspecialchars($data['e_password']));
		$e_userType = mysql_real_escape_string(htmlspecialchars($data['e_userType']));
		$e_hwNo = mysql_real_escape_string(htmlspecialchars($data['e_hwNo']));
		$e_allowedIp = mysql_real_escape_string(htmlspecialchars($data['e_allowedIp']));
		$e_allowedPort = mysql_real_escape_string(htmlspecialchars($data['e_allowedPort']));
		
		$e_fwdib = mysql_real_escape_string(htmlspecialchars($data['e_fwdib']));
		$e_fwdiu = mysql_real_escape_string(htmlspecialchars($data['e_fwdiu']));
		$e_fwdina = mysql_real_escape_string(htmlspecialchars($data['e_fwdina']));
		$e_rbtno = mysql_real_escape_string(htmlspecialchars($data['e_rbtno']));
		$e_mcaNo = mysql_real_escape_string(htmlspecialchars($data['e_mcaNo']));
		$e_status = mysql_real_escape_string(htmlspecialchars($data['e_status']));
		
		$e_aaaIp = mysql_real_escape_string(htmlspecialchars($data['e_aaaIp']));
		$e_aaaPort = mysql_real_escape_string(htmlspecialchars($data['e_aaaPort']));
		$e_noOAS = mysql_real_escape_string(htmlspecialchars($data['e_noOAS']));
			   
			   
			   }
		   
		if($action == "update"){
			$msg = "Successfully Updated";
			$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
			$qry = "update tbl_ippbx_extensions set e_name='$e_name',e_number='$e_number', e_secret='$e_secret',
					e_codec='$e_codec', e_password = '$e_password', e_userType= '$e_userType', e_hwNo = '$e_hwNo',
					e_allowedIp = '$e_allowedIp', e_allowedPort = '$e_allowedPort', e_fwdib = '$e_fwdib', e_fwdiu = '$e_fwdiu',e_fwdina = '$e_fwdina',
					e_rbtno = '$e_rbtno', e_mcaNo = '$e_mcaNo', e_status = '$e_status', e_aaaIp = '$e_aaaIp', e_aaaPort='$e_aaaPort', e_noOAS = '$e_noOAS'";
			$qry .= " where id='$action_id'";
		} elseif($action == "delete"){
			$msg = "Successfully Deleted";
			$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			$qry = "update tbl_ippbx_extensions set is_active='inactive'";
			$qry .= " where id='$action_id'";
		//$msg.=$qry;
	}else if($action=="insert"){
			$msg = "Successfully Saved";
			$qry = "insert into tbl_ippbx_extensions (`e_name`,`e_number`,"; 
			$qry .= " `e_secret`,`e_codec`,`e_password`, `e_userType`, `e_hwNo`,"; 
			$qry .= " e_allowedIp, e_allowedPort, e_fwdib, e_fwdiu, e_fwdina,";
			$qry .= " e_rbtno, e_mcaNo, e_status, e_aaaIp, e_aaaPort, e_noOAS )";
			$qry .= " VALUES ('$e_name','$e_number','$e_secret','$e_codec', ";
			$qry .= "'$e_password', '$e_userType', '$e_hwNo', '$e_allowedIp',";  
			$qry .= "'$e_allowedPort', '$e_fwdib', '$e_fwdiu','$e_fwdina', '$e_rbtno',";
			$qry .= " '$e_mcaNo', '$e_status', '$e_aaaIp', '$e_aaaPort','$e_noOAS')"; 
		}
		
			try {					 
			$res = Sql_exec($cn,$qry);
			$is_error = 0;
		    }catch (Exception $e){
			
		}  
	}
                         


  	if ($is_error) {
   		$return_data = array('status' => false, 'message' => 'Submission Failed');
	} else {
    	$return_data = array('status' => true, 'message' => $msg);
	}

echo json_encode($return_data);

ClosedDBConnection($cn);
*/
?>