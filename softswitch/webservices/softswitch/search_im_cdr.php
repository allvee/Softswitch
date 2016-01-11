<?php
session_start();
include_once "../lib/common.php";

$data = $_POST['info'];

$cn = connectDB();


$slno = mysql_real_escape_string(htmlspecialchars($data['slno']));
$callId = mysql_real_escape_string(htmlspecialchars($data['callId']));
$ano = mysql_real_escape_string(htmlspecialchars($data['ano']));
$bno = mysql_real_escape_string(htmlspecialchars($data['bno']));
$call_start_time = mysql_real_escape_string(htmlspecialchars($data['call_start_time']));
$call_end_time = mysql_real_escape_string(htmlspecialchars($data['call_end_time']));
$machine_id = mysql_real_escape_string(htmlspecialchars($data['machine_id']));
$isConnected = mysql_real_escape_string(htmlspecialchars($data['isConnected']));
$cause_val = mysql_real_escape_string(htmlspecialchars($data['cause_val']));
$cost = mysql_real_escape_string(htmlspecialchars($data['cost']));
$start_point = 0;
$per_page = 5000;


$remoteCnQry = "select * from tbl_process_db_access where pname='SOFTSWITCH'";
$res = Sql_exec($cn, $remoteCnQry);
$dt = Sql_fetch_array($res);
//remote connection parameter set up

$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];

ClosedDBConnection($cn);// close current connection
$remoteCn = connectDB();

$qry = "CALL SP_CDR('" . $slno . "','" . $callId . "','" . $ano . "','" . $bno . "','" . $call_start_time . "','" . $call_end_time . "','" . $machine_id . "','" . $isConnected . "','" . $cause_val . "','" . $cost . "','" . $start_point . "','" . $per_page . "');";


$res = Sql_exec($remoteCn, $qry);


$data_ = array();
$i = 0;

while ($row = Sql_fetch_array($res)) {

    $j = 0;
    $data_[$i][$j++] = $row[0];
    $data_[$i][$j++] = $row[1];
    $data_[$i][$j++] = $row[2];
    $data_[$i][$j++] = $row[3];
    $data_[$i][$j++] = $row[4];
    $data_[$i][$j++] = $row[5];
    $data_[$i][$j++] = $row[6];
    $data_[$i][$j++] = $row[7];
    $data_[$i][$j++] = $row[8];
    $data_[$i][$j++] = $row[9];

    /*$data_[$i][$j++] = Sql_Result($row, "slno");
    $data_[$i][$j++] = Sql_Result($row, "callId");
    $data_[$i][$j++] = Sql_Result($row, "ano");
    $data_[$i][$j++] = Sql_Result($row, "bno");
    $data_[$i][$j++] = Sql_Result($row, "call_start_time");
    $data_[$i][$j++] = Sql_Result($row, "call_end_time");
    $data_[$i][$j++] = Sql_Result($row, "machine_id");
    $data_[$i][$j++] = Sql_Result($row, "isConnected");
    $data_[$i][$j++] = Sql_Result($row, "cause_val");
    $data_[$i][$j++] = Sql_Result($row, "cost");*/

    $i++;
}
Sql_Free_Result($res);
echo json_encode($data_);

ClosedDBConnection($remoteCn);


?>
