<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 4/27/2015
 * Time: 1:31 PM
 */


include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "SELECT * FROM tbl_nat_static";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "name");
    $data[$i][$j++] = Sql_Result($row, "direction");
    $data[$i][$j++] = Sql_Result($row, "interface");

    $data[$i][$j++] = Sql_Result($row, "destination_ip");
    $data[$i][$j++] = Sql_Result($row, "destination_port");
    $data[$i][$j++] = Sql_Result($row, "forward_ip");
    $data[$i][$j++] = Sql_Result($row, "forward_port");


    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_nat_static(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_nat_static(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>';
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>
