<?php

require_once "../lib/common.php";

$value = '<option value="0" disabled="disabled" selected="selected">Account Holder</option>';

$remoteCn = remote_connectDB('ISMP');
$qry = "select `id`,`acc_name` from `tbl_smsgw_account` where `is_active`='active'";

$res = Sql_exec($remoteCn,$qry);
while($dt = Sql_fetch_array($res)){
		$value .= '<option value="'.$dt['id'].'">'.$dt['acc_name'].'</option>';
}
	
ClosedDBConnection($remoteCn);

echo $value;

?>