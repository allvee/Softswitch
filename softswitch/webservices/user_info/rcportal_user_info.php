<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 4/27/2015
 * Time: 10:31 AM
 */

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "SELECT * FROM tbl_user where user_status ='1'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "user_id");
    $data[$i][$j++] = Sql_Result($row, "UserID");
    $data[$i][$j++] = Sql_Result($row, "UserName");

    $data[$i][$j++] = Sql_Result($row, "Password");
    $data[$i][$j++] = Sql_Result($row, "Email");
    $data[$i][$j++] = Sql_Result($row, "UserType");

    $data[$i][$j++] = Sql_Result($row, "LastUpdate");
    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_user_info(this,'."'".Sql_Result($row, "user_id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_user_info(this,'."'".Sql_Result($row, "user_id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>';
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>
