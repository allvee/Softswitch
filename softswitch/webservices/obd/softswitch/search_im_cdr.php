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
   
   
                $qry = "CALL SP_CDR('".$slno."','".$callId."','".$ano."','".$bno."','".$call_start_time."','".$call_end_time."','".$machine_id."','".$isConnected."','".$cause_val."','".$cost."','".$start_point."','".$per_page."');";
				
                $res = Sql_exec($cn,$qry);

$data_ = array();
$i=0;

while ($row = Sql_fetch_array($res)) {
    $j=0;
                
				 $data_[$i][$j++] = Sql_Result($row, "slno");
				 $data_[$i][$j++] = Sql_Result($row, "callId");
				 $data_[$i][$j++] = Sql_Result($row, "ano");
				 $data_[$i][$j++] = Sql_Result($row, "bno");
				 $data_[$i][$j++] = Sql_Result($row, "call_start_time");
				 $data_[$i][$j++] = Sql_Result($row, "call_end_time");
				 $data_[$i][$j++] = Sql_Result($row, "machine_id");
				 $data_[$i][$j++] = Sql_Result($row, "isConnected");
				 $data_[$i][$j++] = Sql_Result($row, "cause_val");
				 $data_[$i][$j++] = Sql_Result($row, "cost");

	$i++;
}
Sql_Free_Result($res);
echo json_encode($data_);
                
ClosedDBConnection($cn);             


?>
