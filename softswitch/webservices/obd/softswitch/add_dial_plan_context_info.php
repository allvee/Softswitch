<?php
/**
 *
 * Edited by Talemul Islam on 5/23/2015
 */
include_once "../lib/common.php";

$cn = connectDB();

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
 
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['action_id'];
}

$tbl = "tbl_ippbx_dialplan_context";
$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if ($action != "delete") {
	$dial_plan_context = mysql_real_escape_string(htmlspecialchars($_REQUEST['dial_plan_context_name']));
}

if ($action == "update") {
	$msg = "Successfully Updated";
	$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
	$qry = "update $tbl set dial_plan_context='$dial_plan_context', last_updated='$last_updated', last_updated_by='$last_updated_by'";
	$qry .= " where id='$action_id'";

} elseif ($action == "delete") {
    $action_id = $deleted_id;
	 
	$qry = "update $tbl set is_active='inactive'";
	$qry .= " where id='$action_id'";
	$msg = "Successfully Deleted";

} else {
	$msg = "Successfully Saved";
	$qry="insert into $tbl (dial_plan_context,last_updated,last_updated_by,is_active) values ('$dial_plan_context','$last_updated','$last_updated_by','active')";
}
 
try {
	$res = Sql_exec($cn, $qry);
       if($action!="delete"){
          if($action == "update"){
			$options['page_name'] = "Softswitch Dial Plan Context Setting";
			$options['action_type'] = $action;
			$options['table'] = "tbl_ippbx_dialplan_context";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         	$action = 'add';
			$options['page_name'] = "Softswitch Dial Plan Context Setting";
			$options['action_type'] = $action;
			$options['table'] = "tbl_ippbx_dialplan_context";
			$options['id_value'] = $action_id;
			setHistory($options);
			}
	   }
} catch (Exception $e) {
	$is_error = 1;
}

ClosedDBConnection($cn);

if ($is_error==1) {
	$return_data = array('status' => false, 'message' => 'Submission Failed');
} else {
	$return_data = array('status' => true, 'message' => $msg);
}

echo json_encode($return_data);


/*
	$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
	$dial_plan_context = "";
	$is_error=1;
	
	
	if(isset($_REQUEST['info']) || isset($_REQUEST['action'])){
	
	       if(isset($_REQUEST['info'])){
			   
				$data= $_REQUEST['info'];
				$action = mysql_real_escape_string(htmlspecialchars($data['action']));
				$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			   
				 if(isset($data['gw_name'])){
					$dial_plan_context = mysql_real_escape_string(htmlspecialchars($data['gw_name']));
				}
		   } else{	
				$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
				$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
				$dial_plan_context = mysql_real_escape_string(htmlspecialchars($_REQUEST['gw_name']));
		   }
	   
	
	if($action == "update"){
		
		$msg = "Successfully Updated";
		$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
		$qry = "update tbl_ippbx_dialplan_context set dial_plan_context='$dial_plan_context'";
		$qry .= " where id='$action_id'";
	} elseif($action == "delete"){
			$msg = "Successfully Deleted";
			$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			$qry = "update tbl_ippbx_dialplan_context set is_active='inactive'";
			$qry .= " where id='$action_id'";
		//$msg.=$qry;
	} else if($action=="insert"){
		$msg = "Successfully Saved";
		$qry = "insert into tbl_ippbx_dialplan_context (dial_plan_context) values ('$dial_plan_context')";
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