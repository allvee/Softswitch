<?php
/**
 *
 * Edited by Talemul Islam on 5/23/2015
 */
/*include_once "../lib/common.php";
$cn = connectDB();

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['action_id'];
}
$tbl = "tbl_ippbx_dialplan";
$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if ($action != "delete") {
    $name_of_context = mysql_real_escape_string(htmlspecialchars($_REQUEST['dial_plan_name']));
    $ano_pattern = mysql_real_escape_string(htmlspecialchars($_REQUEST['dial_plan_ano']));
    $bno_pattern = mysql_real_escape_string(htmlspecialchars($_REQUEST['dial_plan_bno']));
    $destination_context = mysql_real_escape_string(htmlspecialchars($_REQUEST['dial_plan_des']));
}

if ($action == "update") {
    $msg = "Successfully Updated";
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
    $qry = "update $tbl set name_of_context='$name_of_context',ano_pattern='$ano_pattern', bno_pattern='$bno_pattern',destination_context='$destination_context',
 	last_updated='$last_updated', last_updated_by='$last_updated_by'";

    $qry .= " where id='$action_id'";
} elseif ($action == "delete") {
    $action_id = $deleted_id;
    $qry = "update $tbl set is_active='inactive'";
    $qry .= " where id='$action_id'";

    $msg = "Successfully Deleted";

} else {
    $msg = "Successfully Saved";
    $qry = "insert into tbl_ippbx_dialplan (name_of_context,ano_pattern,bno_pattern,destination_context,last_updated,last_updated_by,is_active)
			 values ('$name_of_context','$ano_pattern','$bno_pattern','$destination_context','$last_updated','$last_updated_by','active')";
}

try {
    $res = Sql_exec($cn, $qry);
      if($action!="delete"){
		 if($action == "update"){
                     $options['cn'] = $cn;
				$options['page_name'] = "Softswitch Dial Plan Setting";
				$options['action_type'] = $action;
				$options['table'] = "tbl_ippbx_dialplan";
				$options['id_value'] = $action_id;
				setHistory($options);
			}else{
				
				$action_id = Sql_insert_id($cn);
				$action = 'add';
                                $options['cn'] = $cn;
				$options['page_name'] = "Softswitch Dial Plan Setting";
				$options['action_type'] = $action;
				$options['table'] = "tbl_ippbx_dialplan";
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

echo json_encode($return_data);*/


require_once "../lib/config.php";
require_once "../lib/common.php";

$cn = connectDB();

$arrayInput = $_REQUEST;
$is_error = 0;

$file_name = $dir_softswitch_ippbx_config . "dialplan.ini";
$lines = count(file($file_name));



    $file = fopen($file_name, "a");

    fwrite($file, "[" . trim($arrayInput['dial_plan_name']) . "]" . "\n");
    fwrite($file, trim($arrayInput['dial_plan_ano']) . " ");
    fwrite($file, trim($arrayInput['dial_plan_bno']) . " ");
    fwrite($file, trim($arrayInput['dial_plan_des']) . "\n");
    fclose($file);
    $is_error = 1;



$config_text = json_encode($arrayInput);
$time_now = date("Y-m-d H:i:s");

$sql = "insert into `tbl_app_configuration` (applicaiton,component,config_text,updated) VALUES ('softswitch_dialplan','dialplan','" . $config_text . "','" . $time_now . "')";
Sql_exec($cn, $sql);

ClosedDBConnection($cn);

if ($is_error == 1) {
    $return_data = array('status' => true, 'message' => 'Successfully Saved.');
    // $is_error = file_writer_vpn_ipsec($cn);
} else {
    $return_data = array('status' => false, 'message' => 'Data Not Saved.');
}

echo json_encode($return_data);





?>