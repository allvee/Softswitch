<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/14/2015
 * Time: 2:48 PM
 */

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "SELECT * FROM `tbl_alert_event` where `is_active`='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "name");
    $data[$i][$j++] = Sql_Result($row, "message");

    $info = Sql_Result($row, "id") . '|' . Sql_Result($row, "name") . '|' . Sql_Result($row, "message");

    $data[$i][$j++] = '<span onclick="edit_alert_msg_event(this,\'' . $info . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
        . '&nbsp&nbsp' . '<span onclick="delete_alert_msg_event(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

/*
    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_alert_msg_event(this,\'' . $info . '\'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit</button>'
        . '<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_alert_msg_event(this,' . Sql_Result($row, "id") . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete</button>';
*/

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>