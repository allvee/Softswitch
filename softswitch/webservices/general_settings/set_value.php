<?php
include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select host_name,server1,server2 from tbl_dns_servers";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {

    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "host_name");
    $data[$i][$j++] = Sql_Result($row, "server1");
    $data[$i][$j++] = Sql_Result($row, "server2");
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>