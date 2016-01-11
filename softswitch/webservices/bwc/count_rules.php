<?php

header('Access-Control-Allow-Origin: *');

require_once "../lib/common.php";
$cn = connectDB();
$data = "";
$count = 0;

$client_id = $_REQUEST['client_id'];

$select_rules = "select * from bwc_ruleinfo where is_active='active' and clientId='$client_id'";
$rs_rules = Sql_exec($cn, $select_rules);
if ($rs_rules) {
    $count = Sql_Num_Rows($rs_rules);
}

ClosedDBConnection($cn);

echo $count;
?>