<?php
require_once "../lib/common.php";

$cn = connectDB();

$qry="SELECT * FROM `tbl_process_db_access` WHERE `pname`='ISMP'";
$res = Sql_exec($cn,$qry);
$dt = Sql_fetch_array($res);

$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];
ClosedDBConnection($cn);

$is_error =0;
$remoteCn = connectDB();

$input_method = mysql_real_escape_string(htmlspecialchars($_POST['input_method']));
$group_id = mysql_real_escape_string(htmlspecialchars($_POST['group']));
if( $input_method == "manual" ){
	 $recipient_name = mysql_real_escape_string(htmlspecialchars($_POST['group_recipient_name']));
	 $prefix = mysql_real_escape_string(htmlspecialchars($_POST['prefix']));
	 $mobile_no = mysql_real_escape_string(htmlspecialchars($_POST['mobile_number']));
	 $recipient_no =  $prefix.$mobile_no;
	 $qry = "INSERT INTO `tbl_smsgw_group_recipient` (`group_id`,`recipient_name`, `recipient_no`,`last_updated`) VALUES ('$group_id','$recipient_name','$recipient_no',NOW())";
	 try {
			Sql_exec($remoteCn,$qry);
								//log_generator("Success QRY :: ".$qry,__FILE__,__FUNCTION__,__LINE__,NULL);
	 }catch (Exception $e){
		$is_error = 1;
	 }
	
}else if( $input_method == "import_file" ){
	
	if(isset($_FILES['file'])){
		   
		   $file = fopen($_FILES['file']['tmp_name'],"r");
		   if( $file != false && $file){
			     
				 while(!feof($file))
				 {
					$data = array();
					$data = fgetcsv($file);
					if($data[0]!=null && $data[0]!="" )
					{
						$qry = "INSERT INTO `tbl_smsgw_group_recipient` (`group_id`, `recipient_no`,`last_updated`) VALUES ('".$group_id."','".$data[0]."',NOW())";
				
						try {
								Sql_exec($remoteCn,$qry);
								//log_generator("Success QRY :: ".$qry,__FILE__,__FUNCTION__,__LINE__,NULL);
						} catch (Exception $e){
								$is_error = 1;
						}
					}
				  }
			}else{
			   echo "Can't Open File";
			   exit;   
		   }
		   
		
	}else{
		
	     echo "File Not Found!!";
		 exit;	
	}
	
}else{
	
}

echo $is_error;	
ClosedDBConnection($remoteCn);

	
?>