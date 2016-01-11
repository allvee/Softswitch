<?php

/*include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select id,e_name,e_number,e_secret,e_codec,e_nat,e_context,e_userId,e_password,e_userType,e_hwNo,e_allowedIp,e_allowedPort,e_fwdib,e_fwdiu,e_fwdina,e_rbtno,e_mcaNo,e_status,e_aaaIp,e_aaaPort,e_noOAS from tbl_ippbx_extensions where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "e_name");
    $data[$i][$j++] = Sql_Result($row, "e_number");
    $data[$i][$j++] = Sql_Result($row, "e_secret");
    $data[$i][$j++] = Sql_Result($row, "e_password");
	$data[$i][$j++] = Sql_Result($row, "e_userType");
    $data[$i][$j++] = Sql_Result($row, "e_hwNo");
    $data[$i][$j++] = Sql_Result($row, "e_allowedIp");
    $data[$i][$j++] = Sql_Result($row, "e_allowedPort");
	$data[$i][$j++] = Sql_Result($row, "e_fwdib");
    $data[$i][$j++] = Sql_Result($row, "e_fwdiu");
    $data[$i][$j++] = Sql_Result($row, "e_fwdina");
	$data[$i][$j++] = Sql_Result($row, "e_rbtno");
	$data[$i][$j++] = Sql_Result($row, "e_mcaNo");
    $data[$i][$j++] = Sql_Result($row, "e_status");
    $data[$i][$j++] = Sql_Result($row, "e_aaaIp");
    $data[$i][$j++] = Sql_Result($row, "e_aaaPort");
     $data[$i][$j++] = Sql_Result($row, "e_noOAS");

    $data[$i][$j++] = '<span onclick="edit_input_form_extensions_info(this,\'' . Sql_Result($row, "id") . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
        . '&nbsp&nbsp' . '<span onclick="delete_extensions_info(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);*/


include_once "../lib/config.php";


$file_name = $dir_softswitch_ippbx_config."users.ini";

$line = file($file_name);

$latest_line = count($line)-1;
$map = '';

if ($line) {
    $map = array();
    foreach($line as $i => $val ){
        //foreach ($line as $row) {
        $arr = explode(" ", $val);

        if ($i==$latest_line) {

            $map['basic_user_id'] = $arr[0];
            $map['basic_pass'] = $arr[1];
            $map['basic_user_type'] = $arr[2];
            $map['advance_hw'] = $arr[3];
            $map['advance_ip'] = $arr[4];
            $map['advance_port'] = $arr[5];
            $map['advance_busy'] = $arr[6];
            $map['advance_unreachable'] = $arr[7];
            $map['advance_no_ans'] = $arr[8];
            $map['advance_rbt_no'] = $arr[9];
            $map['advance_mca_no'] = $arr[10];
            $map['advance_status'] = $arr[11];
            $map['advance_aaa_ip'] = $arr[12];
            $map['advance_aaa_port'] = $arr[13];
            $map['advance_session'] = $arr[14];

        }else{

            $return_data = array('status' => false, 'map' => $map);
        }


    }
    $status = true;
} else {
    $status = false;
}
$return_data = array('status' => $status, 'map' => $map);

echo json_encode($return_data);




?>
