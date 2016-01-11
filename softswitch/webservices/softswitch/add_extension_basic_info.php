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

$tbl = "tbl_ippbx_extensions";
$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

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


$file_name = $dir_softswitch_ippbx_config . "users.ini";
$lines_count = count(file($file_name));


$lines = file($file_name);


foreach ($lines as $key => $val) {
    if ($key == $action_id)
        $search = trim($val);
}

//////////////////////////////////////////////////////////////////

if ($action != "delete") {
    $e_name = mysql_real_escape_string(htmlspecialchars($data['basic_name']));
    $e_number = mysql_real_escape_string(htmlspecialchars($data['basic_user_id']));
    $e_secret = mysql_real_escape_string(htmlspecialchars($data['basic_secret']));
    $e_password = mysql_real_escape_string(htmlspecialchars($data['basic_pass']));
    $e_userType = mysql_real_escape_string(htmlspecialchars($data['basic_user_type']));
    $e_hwNo = mysql_real_escape_string(htmlspecialchars($data['advance_hw']));
    $e_allowedIp = mysql_real_escape_string(htmlspecialchars($data['advance_ip']));
    $e_allowedPort = mysql_real_escape_string(htmlspecialchars($data['advance_port']));
    $e_fwdib = mysql_real_escape_string(htmlspecialchars($data['advance_busy']));
    $e_fwdiu = mysql_real_escape_string(htmlspecialchars($data['advance_unreachable']));
    $e_fwdina = mysql_real_escape_string(htmlspecialchars($data['advance_no_ans']));
    $e_rbtno = mysql_real_escape_string(htmlspecialchars($data['advance_rbt_no']));
    $e_mcaNo = mysql_real_escape_string(htmlspecialchars($data['advance_mca_no']));
    $e_status = mysql_real_escape_string(htmlspecialchars($data['advance_status']));
    $e_aaaIp = mysql_real_escape_string(htmlspecialchars($data['advance_aaa_ip']));
    $e_aaaPort = mysql_real_escape_string(htmlspecialchars($data['advance_aaa_port']));
    $e_noOAS = mysql_real_escape_string(htmlspecialchars($data['advance_session']));
}

if ($action == "update") {
    $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));

    $qry = "update $tbl set e_name='$e_name',e_userId='$e_number', e_secret='$e_secret', e_password = '$e_password', e_userType= '$e_userType',
 			e_hwNo = '$e_hwNo', e_allowedIp = '$e_allowedIp', e_allowedPort = '$e_allowedPort', e_fwdib = '$e_fwdib', e_fwdiu = '$e_fwdiu',
 			e_fwdina = '$e_fwdina', e_rbtno = '$e_rbtno', e_mcaNo = '$e_mcaNo', e_status = '$e_status', e_aaaIp = '$e_aaaIp',
 			e_aaaPort='$e_aaaPort', e_noOAS = '$e_noOAS', last_updated='$last_updated', last_updated_by='$last_updated_by'";
    $qry .= " where id='$action_id'";
    $update=1;

$msg = "Successfully Updated";
} elseif ($action == "delete") {

    $action_id = $deleted_id;
    $qry = "update $tbl set is_active='inactive'";
    $qry .= " where id='$action_id'";
	$update=02;
    $msg = "Successfully Deleted";


}
else{
    $msg = "Successfully Saved";
    $qry = "insert into $tbl (`e_name`,`e_userId`, `e_secret`,`e_password`, `e_userType`, `e_hwNo`, e_allowedIp, e_allowedPort, e_fwdib, e_fwdiu,";
    $qry .= " e_fwdina, e_rbtno, e_mcaNo, e_status, e_aaaIp, e_aaaPort, e_noOAS,last_updated,last_updated_by,is_active )";
    $qry .= " VALUES ('$e_name','$e_number','$e_secret','$e_password', '$e_userType', '$e_hwNo', '$e_allowedIp','$e_allowedPort', '$e_fwdib', '$e_fwdiu',";
    $qry .= "'$e_fwdina', '$e_rbtno', '$e_mcaNo', '$e_status', '$e_aaaIp', '$e_aaaPort','$e_noOAS','$last_updated','$last_updated_by','active')";
$update=0;
   
}

try {
    $res = Sql_exec($cn, $qry);

    if($update==1){

       $qry_file="SELECT * FROM `tbl_ippbx_extensions` where `is_active`='active'";
        $result = Sql_exec($cn, $qry_file);
        $file = fopen($file_name, "w");
		
        while ($row = Sql_fetch_array($result)) {

            fwrite($file, trim(Sql_Result($row, "e_userId")). " ");
            fwrite($file, trim(Sql_Result($row, "e_password")). " ");
            fwrite($file, trim(Sql_Result($row, "e_userType")). " ");
            fwrite($file, trim(Sql_Result($row, "e_hwNo")). " ");
            fwrite($file, trim(Sql_Result($row, "e_allowedIp")). " ");
            fwrite($file, trim(Sql_Result($row, "e_allowedPort")). " ");
            fwrite($file, trim(Sql_Result($row, "e_fwdib")). " ");
            fwrite($file, trim(Sql_Result($row, "e_fwdiu")). " ");
            fwrite($file, trim(Sql_Result($row, "e_fwdina")). " ");
            fwrite($file, trim(Sql_Result($row, "e_rbtno")). " ");
            fwrite($file, trim(Sql_Result($row, "e_mcaNo")). " ");
            fwrite($file, trim(Sql_Result($row, "e_status")). " ");
            fwrite($file, trim(Sql_Result($row, "e_aaaIp")). " ");
            fwrite($file, trim(Sql_Result($row, "e_aaaPort")). " ");
            fwrite($file, trim(Sql_Result($row, "e_noOAS")). "\n");
 $is_error = 1;


        }


    }else if($update==2){

        $qry_file="SELECT * FROM `tbl_ippbx_extensions` where `is_active`='active'";
        $result = Sql_exec($cn, $qry_file);
        $file = fopen($file_name, "w");
        while ($row = Sql_fetch_array($result)) {

            fwrite($file, trim(Sql_Result($row, "e_userId")). " ");
            fwrite($file, trim(Sql_Result($row, "e_password")). " ");
            fwrite($file, trim(Sql_Result($row, "e_userType")). " ");
            fwrite($file, trim(Sql_Result($row, "e_hwNo")). " ");
            fwrite($file, trim(Sql_Result($row, "e_allowedIp")). " ");
            fwrite($file, trim(Sql_Result($row, "e_allowedPort")). " ");
            fwrite($file, trim(Sql_Result($row, "e_fwdib")). " ");
            fwrite($file, trim(Sql_Result($row, "e_fwdiu")). " ");
            fwrite($file, trim(Sql_Result($row, "e_fwdina")). " ");
            fwrite($file, trim(Sql_Result($row, "e_rbtno")). " ");
            fwrite($file, trim(Sql_Result($row, "e_mcaNo")). " ");
            fwrite($file, trim(Sql_Result($row, "e_status")). " ");
            fwrite($file, trim(Sql_Result($row, "e_aaaIp")). " ");
            fwrite($file, trim(Sql_Result($row, "e_aaaPort")). " ");
            fwrite($file, trim(Sql_Result($row, "e_noOAS")). "\n");
 $is_error = 1;


        }


    }else{
    if ($lines_count <= 1000) {


        $file = fopen($file_name, "a");


        fwrite($file, trim($arrayInput['basic_user_id']). " ");
        fwrite($file, trim($arrayInput['basic_pass']). " ");
        fwrite($file, trim($arrayInput['basic_user_type']). " ");
        fwrite($file, trim($arrayInput['advance_hw']). " ");
        fwrite($file, trim($arrayInput['advance_ip']). " ");
        fwrite($file, trim($arrayInput['advance_port']). " ");
        fwrite($file, trim($arrayInput['advance_busy']). " ");
        fwrite($file, trim($arrayInput['advance_unreachable']). " ");
        fwrite($file, trim($arrayInput['advance_no_ans']). " ");
        fwrite($file, trim($arrayInput['advance_rbt_no']). " ");
        fwrite($file, trim($arrayInput['advance_mca_no']). " ");
        fwrite($file, trim($arrayInput['advance_status']). " ");
        fwrite($file, trim($arrayInput['advance_aaa_ip']). " ");
        fwrite($file, trim($arrayInput['advance_aaa_port']). " ");
        fwrite($file, trim($arrayInput['advance_session']). "\n");
        fclose($file);
        $is_error = 1;
    }
}


} catch (Exception $e) {
    $is_error = 1;
}





ClosedDBConnection($cn);

if ($is_error == 1) {
    $return_data = array('status' => true, 'message' => 'Successfully Saved.');
    // $is_error = file_writer_vpn_ipsec($cn);
} else {
    $return_data = array('status' => false, 'message' => 'Data Not Saved.');
}


echo json_encode($return_data);


?>
