<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 4/27/2015
 * Time: 11:40 AM
 */


$data = $_REQUEST['info'];
include_once "../lib/common.php";
checkSession();
$cn = connectDB();

    $query = 'UPDATE tbl_user  SET `user_status` =0  WHERE `user_id` = ' . "'" . $data['deleted_user_id'] . "'";

$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
} else {
    echo json_encode('Successfully Deleted');
}