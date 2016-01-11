<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/25/2015
 * Time: 12:57 PM
 */

require_once "common.php";

$rqst = isset($_REQUEST['id']) ? $_REQUEST : exit;

$tbl_pre = 'tbl_audit_trail';
$id_pre = $rqst['id'];

$cn = connectDB();

$query = "SELECT * FROM $tbl_pre where id=$id_pre";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}

$row = Sql_fetch_array($result);

$tbl = $row['table_name'];
$primary_key = $row['primary_key_column'];
$data = array();
$data = (array)json_decode($row['rowvalue']);

$key_value = $data[$primary_key];
unset($data[$primary_key]);

if ($row['pname'] != '' && $row['pname'] != null) {

    $cn=remote_connectDB($row['pname']);
/*
    $query = "SELECT * FROM `tbl_process_db_access` where `pname`='" . $row['pname'] . "'";
    $result = Sql_exec($cn, $query);
    if (!$result) {
        echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
        exit;
    }

    $row_2 = Sql_fetch_array($result);

    $dbtype = $row_2['db_type'];
    $UserID = $row_2['db_uid'];
    $Password = $row_2['db_password'];
    $Server = $row_2['db_server'];
    $Database = $row_2['db_name'];
*/
}

//print_r($data);

$query = "";
$flag = true;
foreach ($data as $k => $v) {
    if ($flag) {
        $query = "UPDATE `$tbl` SET `$k`='$v'";
        $flag = false;
    } else {
        $query .= ", `$k`='$v'";
    }
}

$query .= " WHERE `$primary_key`='$key_value'";

$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}

Sql_Free_Result($result);
ClosedDBConnection($cn);

$return_data = array('status' => true, 'message' => "successful");
echo json_encode($return_data);

