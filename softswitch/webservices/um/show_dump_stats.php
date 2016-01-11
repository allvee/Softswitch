<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/22/2015
 * Time: 6:29 PM
 */


include_once "../lib/common.php";

//$remoteCn = remote_connectDB('SMSGW');

$action = "";
$choose_file = "";
$chart = "";

$is_error = 1;
$choose_file = mysql_real_escape_string(htmlspecialchars($_REQUEST['choose_file']));
$chart = mysql_real_escape_string(htmlspecialchars($_REQUEST['chart']));

//
//if ($action == "update") {
//    $msg = "Successfully Updated";
//
//    $qry = "update keyword set ShortCode='$shortcode',keyword='$keyword', SMSText='$SMSText',SrcType='$SrcType', URL='$URL', Status='$Status'";
//    $qry .= " where id='$action_id'";
//} elseif ($action == "delete") {
//    $action_id = $deleted_id;
//    $msg = "Successfully Deleted";
//    $qry = "update keyword set  Status='inactive'";
//    $qry .= " where id='$action_id'";
//} else {
//    $msg = "Successfully Saved";
//    $qry = "insert into keyword (ShortCode,keyword,SMSText,SrcType,URL,Status)
//			 values ('$shortcode','$keyword','$SMSText','$SrcType','$URL','$Status')";
//}
//
//
//try {
//
//    $res = Sql_exec($remoteCn, $qry);
//    $is_error = 0;
//} catch (Exception $e) {
//
//}
//

if ($is_error) {
    $return_data = array('status' => false, 'message' => 'Submission Failed');
} else {
    $return_data = array('status' => true, 'message' => $msg);
}

echo json_encode($return_data);

ClosedDBConnection($remoteCn);
?>

