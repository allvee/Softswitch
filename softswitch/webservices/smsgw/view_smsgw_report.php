<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/21/2015
 * Time: 7:34 PM
 */

include_once "../lib/common.php";
$remoteCn=remote_connectDB('SMSGW');
 $arrayInput = array();

$query = "SELECT 	MobileNo, MsgText, ShortCode, Keyword,SentReply,  RequestDateTime	FROM 	requestlog ";
$result = Sql_exec($remoteCn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "MobileNo");
    $data[$i][$j++] = Sql_Result($row, "MsgText");
    $data[$i][$j++] = Sql_Result($row, "ShortCode");
    $data[$i][$j++] = Sql_Result($row, "Keyword");
    $data[$i][$j++] = Sql_Result($row, "SentReply");
    $data[$i][$j++] = Sql_Result($row, "RequestDateTime");
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($remoteCn);
echo json_encode($data);

?>
