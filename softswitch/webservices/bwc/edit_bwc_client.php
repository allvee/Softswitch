<?php
//session_start();
header('Access-Control-Allow-Origin: *');
require_once "../lib/common.php";
if (isset($_REQUEST['info'])) {
    $data = $_REQUEST['info'];
    $action_id = $data['action_id'];
}
$cn = connectDB();
$qry = "select * from bwc_clientinfo where is_active='active' and clientId='$action_id'";
$rs = Sql_exec($cn,$qry);
$data = "";

$client_info =  array();

$i=0;
while($row = mysql_fetch_assoc($rs)){
    $client_info = $row;
}

$client_info['rules'] =  array();

$select_rules = "select * from bwc_ruleinfo where is_active='active' and clientId='$action_id'";
//echo $select_rules;
$rs_rules = Sql_exec($cn, $select_rules);
if ($rs_rules) {

     while($row = mysql_fetch_assoc($rs_rules)) {
         $client_info['rules'][] = $row;
     }

}


ClosedDBConnection($cn);

echo json_encode($client_info);

?>