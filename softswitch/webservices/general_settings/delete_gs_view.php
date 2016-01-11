<?php

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select host_name,IP from tbl_hosts";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "host_name");
    $data[$i][$j++] = Sql_Result($row, "IP");
    $data[$i][$j++] =  '<span onclick="gs_delete(this,'."'" . Sql_Result($row, "host_name") . "'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>
