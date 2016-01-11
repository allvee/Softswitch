<?php

  

$data = $_REQUEST;

require_once "../lib/config.php";
require_once "../lib/common.php";

$cn = connectDB();

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['action_id'];
}
//////////////////////////////////////////////////////////////////

$arrayInput = $_REQUEST;
$is_error = 0;
$action = $arrayInput['action'];
$action_id = $arrayInput['action_id'];

$data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';

if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['action_id'];
}


 $file_name = $dir_softswitch_ippbx_config . "routes.ini";
$lines_count = count(file($file_name));


$lines = file($file_name);


foreach ($lines as $key => $val) {
    if ($key == $action_id)
        $search = trim($val);
}

//////////////////////////////////////////////////////////////////


if ($action != "delete") {
    $source_ip = mysql_real_escape_string(htmlspecialchars($data['source_ip']));
            $source_port = mysql_real_escape_string(htmlspecialchars($data['source_port']));
            $source_protocol = mysql_real_escape_string(htmlspecialchars($data['source_protocol']));
            $destination_ip = mysql_real_escape_string(htmlspecialchars($data['destination_ip']));
            $destination_port = mysql_real_escape_string(htmlspecialchars($data['destination_port']));
            $destination_protocol = mysql_real_escape_string(htmlspecialchars($data['destination_protocol']));
            $route_type = mysql_real_escape_string(htmlspecialchars($data['route_type']));
            $context_name = mysql_real_escape_string(htmlspecialchars($data['context_name']));
}

if ($action == "update") {
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
        $msg = "Successfully Updated";
		
        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
        $qry = "update tbl_ippbx_route set source_ip='$source_ip',source_port='$source_port',source_protocol='$source_protocol',destination_ip='$destination_ip',destination_port='$destination_port',destination_protocol='$destination_protocol',route_type='$route_type',context_name='$context_name'";
        $qry .= " where id='$action_id'";
    $update=1;


} elseif ($action == "delete") {

    $msg = "Successfully Deleted";
    $action_id = $deleted_id;
        $qry = "update tbl_ippbx_route set is_active='inactive'";
        $qry .= " where id='$action_id'";
	$update=02;

    }
else{
    $msg = "Successfully Saved";
        $qry = "insert into tbl_ippbx_route(source_ip,source_port,source_protocol,destination_ip,destination_port,destination_protocol,route_type,context_name)
		 values ('$source_ip','$source_port','$source_protocol','$destination_ip','$destination_port','$destination_protocol','$route_type','$context_name')";
$update=0;
   
}

try {
    $res = Sql_exec($cn, $qry);

    if($update==1){

       $qry_file="SELECT * FROM `tbl_ippbx_route` where `is_active`='active'";
        $result = Sql_exec($cn, $qry_file);
        $file = fopen($file_name, "w");
		
        while ($row = Sql_fetch_array($result)) {

        fwrite($file, trim($arrayInput['source_ip']) . " ");
        fwrite($file, trim($arrayInput['source_port']) . " ");
        fwrite($file, trim($arrayInput['source_protocol']) . " ");
        fwrite($file, trim($arrayInput['destination_ip']) . " ");
        fwrite($file, trim($arrayInput['destination_port']) . " ");
        fwrite($file, trim($arrayInput['destination_protocol']) . " ");
        fwrite($file, trim($arrayInput['route_type']) . " ");
        fwrite($file, trim($arrayInput['context_name']) . "\n");
$is_error = 1;

        }


    }else if($update==2){

        $qry_file="SELECT * FROM `tbl_ippbx_route` where `is_active`='active'";
        $result = Sql_exec($cn, $qry_file);
        $file = fopen($file_name, "w");
        while ($row = Sql_fetch_array($result)) {

        fwrite($file, trim($arrayInput['source_ip']) . " ");
        fwrite($file, trim($arrayInput['source_port']) . " ");
        fwrite($file, trim($arrayInput['source_protocol']) . " ");
        fwrite($file, trim($arrayInput['destination_ip']) . " ");
        fwrite($file, trim($arrayInput['destination_port']) . " ");
        fwrite($file, trim($arrayInput['destination_protocol']) . " ");
        fwrite($file, trim($arrayInput['route_type']) . " ");
        fwrite($file, trim($arrayInput['context_name']) . "\n");
$is_error = 1;

        }


    }else{
    if ($lines_count <= 1000) {


        $file = fopen($file_name, "a");


        fwrite($file, trim($arrayInput['source_ip']) . " ");
        fwrite($file, trim($arrayInput['source_port']) . " ");
        fwrite($file, trim($arrayInput['source_protocol']) . " ");
        fwrite($file, trim($arrayInput['destination_ip']) . " ");
        fwrite($file, trim($arrayInput['destination_port']) . " ");
        fwrite($file, trim($arrayInput['destination_protocol']) . " ");
        fwrite($file, trim($arrayInput['route_type']) . " ");
        fwrite($file, trim($arrayInput['context_name']) . "\n");
        fclose($file);
        $is_error = 1;

    }
}


} catch (Exception $e) {
    $is_error = 0;
}





ClosedDBConnection($cn);

if ($is_error == 1) {
    $return_data = array('status' => true, 'message' =>  $msg );
    } else {
    $return_data = array('status' => false, 'message' => 'Data Not Saved.');
}



echo json_encode($return_data);


//////////////////////////////////////////////////////////////////////////




?>

