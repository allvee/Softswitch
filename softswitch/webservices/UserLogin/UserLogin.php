<?php
/**
 * Created by PhpStorm.
 * User: Mazhar
 * Date: 3/10/2015
 * Time: 4:33 PM
 */

include_once "../lib/common.php";

$cn = connectDB();


$arrayInput = $_REQUEST;
if (!isset($arrayInput['uid']) || !isset($arrayInput['pass'])) {
    $returnValue['msg'] = 'User name and password are required';
} else {
    $username = $arrayInput['uid'];
    $password = $arrayInput['pass'];

    $query = "SELECT * FROM `tbl_user` WHERE UserID='$username' AND `Password`=md5('$password')";
    $result = Sql_exec($cn, $query);

    $row = Sql_fetch_array($result);

    $return_data = array();
    if (!empty($row)) {
        $data['read'] = array();
        $data['read']['UserID'] = $row['UserID'];
        $data['read']['UserName'] =$row['UserName'];
        $data['read']['UserType'] = $row['UserType'];
        $data['read']['layoutId']=2;
        $data['read']['fund'] = 0;

        $return_data = array( 'status' => true, 'msg' => "You have been logged in successfully.",'read'=>$data['read']);

        $_SESSION['UserType'] =$row['UserType'];
        $_SESSION['UserID'] = $row['UserID'];
	 	$_SESSION['UserName'] = $row['UserName'];
        $_SESSION['role']='admin';
    } else {
        $return_data = array('status' => false, 'message' => "Username and password does not match.");

    }
}

echo json_encode($return_data);

Sql_Free_Result($result);
ClosedDBConnection($cn);





