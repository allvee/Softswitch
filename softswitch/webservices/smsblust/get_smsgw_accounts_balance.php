<?php

require_once "../lib/common.php";
$info = $_POST['info'];
$remoteCn = remote_connectDB('ISMP');
$id = mysql_real_escape_string(htmlspecialchars($info['acc_name']));
$balance = 0;
$qry = "select balance from tbl_smsgw_account where is_active='active' and id='$id'";

	
    $res = Sql_exec($remoteCn,$qry);
	$dt = Sql_fetch_array($res);
	$balance = $dt['balance'];
	
ClosedDBConnection($remoteCn);
	
	echo $balance;
?>