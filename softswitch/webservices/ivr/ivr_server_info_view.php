<?php

include_once "../lib/common.php";
$cn = connectDB();

 $arrayInput = array();


//$res = Sql_exec($cn,$remoteCnQry);
//$dt = Sql_fetch_array($res);
$query = "select * FROM tbl_ch_server_info";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "server_name");
    $data[$i][$j++] = Sql_Result($row, "db_type");
    $data[$i][$j++] = Sql_Result($row, "database_server");
      $data[$i][$j++] = Sql_Result($row, "user_id");
    $data[$i][$j++] = Sql_Result($row, "database_password");
    $data[$i][$j++] = Sql_Result($row, "database_name");
      $data[$i][$j++] = Sql_Result($row, "prompt_location");
    $data[$i][$j++] = Sql_Result($row, "url");
    $data[$i][$j++] = Sql_Result($row, "recording_location");
   
  
    $data[$i][$j++] = '<span  onclick="edit_input_form_ivr_server_info(this,'."'".Sql_Result($row, "server_name")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_ivr_server_info(this,'."'".Sql_Result($row, "server_name")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>
