<?php

require_once "../lib/common.php";


$v_arr = array();
$count = 0;
$is_error = 0;
//$user_id = $_SESSION['USER_ID'];
$info = $_POST['info'];

$remoteCn = remote_connectDB('ISMP');

$action_id = mysql_real_escape_string(htmlspecialchars($info['action_id']));

		$qry = "SELECT `msg`,`mask`,`group_id` FROM `tbl_smsgw_msg_permission` WHERE `id`='".$action_id."' AND `status`='pending'"; 
	
		$res = Sql_fetch_array(Sql_exec($remoteCn,$qry));
		$group_id = $res['group_id'];
		$msg = $res['msg'];
		$mask = $res['mask'];
	    
	
		$qry = "SELECT `recipient_no` FROM `tbl_smsgw_group_recipient` WHERE `group_id`='".$group_id."' AND `is_active`='active'"; 
	
		$res = Sql_exec($remoteCn,$qry);
		$v_arr = array();
		$text='';
		$encodedMsg =rawurlencode(htmlspecialchars($msg));
		$encodedMsg = str_replace('.','%2E',$encodedMsg);
	
		while($dt = Sql_fetch_array($res)){
			$mobile_number = $dt['recipient_no'];
			if($count == 0)
			{
				$text.= $mobile_number.'|'.$encodedMsg; 	
			}
			else
			{
				$text.="|".$mobile_number.'|'.$encodedMsg; 	
			}
			$count++;
		}
		
		
	 
		
	   /* $remoteCn = remote_connectDB('SMSGW');
		$count_qry = "select count(UserID) as c_user from user where UserName= '".$_SESSION["LoggedInUserID"]."' and Password='ssdt'";
		$insert_qry = "insert into user (UserName,Password) values ('".$_SESSION["LoggedInUserID"]."','ssdt')";
		$rs = Sql_exec($remoteCn, $count_qry);
		$dt = Sql_fetch_array($rs);
		$c_user = intval($dt['c_user']);
		if($c_user == 0) Sql_exec($remoteCn, $insert_qry);
		ClosedDBConnection($remoteCn);
	    */
		//$_SESSION["LoggedInUserID"]
		$url = $bulk_sms_url . "UserName=admin&Password=ssdt&Sender=" . $mask . "&text="; 
		//"http://localhost/sendsms/SendMultipleSMS.php?UserName=admin&Password=admin&Sender=1234&text=";
		$url .=$text;
		$url .="&NO=".$count;
		// echo $url;
		$response = file_get_contents($url);
		
		if($response == "Successfully inserted to smsoutbox"){
			 $qry = "update `tbl_smsgw_msg_permission` set `status`='proceed' where `id`='$action_id'"; 
		     $res = Sql_exec($remoteCn,$qry);
		}
		
		ClosedDBConnection($remoteCn);
		echo $response;
    
	
?>