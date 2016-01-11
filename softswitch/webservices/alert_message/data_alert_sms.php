<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/14/2015
 * Time: 4:15 PM
 */
require_once "../lib/common.php";
//require_once "../../Lib/rcportalLib.php";
require_once "../lib/filewriter.php";

$cn = connectDB();

$arrayInput = array();
$query = "SELECT `config` FROM `tbl_alert_config` where id=2";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
/*
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "name");
    $data[$i][$j++] = Sql_Result($row, "message");

    $info = Sql_Result($row, "id") . '|' . Sql_Result($row, "name") . '|' . Sql_Result($row, "message");

    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_alert_msg_event(this,\'' . $info . '\'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit</button>'
        . '<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_alert_msg_event(this,' . Sql_Result($row, "id") . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete</button>';


    $i++;
}
*/
$row = Sql_fetch_array($result);
echo ($row['config']);
Sql_Free_Result($result);
ClosedDBConnection($cn);