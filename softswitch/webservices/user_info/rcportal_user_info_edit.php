<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 4/27/2015
 * Time: 10:44 AM
 */


$data= $_REQUEST;
include_once "../lib/common.php";
$cn = connectDB();

$query='UPDATE tbl_user  SET `UserID` = '."'".mysql_real_escape_string($data['user_info_UserID'])."'".' ,`Password` = '."'".md5($data['user_info_Password'])."'".' ,`UserName` = '."'".mysql_real_escape_string($data['user_info_UserName'])."'".' , `Email` = '."'".mysql_real_escape_string($data['user_info_Email'])."'".', `UserType` = '."'".mysql_real_escape_string($data['user_info_UserType'])."'".', `LastUpdate` = '."'".mysql_real_escape_string($data['user_info_LastUpdate'])."'".' WHERE `user_id` = '."'". mysql_real_escape_string($data['user_info_user_id'])."'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}else{
    echo json_encode('Successfully updated');
}
