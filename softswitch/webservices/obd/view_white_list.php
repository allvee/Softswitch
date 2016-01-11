<?php
include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "SELECT @rn:=@rn+1 AS `Serial`,`t1`.`Date`,`t1`.`Time`,`t1`.`server_id`,`t1`.`cnt` , REPLACE(REPLACE(CONCAT(`t1`.`Date`, 'T', `t1`.`Time`, 'S',  `t1`.`server_id`), '-', 'D'), ':', 'C') AS `key`" .
				"FROM " .
				"(SELECT DATE(`time_stamp`) AS `Date`, TIME(`time_stamp`) AS `Time`, `server_id`, COUNT(DISTINCT `msisdn`) AS `cnt`" .
				"FROM `tbl_obd_white_list` " .
				/*"WHERE `user_id`='".$user_id."' " .*/
				"GROUP BY `server_id`, DATE(`time_stamp`), TIME(`time_stamp`)" .
				"ORDER BY `server_id` DESC, DATE(`time_stamp`) ASC, TIME(`time_stamp`) ASC " .
				" ) AS `t1`,
				(SELECT @rn := 0) AS `t2`";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "Serial");
    $data[$i][$j++] = Sql_Result($row, "Date");
    $data[$i][$j++] = Sql_Result($row, "Time");

    $data[$i][$j++] = Sql_Result($row, "server_id");
    $data[$i][$j++] = Sql_Result($row, "cnt");
	$generate_id = str_replace('-', 'D', Sql_Result($row, "Date"));
    $generate_id .= 'T'. str_replace(':', 'C', Sql_Result($row, "Time"));
    $generate_id .= 'S'. Sql_Result($row, "server_id");

	$data[$i][$j++] = '<span onclick="download_obd_white(this,'."'".$generate_id."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/download.png" ></span>'.'&nbsp&nbsp'.'<span  onclick="delete_obd_white(this,'."'".$generate_id."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>
