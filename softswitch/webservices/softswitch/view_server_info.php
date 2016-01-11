<?php

/*include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select id,server_ip,server_port,protocol,client_bind_ip,client_bind_port,sip_user_id,sip_password from tbl_ippbx_server where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "server_ip");
    $data[$i][$j++] = Sql_Result($row, "server_port");
    $data[$i][$j++] = Sql_Result($row, "protocol");
    $data[$i][$j++] = Sql_Result($row, "client_bind_ip");
    $data[$i][$j++] = Sql_Result($row, "client_bind_port");
    $data[$i][$j++] = Sql_Result($row, "sip_user_id");
    $data[$i][$j++] = Sql_Result($row, "sip_password");

    $data[$i][$j++] = '<span onclick="edit_input_form_server_info(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="delete_server_info(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

//    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_server_info(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
//</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_server_info(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
//</button>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);*/

include_once "../lib/config.php";


$file_name = $dir_softswitch_ippbx_config."servers.ini";

$line = file($file_name);

$latest_line = count($line)-1;
$map = '';

if ($line) {
    $map = array();
    foreach($line as $i => $val ){
        //foreach ($line as $row) {
        $arr = explode(" ", $val);

        if ($i==$latest_line) {

            $map['server_ip'] = $arr[0];
            $map['server_port'] = $arr[1];
            $map['protocol'] = $arr[2];
            $map['client_bind_ip'] = $arr[3];
            $map['client_bind_port'] = $arr[4];
            $map['is_need_flag'] = $arr[5];
            $map['from_number_start_range'] = $arr[6];
            $map['from_number_end_range'] = $arr[7];
            $map['to_number_start_range'] = $arr[8];
            $map['to_number_end_range'] = $arr[9];
            $map['sip_user_id'] = $arr[10];
            $map['sip_password'] = $arr[11];
            $map['is_proxy_status'] = $arr[12];
            $map['forward_per_index'] = $arr[13];
            $map['is_active_status'] = $arr[14];
            $map['is_internal_status'] = $arr[15];

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
