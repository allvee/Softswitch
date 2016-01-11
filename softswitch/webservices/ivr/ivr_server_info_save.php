
  <?php
 
require_once "../lib/common.php";


$cn = connectDB();
$is_error = 1;

	$server_name = "";
	$db_type = "";
	$database_server = "";
	$user_id = "";
	$database_password = "";
        $database_name= "";
        $prompt_location= "";
       
        $url="";
        $recording_location="";
        
        
	if(isset($_REQUEST['info']) || isset($_REQUEST['action'])){
		
		if(isset($_REQUEST['info'])){
			$data= $_REQUEST['info'];
			$action = mysql_real_escape_string(htmlspecialchars($data['action']));
			$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			if(isset($data['server_name'])){
				$server_name=mysql_real_escape_string(htmlspecialchars($data['server_name ']));
				$db_type=mysql_real_escape_string(htmlspecialchars($data['db_type']));
				$database_server=mysql_real_escape_string(htmlspecialchars($data['database_server']));
                                $user_id=mysql_real_escape_string(htmlspecialchars($data['user_id']));
				$database_password=mysql_real_escape_string(htmlspecialchars($data['database_password']));
				$database_name=mysql_real_escape_string(htmlspecialchars($data['database_name']));
                                $prompt_location=mysql_real_escape_string(htmlspecialchars($data['prompt_location']));
				$url=mysql_real_escape_string(htmlspecialchars($data['url']));
				$recording_location=mysql_real_escape_string(htmlspecialchars($data['recording_location']));
				
			}
		} else {
			$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
                        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
			        $server_name=mysql_real_escape_string(htmlspecialchars($data['server_name ']));
				$db_type=mysql_real_escape_string(htmlspecialchars($data['db_type']));
				$database_server=mysql_real_escape_string(htmlspecialchars($data['database_server']));
                                $user_id=mysql_real_escape_string(htmlspecialchars($data['user_id']));
				$database_password=mysql_real_escape_string(htmlspecialchars($data['database_password']));
				$database_name=mysql_real_escape_string(htmlspecialchars($data['database_name']));
                                $prompt_location=mysql_real_escape_string(htmlspecialchars($data['prompt_location']));
				$url=mysql_real_escape_string(htmlspecialchars($data['url']));
				$recording_location=mysql_real_escape_string(htmlspecialchars($data['recording_location']));
			
		}
		
		if($action == "update"){
			$msg = "Successfully Updated";
			
			$qry = "update tbl_ch_server_info set server_name='$server_name',db_type='$db_type', db_server='$database_server',"
                                . "db_uid='$user_id',db_password='$database_password', db_name='$database_name',"
                                . "prompt_location='$prompt_location',web_service_url='$url', recording_location='$recording_location',";
			$qry .= " where server_name ='$action_id'";
		} elseif($action == "delete"){
			
                       $msg = "Successfully Deleted";
			//$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
                      // $qry="delete * from `shortcode`";
                       $qry = "delete from `tbl_ch_server_info` where `server_name `='".$action_id."'";
                     //  $qry .= " where id='$action_id'";
                      
                        
		} elseif($action=="insert") {
			$msg = "Successfully Saved";
			$qry = "insert into tbl_ch_server_info (server_name,db_type,db_server,db_uid,db_password,db_name,prompt_location,web_service_url,recording_location)
			 values ('$server_name','$db_type','$database_server','$user_id','$database_password','$database_name','$prompt_location','$url','$recording_location')";
		}
		
		try {					 
			$res = Sql_exec($cn,$qry);
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

 ClosedDBConnection($cn);

?>