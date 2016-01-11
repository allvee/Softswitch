<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/5/2015
 * Time: 7:49 PM
 */

include_once "../lib/common.php";
$remoteCn=remote_connectDB('SMSGW');
 $arrayInput = array();

$query = "SELECT `ShortCode`,`Keyword`,`ServiceID`,`SubServiceID`,`SourceType`,`URL`,`Status`,`id` FROM `service`";
$result = Sql_exec($remoteCn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "ShortCode");
    $data[$i][$j++] = Sql_Result($row, "Keyword");
    $data[$i][$j++] = Sql_Result($row, "ServiceID");
    $data[$i][$j++] = Sql_Result($row, "SubServiceID");
    $data[$i][$j++] = Sql_Result($row, "SourceType");
    $data[$i][$j++] = Sql_Result($row, "URL");
    $data[$i][$j++] = Sql_Result($row, "Status");
    $data[$i][$j++] = '<span  onclick="edit_input_form_smsgw_service(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_smsgw_service(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($remoteCn);
echo json_encode($data);

?>
