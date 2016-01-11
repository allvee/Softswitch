<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/21/2015
 * Time: 4:56 PM
 */

include_once "../lib/common.php";
$remoteCn=remote_connectDB('SMSGW');
$arrayInput = array();

$query = "SELECT `Shortcode`,`ServiceID`, `Tps`,  `SMSClientID`,`id` FROM `tps`";
$result = Sql_exec($remoteCn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "Shortcode");
    $data[$i][$j++] = Sql_Result($row, "ServiceID");
    $data[$i][$j++] = Sql_Result($row, "Tps");
    $data[$i][$j++] = Sql_Result($row, "SMSClientID");
    $data[$i][$j++] = '<span  onclick="edit_input_form_smsgw_tps(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_smsgw_tps(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($remoteCn);
echo json_encode($data);

?>