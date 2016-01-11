<?php
session_start();
require_once "../lib/common.php";
$cn = connectDB();
$dstMN = "";
$msg  = "";
$srcMN  = "";


$info = $_POST['info'];

if( isset($info['dstMN']) ){
	$dstMN = mysql_real_escape_string(htmlspecialchars($info['dstMN']));
}
if( isset($info['msg'])){
	$msg = mysql_real_escape_string(htmlspecialchars($info['msg']));
}
if(isset($info['srcMN'])){
    $srcMN =  mysql_real_escape_string(htmlspecialchars($info['srcMN']));
}


	
	
	$remoteCnQry="select * from `tbl_process_db_access` where `pname`='SMSGW'";
	$res = Sql_exec($cn,$remoteCnQry);
	$dt = Sql_fetch_array($res);

	$dbtype = $dt['db_type'];
	$Server = $dt['db_server'];
	$UserID = $dt['db_uid'];
	$Password = $dt['db_password'];
	$Database = $dt['db_name'];
	
	ClosedDBConnection($cn);
	
	$text='';
    $encodedMsg =rawurlencode($msg);
	$encodedMsg = str_replace('.','%2E',$encodedMsg);
	$text.= $dstMN.'|'.$encodedMsg; 
	
	$count_qry = "select count(UserID) as c_user from `user` where `UserName`= '".$_SESSION["UserID"]."'";
	$insert_qry = "insert into `user` (`UserName`,`Password`) values ('".$_SESSION["UserID"]."','ssdt')";
	
	$remoteCn = connectDB();
	$rs = Sql_exec($remoteCn, $count_qry);
    $dt = Sql_fetch_array($rs);
	$c_user = intval($dt['c_user']);
	if($c_user == 0) Sql_exec($remoteCn, $insert_qry);
	
	ClosedDBConnection($remoteCn);
	
	$url = $single_sms_url . "UserName=".$_SESSION["UserID"]."&Password=ssdt&Sender="; //"http://localhost/SendSMS/sendSingleSMS.php?UserName=admin&Password=admin&Sender=1234&text=";
	$url .= $srcMN;
	$url .= "&text=".$text;
	//$url .="&NO=".$count;
	//echo $url;
	
	$response = file_get_contents($url);
	
	if(trim($response) == trim("Successfully inserted to smsoutbox")){
		echo 0;
	} else {
		echo 1;
	}
    

?>