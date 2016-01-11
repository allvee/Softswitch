<?php

include_once "../lib/common.php";
$cn = connectDB();

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$source_ip = "";
$source_port = "";
$source_protocol = "";
$destination_ip = "";
$destination_port = "";
$destination_protocol = "";
$route_type = "";
$context_name = "";
$is_error = 1;


if (isset($_REQUEST['info']) || isset($_REQUEST['action'])) {

    if (isset($_REQUEST['info'])) {

        $data = $_REQUEST['info'];
        $action = mysql_real_escape_string(htmlspecialchars($data['action']));
        $action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));

        if (isset($data['gw_name'])) {
            $source_ip = mysql_real_escape_string(htmlspecialchars($data['source_ip']));
            $source_port = mysql_real_escape_string(htmlspecialchars($data['source_port']));
            $source_protocol = mysql_real_escape_string(htmlspecialchars($data['source_protocol']));
            $destination_ip = mysql_real_escape_string(htmlspecialchars($data['destination_ip']));
            $destination_port = mysql_real_escape_string(htmlspecialchars($data['destination_port']));
            $destination_protocol = mysql_real_escape_string(htmlspecialchars($data['destination_protocol']));
            $route_type = mysql_real_escape_string(htmlspecialchars($data['route_type']));
            $context_name = mysql_real_escape_string(htmlspecialchars($data['context_name']));
        }
    } else {
        $action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
        $source_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['source_ip']));
        $source_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['source_port']));
        $source_protocol = mysql_real_escape_string(htmlspecialchars($_REQUEST['source_protocol']));
        $destination_ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['destination_ip']));
        $destination_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['destination_port']));
        $destination_protocol = mysql_real_escape_string(htmlspecialchars($_REQUEST['destination_protocol']));
        $route_type = mysql_real_escape_string(htmlspecialchars($_REQUEST['route_type']));
        $context_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['context_name']));
    }


    if ($action == "update") {

        $msg = "Successfully Updated";
        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
        $qry = "update tbl_ippbx_route set source_ip='$source_ip',source_port='$source_port',                 			               source_protocol='$source_protocol',destination_ip='$destination_ip',destination_port='$destination_port',      								destination_protocol='$destination_protocol',route_type='$route_type',context_name='$context_name'";
        $qry .= " where id='$action_id'";
    } elseif ($action == "delete") {
        $msg = "Successfully Deleted";
        $action_id = mysql_real_escape_string(htmlspecialchars($data['action_id']));
        $qry = "update tbl_ippbx_route set is_active='inactive'";
        $qry .= " where id='$action_id'";
        //$msg.=$qry;
    } else if ($action == "insert") {
        $msg = "Successfully Saved";
        $qry = "insert into tbl_ippbx_route(source_ip,source_port,source_protocol,destination_ip,destination_port,destination_protocol,route_type,context_name)
		 values ('$source_ip','$source_port','$source_protocol','$destination_ip','$destination_port','$destination_protocol','$route_type','$context_name')";
    }

    try {
        $res = Sql_exec($cn, $qry);
		$is_error = 0;
        	if($action!="delete"){
				 if($action == "update"){
					$options['page_name'] = "Softswitch IPPBX Route";
					$options['action_type'] = $action;
					$options['table'] = "tbl_ippbx_route";
					$options['id_value'] = $action_id;
					setHistory($options);
				}else{
					
					$action_id = Sql_insert_id($cn);
					$action = 'add';
					$options['page_name'] = "Softswitch IPPBX Route";
					$options['action_type'] = $action;
					$options['table'] = "tbl_ippbx_route";
					$options['id_value'] = $action_id;
					setHistory($options);
					}
			}
				
				
    } catch (Exception $e) {
        
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