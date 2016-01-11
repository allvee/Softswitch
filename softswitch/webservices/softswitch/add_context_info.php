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

$tbl = "tbl_ippbx_gw";
$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if ($action != "delete") {
    $gw_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_context_name']));
    $gw_context = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_context_context']));
    $gw_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_context_ip']));
    $gw_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_context_port']));
    $gw_direction = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_context_dir']));
    $gw_nat = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_context_nat']));
}

if ($action == "update") {
    $msg = "Successfully Updated";
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update $tbl set gw_name='$gw_name',gw_ip='$gw_ip', gw_port='$gw_port',gw_direction='$gw_direction', gw_nat='$gw_nat',
 			gw_context='$gw_context', last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
} elseif ($action == "delete") {

    $action_id = $deleted_id;
    $qry = "update $tbl set is_active='inactive'";
    $qry .= " where id='$action_id'";

	$msg = "Successfully Deleted";

} else {
    $msg = "Successfully Saved";
    $qry = "insert into $tbl (gw_name,gw_ip,gw_port,gw_direction,gw_nat,gw_context,last_updated,last_updated_by,is_active) values
      ('$gw_name','$gw_ip','$gw_port','$gw_direction','$gw_direction','$gw_context','$last_updated','$last_updated_by','active')";
}

try {
    $res = Sql_exec($cn, $qry);
    if($action!="delete"){
    	if($action == "update"){
            $options['cn'] = $cn;
			$options['page_name'] = "Softswitch Context Setting";
			$options['action_type'] = $action;
			$options['table'] = "tbl_ippbx_gw";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         	$action = 'add';
                $options['cn'] = $cn;
			$options['page_name'] = "Softswitch Context Setting";
			$options['action_type'] = $action;
			$options['table'] = "tbl_ippbx_gw";
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
	$gw_name = "";
	$gw_ip = "";
	$gw_port = "";
	$gw_direction = "";
	$gw_nat = "";
	$gw_context = "";
	$is_error=1;
	
	
	if(isset($_REQUEST['info']) || isset($_REQUEST['action'])){
	
	       if(isset($_REQUEST['info'])){
			   
				$data= $_REQUEST['info'];
				$action = mysql_real_escape_string(htmlspecialchars($data['action']));
				$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			   
				 if(isset($data['gw_name'])){
					$gw_name = mysql_real_escape_string(htmlspecialchars($data['gw_name']));
					$gw_context =mysql_real_escape_string(htmlspecialchars( $data['gw_context']));
			 		$gw_ip =mysql_real_escape_string(htmlspecialchars( $data['gw_ip']));
					$gw_port =mysql_real_escape_string(htmlspecialchars( $data['gw_port']));
					$gw_direction = mysql_real_escape_string(htmlspecialchars($data['gw_direction']));
					$gw_nat =mysql_real_escape_string(htmlspecialchars( $data['gw_nat']));
					
					   
			   }
		   }
              else{	
		$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
		$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
		$gw_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['gw_name']));
		$gw_context =mysql_real_escape_string(htmlspecialchars( $_REQUEST['gw_context']));
		$gw_ip =mysql_real_escape_string(htmlspecialchars( $_REQUEST['gw_ip']));
		$gw_port =mysql_real_escape_string(htmlspecialchars( $_REQUEST['gw_port']));
		$gw_direction = mysql_real_escape_string(htmlspecialchars($_REQUEST['gw_direction']));
		$gw_nat =mysql_real_escape_string(htmlspecialchars( $_REQUEST['gw_nat']));
		
		}      
	   
	
	if($action == "update"){
		
		$msg = "Successfully Updated";
		$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
		$qry = "update tbl_ippbx_gw set gw_name='$gw_name',gw_ip='$gw_ip', gw_port='$gw_port',gw_direction='$gw_direction', gw_nat='$gw_nat', gw_context='$gw_context'";
		$qry .= " where id='$action_id'";
	} elseif($action == "delete"){
			$msg = "Successfully Deleted";
			$action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
			$qry = "update tbl_ippbx_gw set is_active='inactive'";
			$qry .= " where id='$action_id'";
		//$msg.=$qry;
	} else if($action=="insert"){
		$msg = "Successfully Saved";
		$qry = "insert into tbl_ippbx_gw (gw_name,gw_ip,gw_port,gw_direction,gw_nat,gw_context) values ('$gw_name','$gw_ip','$gw_port','$gw_direction','$gw_direction','$gw_context')";
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