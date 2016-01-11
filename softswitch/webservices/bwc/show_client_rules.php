<?php
//session_start();
header('Access-Control-Allow-Origin: *');
require_once "../lib/common.php";
//require_once "../Lib/filewriter.php";



//print_r($info);
//print_r($_SESSION);
//exit;
//
$cid=$_POST["info"];
//echo $cid;
$cn = connectDB();
//$qry = "select * from `bwc_ruleinfo`";
$qry = "select * from `bwc_ruleinfo` where `clientId`='$cid'";
$rs = Sql_exec($cn,$qry);
$data = array();
$i=0;
while($row = Sql_fetch_array($rs)){

    $j=0;
    $data[$i][$j++] = Sql_Result($row, "ruleId");
    $data[$i][$j++] = Sql_Result($row, "src");
    $data[$i][$j++] = Sql_Result($row, "dst");
    $data[$i][$j++] = Sql_Result($row, "port");
    $data[$i][$j++] = Sql_Result($row, "mac");
    $data[$i][$j++] = Sql_Result($row, "percentage");
    $i++;
}



echo json_encode($data);
ClosedDBConnection($cn);


?>