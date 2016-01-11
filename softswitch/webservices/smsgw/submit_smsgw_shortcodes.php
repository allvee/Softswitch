
  <?php
 
require_once "../lib/common.php";


$cn = connectDB();
$is_error = 1;


    $remoteCnQry="select * from tbl_process_db_access where pname='SMSGW'";
    $res = Sql_exec($cn,$remoteCnQry);
    $dt = Sql_fetch_array($res);

    $dbtype=$dt['db_type'];
    $Server=$dt['db_server'];
    $UserID=$dt['db_uid'];
    $Password=$dt['db_password'];
    $Database=$dt['db_name'];
    ClosedDBConnection($cn);

    $remoteCn=connectDB();

	$action = "";
	$shortcode = "";
	$ErrorSMS = "";
	$DefaultKeyword = "";
	//$destination_context = "";
	//$is_error = 1;
		
	if(isset($_REQUEST['info']) || isset($_REQUEST['action'])){
		
		if(isset($_REQUEST['info'])){
			$data= $_REQUEST['info'];
			$action = mysql_real_escape_string(htmlspecialchars($data['action']));
			$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			if(isset($data['shortcode'])){
				$shortcode=mysql_real_escape_string(htmlspecialchars($data['shortcode']));
				$ErrorSMS=mysql_real_escape_string(htmlspecialchars($data['ErrorSMS']));
				$DefaultKeyword=mysql_real_escape_string(htmlspecialchars($data['DefaultKeyword']));
				
			}
		} else {
			$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
                        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
			$shortcode=mysql_real_escape_string(htmlspecialchars($_REQUEST['shortcode']));
			$ErrorSMS=mysql_real_escape_string(htmlspecialchars($_REQUEST['ErrorSMS']));
			$DefaultKeyword=mysql_real_escape_string(htmlspecialchars($_REQUEST['DefaultKeyword']));
			
		}
		
		if($action == "update"){
			$msg = "Successfully Updated";
			
			$qry = "update shortcode set shortcode='$shortcode',ErrorSMS='$ErrorSMS', DefaultKeyword='$DefaultKeyword'";
			$qry .= " where shortcode='$action_id'";
		} elseif($action == "delete"){
			
                       $msg = "Successfully Deleted";
			//$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
                      // $qry="delete * from `shortcode`";
                       $qry = "delete from `shortcode` where `shortcode`='".$action_id."'";
                     //  $qry .= " where id='$action_id'";
                      
                        
		} elseif($action=="insert") {
			$msg = "Successfully Saved";
			$qry = "insert into shortcode (shortcode,ErrorSMS,DefaultKeyword)
			 values ('$shortcode','$ErrorSMS','$DefaultKeyword')";
		}
		
		try {					 
			$res = Sql_exec($remoteCn,$qry);
			$is_error = 0;
		} catch (Exception $e){
			
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